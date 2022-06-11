@extends('layouts.main')
@section('title', 'Кошик')
@section('main_content')
    <section class="section" id='cart-content'>
        <div class="container">
            <div class="row cart-boreder">
                @php
                    $total = '0';
                @endphp
                <div id="cart-title">
                    <span>Кошик</span>
                    <hr>
                </div>
                @if (!empty($cart_data))

                    <div class="shopping-cart">
                        <div class="shopping-cart-table">
                            <div class="table-responsive">
                                <div class="mb-3 clear-cart-section">
                                    <a href="javascript:void(0)" class="clear_cart font-weight-bold">Очистити кошик</a>
                                </div>
                                <div class="products-in-cart">
                                    <table class="cart-products">
                                        @foreach ($cart_data as $data)
                                            <?php
                                            $product_id = isset($data['product_id']) ? $data['product_id'] : $data['item_id'];
                                            $imagePath = $data['item_image'];
                                            if (strpos($imagePath, 'images') !== false) {
                                                $imagePath = url('storage/' . $imagePath);
                                            }
                                            ?>
                                            <tr class="cart-section cartpage">
                                                <td class="cart-image">
                                                    <a class="entry-thumbnail"
                                                        href="{{ route('product.show', $product_id) }}">
                                                        <img src="{{ $imagePath }}" width="70px" alt="">
                                                    </a>
                                                </td>
                                                <td class="product-name">
                                                    <span class='cart-product-description'>
                                                        <a
                                                            href="{{ route('product.show', $product_id) }}">{{ $data['item_name'] }}</a>
                                                    </span>
                                                </td>
                                                <td class="cart-product-quantity product-price-input">
                                                    <div class="input-group quantity cartpage">
                                                        <input type="hidden" class="product_id"
                                                            value="{{ $data['item_id'] }}">
                                                        <div class="input-group-prepend decrement-btn changeQuantity"
                                                            style="cursor: pointer">
                                                            <span class="input-group-text">-</span>
                                                        </div>
                                                        <input type="text" class="qty-input form-control" maxlength="4"
                                                            value="{{ $data['item_quantity'] }}">
                                                        <div class="input-group-append increment-btn changeQuantity"
                                                            style="cursor: pointer">
                                                            <span class="input-group-text">+</span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="cart-product-grand-total product-price-text">
                                                    <span class="cart-grand-total-price">
                                                        {{ $data['item_quantity'] * $data['item_price'] }} ₴
                                                    </span>
                                                </td>
                                                <td class="remove-btn">
                                                    <button type="button" class="btn btn-danger delete_cart_data">
                                                        Видалити
                                                    </button>
                                                </td>
                                                @php $total += (($data["item_quantity"] * $data["item_price"])) @endphp
                                            </tr>
                                        @endforeach
                                    </table>
                                </div>
                            </div>
                        </div><!-- /.shopping-cart-table -->

                        <div class="row">

                            <div class="col-md-8 col-sm-12 estimate-ship-tax">
                                <div class="continue_text">
                                    <a href="{{ route('main.index') }}" class="continue_action">Продовжити покупки</a>
                                </div>
                            </div><!-- /.estimate-ship-tax -->

                            <div class="col-md-4">
                                <div class="cart-shopping-total">
                                    <div class="cart-grand-price">
                                        <span class="cart-grand-price-viewajax">{{ $total }}₴</span>
                                    </div>
                                    <div class="cart-checkout-btn text-center">
                                        @if (Auth::user())
                                            <a href="{{ route('checkout') }}" class="btn btn-block checkout-btn">
                                                Оформити замовлення
                                            </a>
                                        @else
                                            <a href="{{ route('checkout') }}" class="btn btn-block checkout-btn">
                                                Оформити замовлення
                                            </a>
                                            {{-- you add a pop modal for making a login --}}
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div><!-- /.shopping-cart -->
                @else
                    <div class="row">
                        <div class="col-md-12 mycard py-5 text-center">
                            <div class="mycards">
                                <h4> Кошик порожній</h4>
                                <a href="{{ route('main.index') }}"
                                    class="btn btn-upper continue-btn outer-left-xs mt-5 ">Продовжити покупки</a>
                            </div>
                        </div>
                    </div>

                @endif
            </div> <!-- /.row -->
        </div><!-- /.container -->
    </section>
@endsection
