@extends('layouts.main')
@section('main_content')
    <style>
        .filtres {
            width: 10%
        }

        .nonemssage{
            justify-self: right
        }
    </style>
    @if($view_info->query_type != 'none')

    <h1>{{$view_info->title}}</h1>
    <div class="row justify-content-md-center">
        <div class="flex-column col filtres">
            <form 
                @if($view_info->query_type == 'search')

                action="{{ route('products.search.filtering')}}"

                @else

                action="{{ route('category.filtering', $view_info->{'url part'}) }}" 

                @endif

                method="POST">
                @csrf

                @if($view_info->query_type == 'search')
                <input type="hidden" name="title" value="{{$view_info->title}}">
                @endif

                <div class="form-group">
                    <h5>Ціна</h5>
                    <label for="price-min">від</label>
                    <input type="number" name="price-min" onchange="this.form.submit()" value="{{$view_info->prices->value_min}}">
                    <br>
                    <label for="price-max">до</label>
                    <input type="number" name="price-max" onchange="this.form.submit()" value="{{$view_info->prices->value_max}}">
                </div>
                <div class="form-group">
                    <h5>Виробник</h5>
                    @foreach($view_info->vendors as $vendor)
                        <div class="custom-control custom-checkbox form-group">
                            <input @if ($vendor->state) checked @endif type="checkbox"
                                class="custom-control-input" onclick="this.form.submit()" id="vendor#{{ $vendor->alias }}"
                                name="vendor#{{ $vendor->alias }}">
                            <label class="custom-control-label" for="vendor#{{ $vendor->alias }}">{{ $vendor->name }}</label>
                        </div>
                    @endforeach
                </div>
                @foreach($view_info->characteristics as $key=>$values)
                    <h5>{{$key}}</h5>
                    @foreach($values as $value)
                        <div class="custom-control custom-checkbox form-group">
                            <input 
                                @if($value->state)
                                   checked 
                                @endif
                                type="checkbox" 
                                class="custom-control-input"
                                onclick="this.form.submit()" 
                                id="{{$key}}#{{$value->alias}}" 
                                name="{{$key}}#{{$value->alias}}">
                            <label class="custom-control-label" for="{{$key}}#{{$value->alias}}">{{$value->alias}}</label>
                        </div>
                    @endforeach
                @endforeach
            </form>
        </div>
        <div class="col-10">
            <div class="row g-4 py-5 row-cols-1 row-cols-lg-3">
                @foreach ($view_info->products as $product)
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

    @else
    
    <h5>Жодного товару за заданим ім'ям не знайдено !</h5>

    @endif

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
