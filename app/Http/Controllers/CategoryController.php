<?php

namespace App\Http\Controllers;

use App\Models\mongo\Category;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Category $category
     * @return Factory|JsonResponse|View
     */
    public function index(Category $category)
    {
        if (request()->ajax()) {
            return $category::dataTable()->toJson();
        }

        return view('layouts.dataTable.index', [
            'html' => $category->html(),
            'breadcrumb' => 'Категории',
            'url_create' => route('category.create'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Category $category
     * @return Factory|View
     */
    public function create(Category $category)
    {
        return view('category.form', compact('category'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param Category $category
     * @return RedirectResponse|Redirector
     */
    public function store(Request $request)
    {
        Category::createFromRequest($request);
        return redirect(route('category.index'))->with('success', 'Успех');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Category $category
     * @return Factory|View
     */
    public function edit(Category $category)
    {
        return view('category.form', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Category $category
     * @return RedirectResponse|Redirector
     */
    public function update(Request $request, Category $category)
    {
        $category->update($request->input());
        return redirect(route('category.index'))->with('success', 'Обновлено');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Category $category
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('category.index')
            ->with('alert', 'Удален');
    }
}
