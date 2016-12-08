<?php

/*
 * @author Phillip Madsen
 */

namespace App\Http\Controllers\Admin;

use App\Exceptions\Validation\ValidationException;
use App\Http\Controllers\Controller;
use App\Models\Section;
use App\Repositories\Category\CategoryInterface;
use App\Repositories\Category\CategoryRepository as Category;
use App\Services\Pagination;
use Flash;
use Input;
use View;

/**
 * Class CategoryController.
 *
 * @author Phillip Madsen <contact@affordableprogrammer.com>
 */
class CategoryController extends Controller
{
    protected $category;
    protected $perPage;

    public function __construct(CategoryInterface $category)
    {
        $this->category = $category;
        View::share('active', 'blog');
        $this->perPage = config('grace.modules.category.per_page');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $pagiData = $this->category->paginate(Input::get('page', 1), $this->perPage, true);
        $categories = Pagination::makeLengthAware($pagiData->items, $pagiData->totalItems, $this->perPage);

        return view('backend.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $sections_all = Section::all();
        $sections = [];
        foreach ($sections_all as $row) {
            $sections[$row->id] = $row->name;
        }

        return view('backend.categories.create', compact('sections'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        try {
            $this->category->create(Input::all());
            Flash::message('Category was successfully added');

            return langRedirectRoute('admin.category.index');
        } catch (ValidationException $e) {
            return langRedirectRoute('admin.category.create')->withInput()->withErrors($e->getErrors());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $category = $this->category->find($id);

        return view('backend.categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $category = $this->category->find($id);
        $sections_all = Section::all();
        $sections = [];
        foreach ($sections_all as $row) {
            $sections[$row->id] = $row->name;
        }

        return view('backend.categories.edit', compact('category', 'sections'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function update($id)
    {
        try {
            $this->category->update($id, Input::all());
            Flash::message('Category was successfully updated');

            return langRedirectRoute('admin.category.index');
        } catch (ValidationException $e) {
            return langRedirectRoute('admin.category.edit')->withInput()->withErrors($e->getErrors());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $this->category->delete($id);
        Flash::message('Category was successfully deleted');

        return langRedirectRoute('admin.category.index');
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function confirmDestroy($id)
    {
        $category = $this->category->find($id);

        return view('backend.categories.confirm-destroy', compact('category'));
    }
}
