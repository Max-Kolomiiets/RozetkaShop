@extends('layouts.main')

@section('main_content')
    <h1 class="text-center">Making an order</h1>

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
                        <p class="card-text">Price: <small class="text-muted">{{ $data['item_price'] / 100 }}
                                $</small></p>
                    </div>
                </div>
            </div>
        @endforeach

    </div>

    <h2>Delivery:</h2>
    <hr>

    <form class="form m-3">
        <div class="form-group">
            <label for="">Address:</label>
            <input type="text" class="form-control name">
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

    <h2>Payment:</h2>
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

    <div class="text-center">
        <button class="btn btn-success btn-checkout">Agree checkout!</button>
    </div>
@endsection
