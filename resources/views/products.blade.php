@extends('layouts.main')
@section('main_content')
    <h1>{{$category->name}}</h1>
    <div class="row justify-content-md-center">
        <div class="flex-column col">
            <form action="{{route("category.filtering", $category->id)}}" method="POST">
                @csrf
                @foreach($attributes as $attribut)
                    <h5>{{$attribut->name}}</h5>
                    @foreach($attribut->values as $value)
                        <div class="custom-control custom-checkbox form-group">
                            {{-- onclick="this.form.submit()" --}}
                            <input 
                                @if($value->state)
                                   checked 
                                @endif
                                type="checkbox" 
                                class="custom-control-input"
                                onclick="this.form.submit()" 
                                id="{{$attribut->name}}#{{$value->alias}}" 
                                name="{{$attribut->name}}#{{$value->alias}}">
                            <label class="custom-control-label" for="{{$attribut->name}}#{{$value->alias}}">{{$value->alias}}</label>
                        </div>
                    @endforeach
                @endforeach
            </form>
        </div>
        <div class="row g-4 py-5 row-cols-1 row-cols-lg-3 col-10">
            @foreach($products as $product)
                <div class="feature col">
                <div class="feature-icon d-inline-flex align-items-center justify-content-center bg-primary bg-gradient text-white fs-2 mb-3">
                    <a href="{{route("product.show", $product->id)}}" class="icon-link d-inline-flex align-items-center">
                        <img class="bi" width="100em" height="100em" src="{{$product->image_url}}" alt="">
                    </a> 
                </div>          
                <br> 
                <a href="{{route("product.show", $product->id)}}" class="icon-link d-inline-flex align-items-center">
                    <h2>{{$product->name}}</h2>
                </a>
                <br> 
                <p>{{$product->price}} ₴</p>
                </div>
            @endforeach
        </div>
    </div>
@endsection