@extends('layouts/main')
@section('main_content')

<section class="section" id='cart-content'>
    <div class="container">
        <div class="row cart-boreder">
            @php 
                $total="0" 
            @endphp
            <div id="cart-title">
                <span>Кабінет</span>
                <hr>
            </div>

            <div class="items-border">
                <span>Персональні дані</span>
                <hr>
                <table class="personal-data-table">
                    <tr>
                        <td class='personal-data-titel'>Логін</td>
                        <td class='personal-data-value'>
                            <input type="text" name="login" readonly class="read-only-input" value="value">
                        </td>
                    </tr>
                    <tr>
                        <td class='personal-data-titel'>Ім'я</td>
                        <td class='personal-data-value'>
                            <input type="text" name="Name" readonly class="read-only-input" value="value">
                        </td>
                    </tr>
                    <tr>
                        <td class='personal-data-titel'>Прізвище</td>
                        <td class='personal-data-value'>
                            <input type="text" name="Surname" readonly class="read-only-input" value="value">
                        </td>
                    </tr>
                    <tr>
                        <td class='personal-data-titel'>Електрона адреса</td>
                        <td class='personal-data-value'>
                            <input type="text" name="email" readonly class="read-only-input" value="value">
                        </td>
                    </tr>
                    <tr>
                        <td class='personal-data-titel'>Телефон</td>
                        <td class='personal-data-value'>
                            <input type="tel" name="phone" readonly class="read-only-input" value="value">
                        </td>
                    </tr>
                    <tr>
                        <td class='personal-data-titel'>Адреса</td>
                        <td class='personal-data-value'>
                            <input type="text" name="address" readonly class="read-only-input" value="value">
                        </td>
                    </tr>
                    <tr id="edit-change-content">
                        <td>
                            <div class="cart-checkout-btn text-center" id="edit-cabinet-data-btn">
                                <a class="btn btn-block checkout-btn">
                                    Редагувати
                                </a>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td><a href="#">змінити пароль</a></td>
                    </tr>
                </table>
            </div>
            <div class="items-border">
                <span>Мої замовлення</span>
                <hr>
                @if (!$orders->isEmpty())
                    <p>
                        
                        У вас {{count($orders)}} 
                        @if(count($orders) < 5)
                            замовлення
                        @else
                            замовлень
                        @endif
                    </p>
                    <div class="accordion" id="filters-section">
                        @foreach ($orders as $order)
                            <div class="accordion-item form-group" id="aOrder-{{$loop->index}}">
                                <h2 class="accordion-header" id="hOrder-{{$loop->index}}">
                                    <button 
                                        class="accordion-button" 
                                        type="button" 
                                        data-bs-toggle="collapse" 
                                        data-bs-target="#cOrder-{{$loop->index}}" 
                                        aria-expanded="true" 
                                        aria-controls="cOrder-{{$loop->index}}">      
                                        <h5>
                                            Замовлення #{{ $order->order_number }} 
                                            | 
                                            Статус:{{ $order->orderStatus()->get()[0]->status }}
                                            |
                                            Ціна: {{$order->price}}₴
                                            |
                                            Дата: {{$order->order_date}}
                                        </h5>
                                    </button>
                                </h2>
                                <div id="cOrder-{{$loop->index}}" 
                                    class="accordion-collapse collapse show" 
                                    aria-labelledby="hOrder-{{$loop->index}}" 
                                    data-bs-parent="#accordionAttributes">
                                    <div class="accordion-body" id="priceSection">     
                                        <table>
                                            @foreach ($order->products()->get() as $data)
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
                                                            <img src="{{ $data->product()->get()[0]->images()->get()[0]->url }}" width="70px" alt="">
                                                        </a>
                                                    </td>
                                                    <td class="product-name">
                                                        <span class='cart-product-description'>
                                                            <a href="{{ route('product.show', $product_id) }}">{{ $data->product()->get()[0]->name }}</a>
                                                        </span>
                                                    </td>
                                                    <td class="cart-product-quantity product-price-input">
                                                        <div class="input-group quantity cartpage">
                                                            <input type="hidden" class="product_id" value="{{ $data->product()->get()[0]['item_id'] }}">
                                                            <div class="flex-column align-items-center">
                                                                <p style="text-align: center; font-size: 14px;">Кількість</p>
                                                                <p style="text-align: center;">{{ $data->qty }}</p>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="cart-product-grand-total product-price-text">
                                                        <div class="flex-column align-items-center">
                                                            <p style="text-align: center; font-size: 14px;">Ціна</p>
                                                            <p style="text-align: center;">{{ ($data->qty * $data->product()->get()[0]->price()->get()[0]->price)}} ₴</p>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </table>        
                                    </div>
                                </div>
                            </div>
                            {{-- <h3>#{{ $order->order_number }}</h3>
                            <h5>Status: <span
                                    class="text-success">{{ $order->orderStatus()->get()[0]->status }}</span></h5>
                            <hr>

                            @foreach ($order->products()->get() as $orderProduct)
                                <div class="border mt-3 mb-3 p-4">
                                    <h4>Product name: {{ $orderProduct->product()->get()[0]->name }}</h4>
                                    <h4>Count: {{ $orderProduct->qty }}</h4>
                                </div>
                            @endforeach
                            <hr class="mb-3"> --}}
                        @endforeach
                    </div>
                @else
                    <p>У вас поки немає замовлень!</p>
                @endif
            </div>

            <div class="logout-btn">  
                <form action="{{ url('/logout') }}" method="post">
                    @csrf
                    <button class="btn btn-danger headers-links">Вийти</button>
                </form>
            </div>
        </div>
    </div>
</section>

@endsection
