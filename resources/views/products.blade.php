@extends('layouts.main')
@section('main_content')
    <style>
        .filltres {
            width: 10%
        }

    </style>
    <h1>{{ $category->name }}</h1>
    <div class="row justify-content-md-center">
        <div class="flex-column col filltres">
            <form action="{{ route('category.filltering', $category->id) }}" method="POST">
                @csrf
                <div class="form-group">
                    <h5>Ціна</h5>
                    <label for="price-min">від</label>
                    <input type="number" name="price-min" onchange="this.form.submit()"
                        value="{{ $formstates->prices->value_min }}">
                    <br>
                    <label for="price-max">до</label>
                    <input type="number" name="price-max" onchange="this.form.submit()"
                        value="{{ $formstates->prices->value_max }}">
                </div>
                <div class="form-group">
                    <h5>Виробник</h5>
                    @foreach ($formstates->vendors as $vendor)
                        <div class="custom-control custom-checkbox form-group">
                            <input @if ($vendor->state) checked @endif type="checkbox"
                                class="custom-control-input" onclick="this.form.submit()" id="vendor#{{ $vendor->alias }}"
                                name="vendor#{{ $vendor->alias }}">
                            <label class="custom-control-label" for="vendor#{{ $vendor->alias }}">{{ $vendor->name }}</label>
                        </div>
                    @endforeach
                </div>
                @foreach ($formstates->attributes as $attribut)
                    <h5>{{ $attribut->name }}</h5>
                    @foreach ($attribut->values as $value)
                        <div class="custom-control custom-checkbox form-group">
                            <input @if ($value->state) checked @endif type="checkbox"
                                class="custom-control-input" onclick="this.form.submit()"
                                id="{{ $attribut->name }}#{{ $value->alias }}"
                                name="{{ $attribut->name }}#{{ $value->alias }}">
                            <label class="custom-control-label"
                                for="{{ $attribut->name }}#{{ $value->alias }}">{{ $value->alias }}</label>
                        </div>
                    @endforeach
                @endforeach
            </form>
        </div>
        <div class="col-10">
            <div class="row g-4 py-5 row-cols-1 row-cols-lg-3">
                @foreach ($products as $product)
                    <?php
                        $imagePath = $product->image_url;
                        if (strpos($imagePath, "images") !== false) {
                            $imagePath = url('storage/' . $imagePath);
                        }
                    ?>
                    <div class="border border-info product">
                        <div class="feature col product">
                            <input type="hidden" class="product_id" value="{{ $product->id }}">
                            <input type="hidden" class="qty-input" value="1">
                            <div
                                class="feature-icon d-inline-flex align-items-center justify-content-center bg-primary bg-gradient text-white fs-2 mb-3">
                                <a href="{{ route('product.show', $product->id) }}"
                                    class="icon-link d-inline-flex align-items-center">
                                    <img class="bi" width="100em" height="100em"
                                        src="{{ $imagePath }}" alt="">
                                </a>
                            </div>
                            <br>
                            <a href="{{ route('product.show', $product->id) }}"
                                class="icon-link d-inline-flex align-items-center product-name">
                                <h2>{{ $product->name }}</h2>
                            </a>
                            <br>
                            <p>{{ $product->price }} ₴</p>
                            <div class="text-center">
                                <button class="btn btn-success add-to-cart-btn">Add To Cart</button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <script>
        let pageScript = function() {
            $(window).scroll(function() {
                sessionStorage.scrollTop = $(this).scrollTop();
            });

            $(document).ready(function() {
                if (sessionStorage.scrollTop != "undefined") {
                    $(window).scrollTop(sessionStorage.scrollTop);
                }
            });
        }
    </script>
@endsection
