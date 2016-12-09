<?php

namespace app\Http\Controllers;

use App;
use App\Http\Controllers\Controller;
use App\Models\AlbumPhoto;
use App\Models\Alert;
use App\Models\Cart;
use App\Models\Category;
use App\Models\CategoryProduct;
use App\Models\Option;
use App\Models\OptionValue;
use App\Models\OrderProduct;
use App\Models\Product;
use App\Models\ProductFeature;
use App\Models\ProductRequirement;
use App\Models\ProductVariant;
use Config;
use Ecommerce\helperFunctions;
use File;
use Illuminate\Http\Request;
use Input;
use Intervention\Image\ImageManagerStatic as Image;
use Response;
use View;

class ProductController extends Controller
{
    protected $width;
    protected $height;
    protected $thumbWidth;
    protected $thumbHeight;
    protected $loopWidth;
    protected $loopHeight;
    protected $shopLoopWidth;
    protected $shopLoopHeight;

    protected $imgDir;
    protected $thumbDir;
    protected $loopDir;
    protected $shopLoopDir;

    protected $perPage;
    protected $product;
    protected $productrequirements;
    protected $productfeatures;
    protected $alerts;
    protected $productvariants;
    protected $options;
    protected $optionvalues;

    public function __construct(
        Request $request,
        Product $product,
        ProductRequirement $productrequirements,
        ProductFeature $productfeatures,
        Alert $alerts,
        ProductVariant $productvariants,
        Option $options,
        OptionValue $optionvalues
    ) {
        $config = Config::get('grace');
        $this->perPage = $config['per_page'];
        $this->width = $config['modules']['product']['image_size']['width'];
        $this->height = $config['modules']['product']['image_size']['height'];
        $this->thumbWidth = $config['modules']['product']['thumb_size']['width'];
        $this->thumbHeight = $config['modules']['product']['thumb_size']['height'];
        $this->shopLoopWidth = $config['modules']['product']['shop_size']['width'];
        $this->shopLoopHeight = $config['modules']['product']['shop_size']['height'];
        $this->loopWidth = $config['modules']['product']['loop_size']['width'];
        $this->loopHeight = $config['modules']['product']['loop_size']['height'];
        $this->imgDir = $config['modules']['product']['image_dir'];
        $this->thumbDir = $config['modules']['product']['thumb_dir'];
        $this->loopDir = $config['modules']['product']['loop_dir'];
        $this->shopLoopDir = $config['modules']['product']['shop_dir'];
        $this->product = $product;
        $this->productFeatures = $productfeatures;
        $this->productRequirements = $productrequirements;
        $this->productVariants = $productvariants;
        $this->alerts = $alerts;
        $this->options = $options;
        $this->optionValues = $optionvalues;
    }

    public function index()
    {
        $new_products = Product::orderBy('created_at', 'desc')->take(12)->get();
        $randomProducts = Product::orderByRaw('RAND()')->take(12)->get();

        $categories = Category::lists('title', 'id');

        $get_best_sellers = OrderProduct::select('product_id', \DB::raw('COUNT(product_id) as count'))->groupBy('product_id')->orderBy('count', 'desc')->take(8)->get();
        $best_sellers = [];
        foreach ($get_best_sellers as $product) {
            $best_sellers[] = $product->product;
        }

        helperFunctions::getCartInfo($cart, $total);

        return view('frontend.shop.index', compact('categories', 'new_products', 'randomProducts', 'best_sellers', 'cart', 'total'));
    }

    public function show($param)
    {
        $product = Product::where('id', $param)->orWhere('slug', $param)->firstOrFail();
        $new_products = Product::orderBy('created_at', 'desc')->take(3)->get();
        $categories = Category::lists('title', 'id');
        $product_categories = $product->categories()->lists('title')->toArray();
        // $similair = Category::find($product_categories[array_rand($product_categories)])->products()->whereNotIn('id', array($id))->orderByRaw("RAND()")->take(6)->get();
        // dd($product, $product->features, $product->categories, $product->prices, $product->options, $product->variants);

        helperFunctions::getCartInfo($cart, $total);

        return view('frontend.shop.layouts.product-lsb', compact('product', 'new_products', 'similair', 'cart', 'total', 'categories'));
    }

