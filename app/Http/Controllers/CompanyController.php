<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyRequest;
use App\Models\mongo\Company;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Company $companies
     * @return Factory|JsonResponse|View
     */
    public function index(Company $companies)
    {
        if (request()->ajax()) {
            return $companies::dataTable()->toJson();
        }

        return view('layouts.dataTable.index', [
            'html' => $companies->html(),
            'breadcrumb' => 'Компании',
            'url_create' => route('companies.create'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Company $company
     * @return Factory|View
     */
    public function create(Company $company)
    {
        return view('company.form', compact('company'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CompanyRequest $request
     * @return RedirectResponse|Redirector
     */
    public function store(CompanyRequest $request)
    {
        $user = auth()->user();
        $user->companies()->create($request->input());

        return redirect(route('company.index'))->with('success', 'Успех');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Company $company
     * @return Factory|View
     */
    public function edit(Company $company)
    {
        return view('company.form', compact('company'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CompanyRequest $request
     * @param Company $company
     * @return RedirectResponse|Redirector
     */
    public function update(CompanyRequest $request, Company $company)
    {
        $company->update($request->input());
        return redirect(route('companies.index'))->with('success', 'Обновлен');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Company $company
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(Company $company)
    {
        $company->delete();
        return redirect()->route('company.index')
            ->with('success', 'Удален');
    }
}
