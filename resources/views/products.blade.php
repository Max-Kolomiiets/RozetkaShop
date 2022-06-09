@extends('layouts.main')
@section('main_content')

    @if($view_info->query_type != 'none')
    <div class="row" id="main-content-filtring">
        <h1>{{$view_info->title}}</h1>
        <div class="col filtres accordion" id="filters-section">
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
                
                {{-- slider of prices --}}            
                <div class="accordion-item form-group" id="aPrice">
                    <h2 class="accordion-header" id="hPrice">
                        <button 
                            class="accordion-button" 
                            type="button" 
                            data-bs-toggle="collapse" 
                            data-bs-target="#cPrice" 
                            aria-expanded="true" 
                            aria-controls="cPrice">    

                            <h5>Ціна</h5>

                        </button>
                    </h2>
                    <div id="cPrice" 
                        class="accordion-collapse collapse show" 
                        aria-labelledby="hPrice" 
                        data-bs-parent="#accordionAttributes">
                        <div class="accordion-body" id="priceSection">    

                            <input type="number" name="price-min" onchange="this.form.submit()" value="{{$view_info->prices->value_min}}">
                            <label for="price-max">-</label>
                            <input type="number" name="price-max" onchange="this.form.submit()" value="{{$view_info->prices->value_max}}">
                        
                        </div>
                    </div>
                </div>

                {{-- checkboxes of vendors --}}
                <div class="accordion-item form-group" id="aVendor">
                    <h2 class="accordion-header" id="hVendor">
                        <button 
                            class="accordion-button" 
                            type="button" 
                            data-bs-toggle="collapse" 
                            data-bs-target="#cVendor" 
                            aria-expanded="true" 
                            aria-controls="cVendor">            
                            <h5>Виробник</h5>
                        </button>
                    </h2>
                    <div id="cVendor" 
                        class="accordion-collapse collapse show" 
                        aria-labelledby="hVendor" 
                        data-bs-parent="#accordionAttributes">
                        <div class="accordion-body">           
                            @foreach($view_info->vendors as $vendor)
                                <div class="custom-control custom-checkbox form-group">
                                    <input 
                                        @if ($vendor->state) checked @endif 
                                        type="checkbox"
                                        class="custom-control-input" 
                                        onclick="this.form.submit()" 
                                        id="vendor-{{ $loop->index}}"
                                        name="vendor-{{ $loop->index}}"
                                        value={{$vendor->alias}}>
                                    <label class="custom-control-label" for="vendor-{{ $loop->index}}">{{ $vendor->name }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                
                {{-- section of select attributes --}}
                @foreach($view_info->characteristics as $key=>$values)

                    {{-- accordion item --}}
                    <div class="accordion-item" id="a{{$key}}">
                        <h2 class="accordion-header" id="heading{{$key}}">
                            <button 
                                class="accordion-button" 
                                type="button" 
                                data-bs-toggle="collapse" 
                                data-bs-target="#collapse{{$key}}" 
                                aria-expanded="true" 
                                aria-controls="collapse{{$key}}">
                               
                                <h5>{{ App\Models\Attribute::find($key)->name}}</h5>

                            </button>
                        </h2>
                        <div id="collapse{{$key}}" 
                        class="accordion-collapse collapse show" 
                        aria-labelledby="heading{{$key}}" 
                        data-bs-parent="#accordionAttributes">
                            <div class="accordion-body">           
                                @foreach($values as $value)
                                    <div class="custom-control custom-checkbox form-group">
                                        <input 
                                            @if($value->state)
                                            checked 
                                            @endif
                                            type="checkbox" 
                                            class="custom-control-input"
                                            onclick="this.form.submit()"
                                            id="{{$key}}-{{$value->id}}" 
                                            name="{{App\Models\Attribute::find($key)->alias}}-{{$loop->index}}"
                                            value="{{$value->alias}}">
                                        <label class="custom-control-label" for="{{$key}}">{{$value->name}}</label>
                                    </div>
                                 @endforeach

                            </div>
                        </div>
                    </div>

                @endforeach
            </form>
        </div>
        <div class="col-10">
            <div class="row row-cols-1 row-cols-lg-3" id="products">
                @foreach ($view_info->products as $product)
                    <?php
                        $imagePath = $product->image_url;
                        if (strpos($imagePath, "images") !== false) {
                            $imagePath = url('storage/' . $imagePath);
                        }
                    ?>
                    <div class="product product-filltres">
                        <div
                            class="feature-icon d-inline-flex align-items-center justify-content-center bg-primary bg-gradient text-white fs-2 mb-3">
                            <a href="{{ route('product.show', $product->id) }}"
                                class="icon-link d-inline-flex align-items-center">
                                <img class="bi" width="100em" height="100em"
                                    src="{{ $imagePath }}" alt="">
                            </a>
                        </div>
                        <div>
                            <a href="{{ route('product.show', $product->id) }}"
                                class="icon-link d-inline-flex align-items-center product-name">
                                <p>{{ $product->name }}</p>
                            </a>
                        </div>
                        <div class="bottom-row feature">
                            <h3 class="price-text price-text-filltres">{{ $product->price}} ₴</h3>
                            <a class="cart-btn add-to-cart-btn"></a>

                            @if ($product->inCart)
                                <p>Вже в корзині</p>
                            @else
                                <p>Додати до корзини</p>
                            @endif

                            <input type="hidden" class="product_id" value="{{ $product->id }}"> <!-- Your Product ID -->
                            <input type="hidden" class="qty-input" value="1">
                        </div>
                    </div>
                    {{-- <div class="border border-info product">
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
                    </div> --}}
                @endforeach
            </div>
        </div>     
    </div>

    @else
    
    <h5>Жодного товару за заданим ім'ям не знайдено !</h5>

    @endif

    <script>
        function loadState(id, accordionState){
            let element = $(`#${id}`);
            $(element).find('.accordion-button').attr('aria-expanded', accordionState[0]);
            $(element).find('.accordion-button').attr('class', accordionState[2]);
            $(element).find('.accordion-collapse').attr('class', accordionState[1]);
        }
        let pageScript = function() {
            $(window).scroll(function() {
                sessionStorage.scrollTop = $(this).scrollTop();
            });
            $('.accordion-item').click(function(){
                let div_class_state = ['accordion-collapse collapse show', 'accordion-collapse collapse'];
                let button_class_state = ['accordion-button', 'accordion-button collapsed'];

                let aria_expanded = $(this).find('.accordion-button').attr('aria-expanded');
                let div_class = aria_expanded == 'true'? div_class_state[0] : div_class_state[1];
                let button_class = aria_expanded == 'true'? button_class_state[0] : button_class_state[1];

                sessionStorage[`accordionState${$(this).attr('id')}`] = `${aria_expanded};${div_class};${button_class}`;
            });

            $(document).ready(function() {
                if (sessionStorage.scrollTop != "undefined") {
                    $(window).scrollTop(sessionStorage.scrollTop);
                }
                if(sessionStorage.length > 1)
                {
                    let test = {};
                    let values = Object.values(sessionStorage);
                    let keys = Object.keys(sessionStorage);
                    for (let index = 0; index < values.length; index++) {
                        if(keys[index].includes('accordionState')){
                            let id = keys[index].replace('accordionState','');
                            let states = values[index].split(';')
                            loadState(id, states);
                        }
                    } 
                }
            });
        }
    </script>
@endsection
