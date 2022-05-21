$(document).ready(function () {
    cartload();
    addToCart();
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

        var product_id = $(this).closest('.product_data').find('.product_id').val();
        var quantity = $(this).closest('.product_data').find('.qty-input').val();

        $.ajax({
            url: "/add-to-cart",
            method: "POST",
            data: {
                'quantity': quantity,
                'product_id': product_id,
            },
            success: function (response) {
                alertify.set('notifier','position','top-right');
                alertify.success(response.status);
            },
        });
    });
}