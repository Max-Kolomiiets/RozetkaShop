$(document).ready(function () {
    cartload();
    addToCart();
    handleIncrementDecrementCart();
    changeQuantity();
    handleDeleteItem();
    handleClearCookiesCart();
});

function cartload()
{
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        url: '/load-cart-data',
        method: "GET",
        success: function (response) {
            $('.basket-item-count').html('');
            var parsed = jQuery.parseJSON(response)
            var value = parsed; //Single Data Viewing
            $('.basket-item-count').append($('<span class="badge badge-pill red">'+ value['totalcart'] +'</span>'));
        }
    });
}

function addToCart() {
    $('.add-to-cart-btn').click(function (e) {
        e.preventDefault();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var product_id = $(this).closest('.feature').find('.product_id').val();
        var quantity = $(this).closest('.feature').find('.qty-input').val();
        console.log('quantity', quantity);

        $.ajax({
            url: "/add-to-cart",
            method: "POST",
            data: {
                'quantity': quantity,
                'product_id': product_id,
            },
            success: function (response) {
                alertify.set('notifier','position','top-center');
                alertify.success(response.status);
            },
        });
    });
}

function handleIncrementDecrementCart() {
    $('.increment-btn').click(function (e) {
        e.preventDefault();
        var incre_value = $(this).parents('.quantity').find('.qty-input').val();
        var value = parseInt(incre_value, 10);
        value = isNaN(value) ? 0 : value;
        if(value<10){
            value++;
            $(this).parents('.quantity').find('.qty-input').val(value);
        }

    });

    $('.decrement-btn').click(function (e) {
        e.preventDefault();
        var decre_value = $(this).parents('.quantity').find('.qty-input').val();
        var value = parseInt(decre_value, 10);
        value = isNaN(value) ? 0 : value;
        if(value>1){
            value--;
            $(this).parents('.quantity').find('.qty-input').val(value);
        }
    });
}

function changeQuantity() {
    $('.changeQuantity').click(function (e) {
        e.preventDefault();

        var quantity = $(this).closest(".cartpage").find('.qty-input').val();
        var product_id = $(this).closest(".cartpage").find('.product_id').val();

        console.log(quantity, product_id);

        var data = {
            '_token': $('input[name=_token]').val(),
            'quantity':quantity,
            'product_id':product_id,
        };

        $.ajax({
            url: '/update-to-cart',
            type: 'POST',
            data: data,
            success: function (response) {
                alertify.set('notifier','position','top-center');
                alertify.warning(response.status);

                setTimeout(() => {
                    window.location.reload();
                }, 2000);
            }
        });
    });
}

function handleDeleteItem() {
    $('.delete_cart_data').click(function (e) {
        e.preventDefault();

        var product_id = $(this).closest(".cartpage").find('.product_id').val();
        console.log(product_id);
        var data = {
            '_token': $('input[name=_token]').val(),
            "product_id": product_id,
        };
        //$(this).closest(".cartpage").remove();

        $.ajax({
            url: '/delete-from-cart',
            type: 'DELETE',
            data: data,
            success: function (response) {
                alertify.set('notifier','position','top-center');
                alertify.error(response.status);

                setTimeout(() => {
                    window.location.reload();
                }, 2000);
            }
        });
    });
}

function handleClearCookiesCart() {
    $('.clear_cart').click(function (e) {
        e.preventDefault();

        $.ajax({
            url: '/clear-cart',
            type: 'GET',
            success: function (response) {
                alertify.set('notifier','position','top-center');
                alertify.error(response.status);

                setTimeout(() => {
                    window.location.reload();
                }, 3000);
            }
        });

    });
}