    public function store(Request $request)
    {
        /*
         * Validate the submitted Data
         */
        $this->validate($request, [
            'name'      => 'required',
            'thumbnail' => 'required|image',
        ]);

        if ($request->hasFile('album')) {
            foreach ($request->album as $photo) {
                if ($photo && strpos($photo->getMimeType(), 'image') === false) {
                    return \Redirect()->back();
                }
            }
        }

        /**
         * Upload a new thumbnail.
         */
        $dest = 'uploads/products';

        $destinationPath = public_path().$this->imgDir;
        $destinationThumbPath = public_path().$this->thumbDir;
        $destinationLoopPath = public_path().$this->loopDir;
        $destinationShopLoopPath = public_path().$this->shopLoopDir;

        File::exists($destinationPath) or File::makeDirectory($destinationPath);
        File::exists($destinationThumbPath) or File::makeDirectory($destinationThumbPath);
        File::exists($destinationLoopPath) or File::makeDirectory($destinationLoopPath);
        File::exists($destinationShopLoopPath) or File::makeDirectory($destinationShopLoopPath);

        $name = $request->file('thumbnail')->getClientOriginalName();
        $from = $request->file('thumbnail');
        Image::make($from)->resize($this->width, $this->height)->save($destinationPath.$name);
        Image::make($from)->resize($this->thumbWidth, $this->thumbHeight, function ($constraint) {
            $constraint->upsize();
        })->save($destinationThumbPath.$name);
        Image::make($from)->resize($this->loopWidth, $this->loopHeight, function ($constraint) {
            $constraint->upsize();
        })->save($destinationLoopPath.$name);
        Image::make($from)->fit($this->shopLoopWidth, $this->shopLoopHeight, function ($constraint) {
            $constraint->upsize();
        })->save($destinationShopLoopPath.$name);
        Image::make($from)->resize($this->shopLoopWidth, $this->shopLoopHeight, function ($constraint) {
            $constraint->upsize();
        })->save($destinationShopLoopPath.'/fit/'.$name);

        $request->file('thumbnail')->move($destinationPath, $name);

        $product = $request->all();
        $product['thumbnail'] = $name;

        //--------------------------------------------------------

        $product = Product::create($product);

        /*
         * Upload Album Photos
         */
        if ($request->hasFile('album')) {
            foreach ($request->album as $photo) {
                if ($photo) {
                    $name = $photo->getClientOriginalName();
                    $photo->move($dest, $name);
                    AlbumPhoto::create([
                        'product_id' => $product->id,
                        'photo_src'  => '/'.$dest.'/'.$name,
                    ]);
                }
            }
        }

        /*
         * Linking the categories to the product
         */
        foreach ($request->categories as $category_id) {
            CategoryProduct::create(['category_id' => $category_id, 'product_id' => $product->id]);
        }

        /*
         * Linking the options to the product
         */
        if ($request->has('options')) {
            foreach ($request->options as $option_details) {
                if (!empty($option_details['name']) && !empty($option_details['values'][0])) {
                    $option = Option::create([
                        'name'       => $option_details['name'],
                        'product_id' => $product->id,
                    ]);
                    foreach ($option_details['values'] as $value) {
                        OptionValue::create([
                            'value'     => $value,
                            'option_id' => $option->id,
                        ]);
                    }
                }
            }
        }

//         if($request->has('alerts')){
//             foreach($request->alerts as $productAlert => $alertValues){
//                 foreach($alertValues as $k => $v){
//                     //$alert = Alert::findOrFail($request->alerts['id'][$v])

//                     $alert = new App\Models\Alert();
//                     $alert->alert_title = $request->alerts['title'][$v];
//                     $alert->alert_message = $request->alerts['message'][$v];
//                     $alert->alerticon = $request->alerts['alerticon'][$v];
//                     $alert->alertstyle = $request->alerts['alertstyle'][$v];
//                     $alert->alerttype = $request->alerts['alerttype'][$v];
//                     $alert->product_id = $product->id;
// //                    $alert->save();
//                     $product->alerts()->save($alert);
//                 }
//             }
//         }

        if (!empty($request->attribute_name)) {
            foreach ($request->attribute_name as $key => $item) {
                $productVariant = new ProductVariant();
                $productVariant->attribute_name = $item;
                $productVariant->product_attribute_value = $request->product_attribute_value[$key];
                $product->productVariants()->save($productVariant);
            }
        }

        if (!empty($request->requirement)) {
            foreach ($request->requirement as $key => $item) {
                $productRequirement = new ProductRequirement();
                $productRequirement->requirement = $item;
                $productRequirement->requirement_value = $request->requirement_value[$key];
                $product->productRequirements()->save($productRequirement);
            }
        }

        if (!empty($request->feature_name)) {
            foreach ($request->feature_name as $feature) {
                $productFeature = new ProductFeature();
                $productFeature->feature_name = $feature['feature_name'];
                $productFeature->useicon = $feature['useicon'];
                $productFeature->icon = $feature['icon'];
                $product->productFeatures()->save($productFeature);
            }
        }

        FlashAlert()->success('Success!', 'The Product Was Successfully Added');

        return \Redirect(getLang().'/admin/products');
    }

