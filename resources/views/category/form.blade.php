@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Форма Category</h5>
            </div>
            {!! Form::model($category, [
            'url' => route('category.update', ['_id' => $category->_id]),
            'method' => $category->_id ? 'PUT' : 'POST']) !!}
            <div class="card-body">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-3">
                        <div class="form-group-lg">
                            <label>_id</label>
                            {!! Form::text('_id', null, ['class'=>'form-control input-lg', $category->_id ? 'disabled' : '']) !!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-3">
                        <div class="form-group-lg">
                            <label>name</label>
                            {!! Form::text('name', null, ['class'=>'form-control input-lg']) !!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-3">
                        <div class="form-group-lg">
                            <label>company_id</label>
                            @if(empty($category->company_id))
                                @foreach(\App\Models\mongo\Company::all()->sortBy('name') as $company)
                                    <input type="hidden" name="company_id">
                                    <div class="form-check">
                                        {{ Form::checkbox('company_id', $company->_id, null, [
                                                "class"=> "form-check-input",
                                                'type'=>"checkbox",
                                                "id"=> $company->_id,
                                            ]) }}
                                        <label class="form-check-label" for="{{ $company->_id }}">
                                            {{ $company->name }} <a href="{{ route('companies.edit', $company->_id) }}">*</a>
                                        </label>
                                    </div>
                                @endforeach
                            @else
                                {!! Form::text('company_id', null, ['class'=>'form-control input-lg']) !!}
                            @endif
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-3">
                        <div class="form-group-lg">
                            <input type="hidden" name="service_ids">
                            @foreach(\App\Models\mongo\Service::all()->sortBy('name') as $service)
                                <div class="form-check">
                                    {{ Form::checkbox('service_ids[]', $service->_id, null, [
                                            "class"=> "form-check-input",
                                            'type'=>"checkbox",
                                            "id"=> $service->_id,
                                        ]) }}
                                    <label class="form-check-label" for="{{ $service->_id }}">
                                        {{ $service->name }} <a href="{{ route('services.edit', $service->_id) }}">*</a>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                </div>
            </div>
            @include('layouts.ui.buttons-return-save', ['route' => route('category.index')])
            {!! Form::close() !!}
        </div>
    </div>
@endsection
