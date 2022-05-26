@extends('layouts.main')
@section('main_content')
    <div class="row justify-content-md-center">
        <div class="g-4 py-5 col">
            <ul class="">
                @foreach($categories as $category)
                    <li class="category_li"><a class="text-dark" href="{{ route("category.show", $category->id) }}">{{$category->name}}</a></li>
                @endforeach
            </ul>
        </div>
        <div class="row g-4 py-5 row-cols-1 row-cols-lg-3 col-10">
            @foreach($products as $product)
                <div class="border border-info product">
                    <div class="feature col">
                        <div class="feature-icon d-inline-flex align-items-center justify-content-center bg-primary bg-gradient text-white fs-2 mb-3">
                            <a href="{{route("product.show", $product->id)}}" class="icon-link d-inline-flex align-items-center">
                                <img class="bi" width="100em" height="100em" src="{{$product->images()->get()[0]->url}}" alt="">
                            </a> 
                        </div>          
                        <br> 
                        <a href="{{route("product.show", $product->id)}}" class="icon-link d-inline-flex align-items-center product-name">
                            <h2>{{$product->name}}</h2>
                        </a>
                        <br> 
                        <p>{{ $product->price()->get()[0]->price / 100}} ₴</p>
                        </div>
                </div>
            @endforeach
        </div>
        <div class="text-center">
            {{ $products->links() }}
        </div>
    </div>
    
@endsection