@extends('layouts.main')

@section('main_content')

<section class="bg-success">
    <div class="container">
        <div class="row">
            <div class="col-md-12 mt-2 py-3">
                <h5><a href="/" class="text-dark">Home</a> › Cart</h5>
            </div>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                @if(isset($cart_data))
                    @if(Cookie::get('shopping_cart'))
                        @php $total="0" @endphp
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
                                                <th class="cart-romove">Remove</th>
                                            </tr>
                                        </thead>
                                        <tbody class="my-auto">
                                            @foreach ($cart_data as $data)
                                            <tr class="cartpage">
                                                <td class="cart-image">
                                                    <a class="entry-thumbnail" href="javascript:void(0)">
                                                        <img src="{{ asset('admin/uploads/productcatelist/'.$data['item_image']) }}" width="70px" alt="">
                                                    </a>
                                                </td>
                                                <td class="cart-product-name-info">
                                                    <h4 class='cart-product-description'>
                                                        <a href="javascript:void(0)">{{ $data['item_name'] }}</a>
                                                    </h4>
                                                </td>
                                                <td class="cart-product-sub-total">
                                                    <span class="cart-sub-total-price">{{ number_format($data['item_price'], 2) }}</span>
                                                </td>
                                                <td class="cart-product-quantity">
                                                     <input type="number" class="qty-input form-control" value="{{ $data['item_quantity'] }}" min="1" max="100"/>
                                                </td>
                                                <td class="cart-product-grand-total">
                                                    <span class="cart-grand-total-price">{{ number_format($data['item_quantity'] * $data['item_price'], 2) }}</span>
                                                </td>
                                                <td style="font-size: 20px;">
                                                    <button type="button" class="delete_cart_data"><li class="fa fa-trash-o"></li> Delete</button>
                                                </td>
                                                @php $total = $total + ($data["item_quantity"] * $data["item_price"]) @endphp
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table><!-- /table -->
                                </div>
                            </div><!-- /.shopping-cart-table -->
                            <div class="row">

                                <div class="col-md-8 col-sm-12 estimate-ship-tax">
                                    <div>
                                        <a href="{{ url('collections') }}" class="btn btn-upper btn-warning outer-left-xs">Continue Shopping</a>
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
                                                    <span class="cart-grand-price-viewajax">{{ number_format($total, 2) }}</span>
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
                                                    <span class="cart-grand-price-viewajax">{{ number_format($total, 2) }}</span>
                                                </h6>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="cart-checkout-btn text-center">
                                                    @if (Auth::user())
                                                        <a href="{{ url('checkout') }}" class="btn btn-success btn-block checkout-btn">PROCCED TO CHECKOUT</a>
                                                    @else
                                                        <a href="{{ url('login') }}" class="btn btn-success btn-block checkout-btn">PROCCED TO CHECKOUT</a>
                                                        {{-- you add a pop modal for making a login --}}
                                                    @endif
                                                    <h6 class="mt-3">Checkout with Fabcart</h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div><!-- /.shopping-cart -->
                    @endif
                @else
                    <div class="row">
                        <div class="col-md-12 mycard py-5 text-center">
                            <div class="mycards">
                                <h4>Your cart is currently empty.</h4>
                                <a href="{{ url('collections') }}" class="btn btn-upper btn-primary outer-left-xs mt-5">Continue Shopping</a>
                            </div>
                        </div>
                    </div>
                @endif

            </div>
        </div> <!-- /.row -->
    </div><!-- /.container -->
</section>

@endsection