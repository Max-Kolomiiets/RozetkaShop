@extends('layouts.main')
@section('main_content')
    <h1>{{$category_name}}</h1>
    <div class="row justify-content-md-center">
        <div class="flex-column col">
            @foreach($attributes as $attribut)
            <div>
                <h5>{{$attribut->name}}</h5>
                @foreach($attribut->values as $value)
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="{{$attribut->name}}#{{$value}}">
                    <label class="custom-control-label" for="{{$attribut->name}}#{{$value}}">{{$value}}</label>
                </div>
                @endforeach
            </div>
            @endforeach
        </div>
        <div class="row g-4 py-5 row-cols-1 row-cols-lg-3 col-10">
            @foreach($products as $product)
                <div class="feature col">
                <div class="feature-icon d-inline-flex align-items-center justify-content-center bg-primary bg-gradient text-white fs-2 mb-3">
                    <a href="#" class="icon-link d-inline-flex align-items-center">
                        <img class="bi" width="100em" height="100em" src="{{$product->image_url}}" alt="">
                    </a> 
                </div>          
                <br> 
                <a href="#" class="icon-link d-inline-flex align-items-center">
                    <h2>{{$product->name}}</h2>
                </a>
                <br> 
                <p>{{$product->price}} ₴</p>
                </div>
            @endforeach
        </div>
    </div>
@endsection