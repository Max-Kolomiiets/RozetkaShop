@extends('layouts.main')

@section('main_content')
    <section class="section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    @php $total="0" @endphp
                    @if (!empty($cart_data))
                        <div class="shopping-cart">
                            <div class="shopping-cart-table">
                                <div class="table-responsive">
                                    <div class="col-md-12 text-right mb-3">
                                        <a href="javascript:void(0)" class="clear_cart font-weight-bold">Clear Cart</a>
                                    </div>
                                    <table class="table table-bordered my-auto  text-center">
                                        <thead>
                                            <tr>
                                                <th class="cart-description">Image</th>
                                                <th class="cart-product-name">Product Name</th>
                                                <th class="cart-price">Price</th>
                                                <th class="cart-qty">Quantity</th>
                                                <th class="cart-total">Grandtotal</th>
                                                <th class="cart-romove"></th>
                                            </tr>
                                        </thead>
                                        <tbody class="my-auto">
                                            @foreach ($cart_data as $data)
                                                <?php
                                                    $product_id = isset($data['product_id']) ? $data['product_id'] : $data['item_id'];
                                                    $imagePath = $data['item_image'];
                                                    if (strpos($imagePath, "images") !== false) {
                                                        $imagePath = url('storage/' . $imagePath);
                                                    }
                                                ?>
                                                <tr class="cartpage">
                                                    <input type="hidden" class="product_id"
                                                        value="{{ $data['item_id'] }}">
                                                    <td class="cart-image">
                                                        <a class="entry-thumbnail" href="javascript:void(0)">
                                                            <img src="{{ $imagePath }}" width="70px" alt="">
                                                        </a>
                                                    </td>
                                                    <td class="cart-product-name-info">
                                                        <h4 class='cart-product-description'>
                                                            <a
                                                                href="{{ route('product.show', $product_id) }}">{{ $data['item_name'] }}</a>
                                                        </h4>
                                                    </td>
                                                    <td class="cart-product-sub-total">
                                                        <span
                                                            class="cart-sub-total-price">{{ $data['item_price'] / 100.0 }}</span>
                                                    </td>
                                                    <td class="cart-product-quantity" width="130px">
                                                        <div class="input-group quantity">
                                                            <div class="input-group-prepend decrement-btn changeQuantity"
                                                                style="cursor: pointer">
                                                                <span class="input-group-text">-</span>
                                                            </div>
                                                            <input type="text" class="qty-input form-control" maxlength="2"
                                                                max="10" value="{{ $data['item_quantity'] }}">
                                                            <div class="input-group-append increment-btn changeQuantity"
                                                                style="cursor: pointer">
                                                                <span class="input-group-text">+</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="cart-product-grand-total">
                                                        <span
                                                            class="cart-grand-total-price">{{ ($data['item_quantity'] * $data['item_price']) / 100.0 }}</span>
                                                    </td>
                                                    <td style="font-size: 20px;">
                                                        <button type="button"
                                                            class="btn btn-danger delete_cart_data">Remove</button>
                                                    </td>
                                                    @php $total += (($data["item_quantity"] * $data["item_price"]) / 100.0) @endphp
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table><!-- /table -->
                                </div>
                            </div><!-- /.shopping-cart-table -->
                            @if (!empty($cart_data))
                                <div class="row">

                                    <div class="col-md-8 col-sm-12 estimate-ship-tax">
                                        <div>
                                            <a href="{{ route('main.index') }}"
                                                class="btn btn-upper btn-warning outer-left-xs mt-3">Continue Shopping</a>
                                        </div>
                                    </div><!-- /.estimate-ship-tax -->

                                    <div class="col-md-4 col-sm-12 ">
                                        <div class="cart-shopping-total">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <h6 class="cart-subtotal-name">Subtotal</h6>
                                                </div>
                                                <div class="col-md-6">
                                                    <h6 class="cart-subtotal-price">
                                                        Rs.
                                                        <span class="cart-grand-price-viewajax">{{ $total }}</span>
                                                    </h6>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <h6 class="cart-grand-name">Grand Total</h6>
                                                </div>
                                                <div class="col-md-6">
                                                    <h6 class="cart-grand-price">
                                                        Rs.
                                                        <span class="cart-grand-price-viewajax">{{ $total }}</span>
                                                    </h6>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="cart-checkout-btn text-center">
                                                        @if (Auth::user())
                                                            <a href="{{ url('checkout') }}"
                                                                class="btn btn-success btn-block checkout-btn">PROCCED TO
                                                                CHECKOUT</a>
                                                        @else
                                                            <a href="{{ url('login') }}"
                                                                class="btn btn-success btn-block checkout-btn">PROCCED TO
                                                                CHECKOUT</a>
                                                            {{-- you add a pop modal for making a login --}}
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div><!-- /.shopping-cart -->
                    @endif
                    @if (empty($cart_data))
                        <div class="row">
                            <div class="col-md-12 mycard py-5 text-center">
                                <div class="mycards">
                                    <h4>Your cart is currently empty.</h4>
                                    <a href="{{ route('main.index') }}"
                                        class="btn btn-upper btn-primary outer-left-xs mt-5">Continue Shopping</a>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div> <!-- /.row -->
        </div><!-- /.container -->
    </section>
@endsection