    public function edit(Request $request, $id)
    {
        $product = Product::find($id);

        /*
         * Validate the submitted Data
         */
        $this->validate($request, [
            'name'      => 'required',
            'thumbnail' => 'image',
        ]);

        if ($request->hasFile('album')) {
            foreach ($request->album as $photo) {
                if ($photo && strpos($photo->getMimeType(), 'image') === false) {
                    return \Redirect()->back();
                }
            }
        }

        /**
         * Remove the old categories from the pivot table and maintain the reused ones.
         */
        $added_categories = [];

        foreach ($product->categories as $category) {
            if (!in_array($category->id, $request->categories)) {
                CategoryProduct::whereProduct_id($product->id)->whereCategory_id($category->id)->delete();
            } else {
                $added_categories[] = $category->id;
            }
        }

        /*
         * Link the new categories to the pivot table
         */
        foreach ($request->categories as $category_id) {
            if (!in_array($category_id, $added_categories)) {
                CategoryProduct::create(['category_id' => $category_id, 'product_id' => $product->id]);
            }
        }

        $info = $request->all();

        /*
         * Upload a new thumbnail and delete the old one
         */
        if ($request->file('thumbnail')) {
            $destinationPath = public_path().$this->imgDir;
            $destinationThumbPath = public_path().$this->thumbDir;
            $destinationLoopPath = public_path().$this->loopDir;
            $destinationShopLoopPath = public_path().$this->shopLoopDir;

        // dd("PATH: " .$destinationPath,"THUMB PATH: ". $destinationThumbPath, "SHOP PATH: " .$destinationShopLoopPath, "LOOP PATH: " .$destinationLoopPath);

            File::delete($destinationPath.$product->thumbnail);
            File::delete($destinationThumbPath.$product->thumbnail);
            File::delete($destinationLoopPath.$product->thumbnail);
            File::delete($destinationShopLoopPath.$product->thumbnail);

            $name = $request->file('thumbnail')->getClientOriginalName();
            $from = $request->file('thumbnail');
            Image::make($from)->resize($this->width, $this->height)->save($destinationPath.$name);
            Image::make($from)->resize($this->thumbWidth, $this->thumbHeight, function ($constraint) {
                $constraint->upsize();
            })->save($destinationThumbPath.$name);
            Image::make($from)->resize($this->loopWidth, $this->loopHeight, function ($constraint) {
                $constraint->upsize();
            })->save($destinationLoopPath.$name);
            Image::make($from)->fit($this->shopLoopWidth, $this->shopLoopHeight, function ($constraint) {
                $constraint->upsize();
            })->save($destinationShopLoopPath.$name);
            $request->file('thumbnail')->move($destinationPath, $name);
            $info['thumbnail'] = $name;
        }

        $dest = 'uploads/products';
        /*
         * Upload Album Photos
         */
        if ($request->hasFile('album')) {
            foreach ($request->album as $photo) {
                if ($photo) {
                    $name = str_random(11).'_'.$photo->getClientOriginalName();
                    $photo->move($dest, $name);
                    AlbumPhoto::create([
                        'product_id' => $product->id,
                        'photo_src'  => '/'.$dest.$name,
                    ]);
                }
            }
        }

        $product->update($info);

        /*
         * Linking the options to the product
         */
        if ($request->has('options')) {
            foreach ($request->options as $option_details) {
                if (!empty($option_details['name']) && !empty($option_details['values']['name'][0])) {
                    if (isset($option_details['id'])) {
                        $size = count($option_details['values']['id']);
                        Option::find($option_details['id'])->update(['name' => $option_details['name']]);

                        foreach ($option_details['values']['name'] as $key => $value) {
                            if ($key < $size) {
                                OptionValue::find($option_details['values']['id'][$key])->update(['value' => $value]);
                            } else {
                                OptionValue::create([
                                    'value'     => $value,
                                    'option_id' => $option_details['id'],
                                ]);
                            }
                        }
                    } else {
                        $option = Option::create([
                                    'name'       => $option_details['name'],
                                    'product_id' => $product->id,
                        ]);

                        foreach ($option_details['values']['name'] as $value) {
                            if (!empty($value)) {
                                OptionValue::create([
                                    'value'     => $value,
                                    'option_id' => $option->id,
                                ]);
                            }
                        }
                    }
                }
            }
        }

        // if($request->has('alerts')){
        //     foreach($request->alerts as $productAlert => $alertValues){
        //         foreach($alertValues as $k => $v){
        //             $alert = Alert::find($request->alerts['id'][$v])
        //             $alert->title = $request->alerts['title'][$v];
        //             $alert->message = $request->alerts['message'][$v];
        //             $alert->alerticon = $request->alerts['alerticon'][$v];
        //             $alert->alertstyle = $request->alerts['alertstyle'][$v];
        //             $alert->alerttype = $request->alerts['alerttype'][$v];
        //             $alert->product_id = $product->id;
        //             $product->alerts()->save($alert);
        //         }
        //     }
        // }

        if (!empty($request->attribute_name)) {
            foreach ($request->attribute_name as $key => $item) {
                $productVariant = new ProductVariant();
                $productVariant->attribute_name = $item;
                $productVariant->product_attribute_value = $request->product_attribute_value[$key];
                $product->productVariants()->save($productVariant);
            }
        }

        if (!empty($request->requirement)) {
            foreach ($request->requirement as $key => $item) {
                $productRequirement = new ProductRequirement();
                $productRequirement->requirement = $item;
                $productRequirement->requirement_value = $request->requirement_value[$key];
                $product->productRequirements()->save($productRequirement);
            }
        }

        if (!empty($request->feature_name)) {
            foreach ($request->feature_name as $feature) {
                $productFeature = new ProductFeature();
                $productFeature->feature_name = $feature;
                $product->productFeatures()->save($productFeature);
            }
        }

        FlashAlert()->success('Success!', 'The Product Was Successfully Updated');

        return \Redirect()->back();
    }

