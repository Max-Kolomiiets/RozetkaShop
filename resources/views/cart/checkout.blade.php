@extends('layouts.main')

@section('main_content')
    <section class="section" id='cart-content'>
        <div class="container">
            <div class="row cart-boreder">
                @php 
                    $total="0" 
                @endphp
                <div id="cart-title">
                    <span>Замовлення</span>
                    <hr>
                </div>

                <div class="items-border">
                    <span>Персональні дані</span>
                    <hr>
                    <table class="personal-data-table">
                        <tr>
                            <td class='personal-data-titel'><span>Ім'я</span></td>
                            <td class='personal-data-value'>
                                <input 
                                    type="text" 
                                    name="Name" 
                                    class="form-control"
                                    @auth
                                    value="Ім'я :)"
                                    @endauth
                                    >
                            </td>
                        </tr>
                        <tr>
                            <td class='personal-data-titel'><span>Прізвище</span></td>
                            <td class='personal-data-value'>
                                <input 
                                    type="text" 
                                    name="Surname" 
                                    class="form-control"
                                    @auth
                                    value="Прізвіще :\"
                                    @endauth
                                    >
                            </td>
                        </tr>
                        <tr>
                            <td class='personal-data-titel'><span>Електрона адреса</span></td>
                            <td class='personal-data-value'>
                                <input 
                                    type="text" 
                                    name="email" 
                                    class="form-control"
                                    @auth
                                    value="Електрона адреса :|"
                                    @endauth
                                    >
                            </td>
                        </tr>
                        <tr>
                            <td class='personal-data-titel'><span>Телефон</span></td>
                            <td class='personal-data-value'>
                                <input 
                                    type="tel" 
                                    name="phone" 
                                    class="form-control"
                                    @auth
                                    value="Номер телефона >:("
                                    @endauth
                                    >
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="items-border">
                    <span>Товари</span>
                    <hr>
                    <table>

                    @foreach ($cart_data as $data)
                        <?php
                            $product_id = isset($data['product_id']) ? $data['product_id'] : $data['item_id'];
                            $imagePath = $data['item_image'];
                            if (strpos($imagePath, "images") !== false) {
                                $imagePath = url('storage/' . $imagePath);
                            }
                        ?>
                        <tr class="cart-section cartpage">
                            <td class="cart-image">
                                <a class="entry-thumbnail" href="{{ route('product.show', $product_id) }}">
                                    <img src="{{ $imagePath }}" width="70px" alt="">
                                </a>
                            </td>
                            <td class="product-name">
                                <span class='cart-product-description'>
                                    <a href="{{ route('product.show', $product_id) }}">{{ $data['item_name'] }}</a>
                                </span>
                            </td>
                            <td class="cart-product-quantity product-price-input">
                                <div class="input-group quantity cartpage">
                                    <input type="hidden" class="product_id" value="{{ $data['item_id'] }}">
                                    <div class="flex-column align-items-center">
                                        <p style="text-align: center; font-size: 14px;">Кількість</p>
                                        <p style="text-align: center;">{{ $data['item_quantity'] }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="cart-product-grand-total product-price-text">
                                <div class="flex-column align-items-center">
                                    <p style="text-align: center; font-size: 14px;">Ціна</p>
                                    <p style="text-align: center;">{{ ($data['item_quantity'] * $data['item_price'])}} ₴</p>
                                </div>
                            </td>
                            @php $total += (($data["item_quantity"] * $data["item_price"])) @endphp
                        </tr>
                    @endforeach
                    <tr>
                        <td><h4 style="font-weight: 400;">Всього: </h4></td>
                        <td><h4 style="font-weight: 600;">{{ $total }}₴</h4></td>
                    </tr>
                    </table>
                </div>

                <div class="items-border">
                    <span>Спосіб доставки</span>
                    <hr>
                    <form class="form m-3">
                        <div class="form-group">
                            <label for="">Адреса:</label>
                            <input 
                                type="text" 
                                class="form-control name"
                                @auth
                                value="Адреса"
                                @endauth
                                >
                        </div>
                        <div class="">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="delivery-method" id="delivery-method-1" checked/>
                                <label class="form-check-label" for="delivery-method-1">Самовивіз з Нової Пошти</label>
                            </div>
                        
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="delivery-method" id="delivery-method-2"  />
                                <label class="form-check-label" for="delivery-method-2">Кур'єр Нова пошта</label>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="items-border">
                    <span>Спосіб оплати</span>
                    <hr>
                    <div class="m-3">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="payment-method" id="payment-method-1" checked/>
                            <label class="form-check-label" for="payment-method-1"> Оплата під час отримання товару </label>
                        </div>
                    
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="payment-method" id="payment-method-2"  />
                            <label class="form-check-label" for="payment-method-2"> Оплатити зараз </label>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 mycard py-5 text-center">
                        <div class="mycards">
                            <button class="btn btn-checkout continue-btn">Надіслати замовлення</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- <h1 class="text-center">Making an order</h1>

    <h3>Total sum: 2000 $</h3>

    <div class="col-6">
        <h2>Contact information: </h2>
        <hr>
        @auth
            <form class="form m-3">
                <div class="form-group">
                    <label for="exampleInputEmail1">Name</label>
                    <input type="text" class="form-control" value="David">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Lastname</label>
                    <input type="text" class="form-control" value="Petric">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Patronymic</label>
                    <input type="text" class="form-control" value="Redaitfg">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Phone</label>
                    <input type="phone" class="form-control" value="+3809751452">
                </div>
            </form>
        @else
            <form class="form m-3">
                <div class="form-group">
                    <label for="">Name</label>
                    <input type="text" class="form-control name">
                </div>
                <div class="form-group">
                    <label for="">Lastname</label>
                    <input type="text" class="form-control">
                </div>
                <div class="form-group">
                    <label for="">Patronymic</label>
                    <input type="text" class="form-control">
                </div>
                <div class="form-group">
                    <label for="">Phone</label>
                    <input type="phone" class="form-control">
                </div>
            </form>
        @endauth
    </div>

    <h2>Goods:</h2>
    <hr>

    <div class="row">
        @foreach ($cart_data as $data)
            <?php
            $product_id = isset($data['product_id']) ? $data['product_id'] : $data['item_id'];
            $imagePath = $data['item_image'];
            if (strpos($imagePath, 'images') !== false) {
                $imagePath = url('storage/' . $imagePath);
            }
            ?>
            <div class="col-sm-3">
                <div class="card">
                    <a href="{{ route('product.show', $product_id) }}" class="">
                        <img class="card-img-top" width="100em" height="100em" src="{{ $imagePath }}" alt="">
                    </a>
                    <div class="card-body">
                        <h5 class="card-title">{{ $data['item_name'] }}</h5>
                        <p class="card-text">Count: {{ $data['item_quantity'] }}</p>
                        <p class="card-text">Price: <small class="text-muted">{{ $data['item_price'] }}
                                $</small></p>
                    </div>
                </div>
            </div>
        @endforeach

    </div>--}}
@endsection
