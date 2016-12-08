<?php

/*
 * @author Phillip Madsen
 */

namespace App\Http\Controllers;

use App\Repositories\Article\ArticleInterface;
use App\Repositories\Article\ArticleRepository as Article;
use App\Repositories\Category\CategoryInterface;
use App\Repositories\Category\CategoryRepository as Category;
use App\Repositories\Tag\TagInterface;
use App\Repositories\Tag\TagRepository as Tag;
use App\Services\Pagination;
use Ecommerce\helperFunctions;
use Illuminate\Http\Request;
use View;

/**
 * Class CategoryController.
 *
 * @author Phillip Madsen <contact@affordableprogrammer.com>
 */
class CategoryController extends Controller
{
    protected $article;
    protected $tag;
    protected $category;
    protected $perPage;

    public function __construct(ArticleInterface $article, TagInterface $tag, CategoryInterface $category)
    {
        View::share('active', 'cart');
        $this->article = $article;
        $this->tag = $tag;
        $this->category = $category;
        $this->perPage = config('grace.modules.category.per_page');
    }

    /**
     * Display a listing of the resource by slug.
     *
     * @param Request $request
     * @param $slug
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request, $slug)
    {
        $articles = $this->category->getArticlesBySlug($slug);

        $tags = $this->tag->all();
        $pagiData = $this->category->paginate($request->get('page', 1), $this->perPage, false);

        $categories = Pagination::makeLengthAware($pagiData->items, $pagiData->totalItems, $this->perPage);

        return view('frontend.category.index', compact('articles', 'tags', 'categories'))->with('cart', 'total');
    }

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

        return view('frontend.category.show', compact('cart', 'total', 'category', 'products'));
    }
}
