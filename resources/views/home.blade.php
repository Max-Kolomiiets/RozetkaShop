@extends('layouts.main')
@section('title', ' Офіційний сайт')
@section('main_content')
    <div class="row" id="main-content">
        <div class="col">
            <ul id="categories-list">
                @foreach ($categories as $category)
                    <li class="category_li">
                        <a href="{{ route('category.show', $category->id) }}">{{ $category->name }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
        <div class="row row-cols-1 row-cols-lg-3 col-10" id="products">
            @foreach ($products as $product)
                <?php
                $imagePath = $product->images()->get()[0]->url;
                if (strpos($imagePath, 'images') !== false) {
                    $imagePath = url('storage/' . $imagePath);
                }
                ?>
                <div class="product">
                    <div
                        class="feature-icon d-inline-flex align-items-center justify-content-center bg-primary bg-gradient text-white fs-2 mb-3">
                        <a href="{{ route('product.show', $product->id) }}"
                            class="icon-link d-inline-flex align-items-center">
                            <img class="bi" width="100em" height="100em" src="{{ $imagePath }}" alt="">
                        </a>
                    </div>
                    <div>
                        <a href="{{ route('product.show', $product->id) }}"
                            class="icon-link d-inline-flex align-items-center product-name">
                            <p>{{ $product->name }}</p>
                        </a>
                    </div>
                    <div>
                        <h3 class="product-price price-text">{{ $product->price()->get()[0]->price }} ₴</h3>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="text-center" id="pages">
            {{ $products->links() }}
        </div>
    </div>
@endsection