    /**
     * @param $id
     */
    public function delete($id)
    {
        $product = Product::find($id);

        File::delete(public_path().$product->thumbnail);
        CategoryProduct::whereProduct_id($id)->delete();
        $product->delete();

        return \Redirect::back();
    }

    /**
     * @param $id
     * @param $photo_id
     */
    public function deletePhoto($id, $photo_id)
    {
        $photo = AlbumPhoto::find($photo_id);
        File::delete(public_path().$photo->photo_src);
        AlbumPhoto::destroy($photo_id);

        return \Redirect()->back();
    }

    /**
     * @param $id
     */
    public function deleteOption($id)
    {
        Option::destroy($id);

        return \Redirect()->back();
    }

    /**
     * @param $id
     */
    public function deleteOptionValue($id)
    {
        OptionValue::destroy($id);

        return \Redirect()->back();
    }

    /**
     * @param Request $request
     */
    public function search(Request $request)
    {
        if (strtoupper($request->sort) == 'NEWEST') {
            $products = Product::where('name', 'like', '%'.$request->q.'%')->orderBy('created_at', 'desc')->paginate(40);
        } elseif (strtoupper($request->sort) == 'HIGHEST') {
            $products = Product::where('name', 'like', '%'.$request->q.'%')->orderBy('price', 'desc')->paginate(40);
        } elseif (strtoupper($request->sort) == 'LOWEST') {
            $products = Product::where('name', 'like', '%'.$request->q.'%')->orderBy('price', 'asc')->paginate(40);
        } else {
            $products = Product::where('name', 'like', '%'.$request->q.'%')->paginate(40);
        }

        helperFunctions::getCartInfo($cart, $total);
        $query = $request->q;

        return view('frontend.search', compact('cart', 'total', 'products', 'query'));
    }

    private function getProductVariants($variants = [])
    {
        if (isset($variants)) {
            $variants = array_map(
                    function ($v) {
                        return explode(':', $v);
                    }, explode(',', $variants)
            );
        }

        return $variants;
    }

    private function getAlerts($alerts = [])
    {
        if (isset($alerts)) {
            $alerts = array_map(
                    function ($v) {
                        return explode(':', $v);
                    }, explode(',', $alerts)
            );
        }

        return $alerts;
    }

    private function getProductFeatures($features = [])
    {
        if (isset($features)) {
            $features = array_map(
                    function ($v) {
                        return explode(':', $v);
                    }, explode(',', $features)
            );
        }

        return $features;
    }

    /**
     * @param array $requirements
     *
     * @return mixed
     */
    private function getProductRequirements($requirements = [])
    {
        if (isset($requirements)) {
            $requirements = array_map(
                    function ($v) {
                        return explode(':', $v);
                    }, explode(',', $requirements)
            );
        }

        return $requirements;
    }

    /**
     * @param $key
     * @param null $default
     */
    public function input($key = null, $default = null)
    {
        $input = $this->getInputSource()->all();

        return data_get($input, $key, $default);
    }

    public function togglePublish($id)
    {
        $product = Product::find($id);

        $product->is_published = ($product->is_published) ? false : true;
        $product->save();

        return Response::json(['result' => 'success', 'changed' => ($product->is_published) ? 1 : 0]);
    }
}
