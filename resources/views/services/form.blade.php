@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Форма Service</h5>
            </div>
            {!! Form::model($service, [
            'url' => route('services.update', ['_id' => $service->_id]),
            'method' => $service->_id ? 'PUT' : 'POST']) !!}
            <div class="card-body">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-3">
                        <div class="form-group-lg">
                            <label>_id</label>
                            {!! Form::text('_id', null, ['class'=>'form-control input-lg', $service->_id ? 'disabled' : '']) !!}
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
                            <label>category_id</label>
                            @if(empty($service->category_id))
                                @foreach(\App\Models\mongo\Category::all()->sortBy('name') as $category)
                                    <div class="form-check">
                                        {{ Form::checkbox('category_id', $category->_id, null, [
                                                "class"=> "form-check-input",
                                                'type'=>"checkbox",
                                                "id"=> $category->_id,
                                            ]) }}
                                        <label class="form-check-label" for="{{ $category->_id }}">
                                            {{ $category->name }} <a
                                                href="{{ route('category.edit', $category->_id) }}">*</a>
                                        </label>
                                    </div>
                                @endforeach
                            @else
                                {!! Form::text('category_id', null, ['class'=>'form-control input-lg']) !!}
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @include('layouts.ui.buttons-return-save', ['route' => route('services.index')])
            {!! Form::close() !!}
        </div>
    </div>
@endsection
