<?php



namespace app\Http\Controllers;

use App\Category;
use App\Http\Controllers\Controller;
use Ecommerce\helperFunctions;
use Illuminate\Http\Request;

class ProductCategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('isAdmin', ['except' => [
            'show',
        ]]);
    }

    /**
     * @param $id
     * @param Request $request
     */
    public function show($id, Request $request)
    {
        $category = Category::find($id);
        if (strtoupper($request->sort) == 'NEWEST') {
            $products = $category->products()->orderBy('created_at', 'desc')->paginate(40);
        } elseif (strtoupper($request->sort) == 'HIGHEST') {
            $products = $category->products()->orderBy('price', 'desc')->paginate(40);
        } elseif (strtoupper($request->sort) == 'LOWEST') {
            $products = $category->products()->orderBy('price', 'asc')->paginate(40);
        } else {
            $products = $category->products()->paginate(40);
        }
        helperFunctions::getCartInfo($cart, $total);

        return view('site.category', compact('cart', 'total', 'category', 'products'));
    }

    /**
     * @param $id
     */
    public function delete($id)
    {
        Category::destroy($id);

        return \Redirect('/admin/categories')->with([
            'flash_message' => 'Category has been Successfully removed',
            'flash-warning' => true,
        ]);
    }

    /**
     * @param Request $request
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name'       => 'required',
            'section_id' => 'required',
        ]);
        Category::create($request->all());

        return \Redirect('/admin/categories')->with([
            'flash_message' => 'Category successfully Created',
        ]);
    }

    /**
     * @param $id
     * @param Request $request
     */
    public function edit($id, Request $request)
    {
        $this->validate($request, [
            'name'       => 'required',
            'section_id' => 'required',
        ]);
        Category::find($id)->update($request->all());

        return \Redirect()->back()->with([
            'flash_message' => 'Category Successfully Edited',
        ]);
    }
}
