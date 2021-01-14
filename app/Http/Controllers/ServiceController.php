<?php

namespace App\Http\Controllers;

use App\Http\Requests\ServiceRequest;
use App\Models\mongo\Service;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Service $services
     * @return Factory|JsonResponse|View
     */
    public function index(Service $services)
    {
        if (request()->ajax()) {
            return $services::dataTable()->toJson();
        }

        return view('layouts.dataTable.index', [
            'html' => $services->html(),
            'breadcrumb' => 'Сервисы',
            'url_create' => route('services.create'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Service $service
     * @return Factory|View
     */
    public function create(Service $service)
    {
        return view('services.form', compact('service'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ServiceRequest $request
     * @return RedirectResponse|Redirector
     */
    public function store(ServiceRequest $request)
    {
        Service::createFromRequest($request);
        return redirect(route('services.index'))->with('success', 'Успех');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Service $service
     * @return Factory|View
     */
    public function edit(Service $service)
    {
        return view('services.form', compact('service'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ServiceRequest $request
     * @param Service $service
     * @return RedirectResponse|Redirector
     */
    public function update(ServiceRequest $request, Service $service)
    {
        $service->update($request->input());
        return redirect(route('services.index'))->with('success', 'Обновлено');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Service $service
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(Service $service)
    {
        $service->delete();
        return redirect()->route('services.index')
            ->with('alert', 'Удален');
    }
}
