$(document).ready(function () {
    cartload();
    addToCart();
    handleIncrementDecrementCart();
    handleChangeQuantity();
    handleDeleteItem();
    handleClearCookiesCart();
    handleMakeOrder();
});

function cartload() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        url: '/cart-total',
        method: "GET",
        success: function (response) {
            $('.basket-item-count').html('');
            $('.basket-item-count').append($('<span class="badge badge-pill red">' + response['cartTotal'] + '</span>'));
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
                if (response.code === -1) {
                    alertify.set('notifier', 'position', 'top-center');
                    alertify.error(response.status);
                    return;
                }

                alertify.set('notifier', 'position', 'top-center');
                alertify.success(response.status);

                cartload();
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
        if (value > 0) {
            value++;
            $(this).parents('.quantity').find('.qty-input').val(value);
        }

    });

    $('.decrement-btn').click(function (e) {
        e.preventDefault();
        var decre_value = $(this).parents('.quantity').find('.qty-input').val();
        var value = parseInt(decre_value, 10);
        value = isNaN(value) ? 0 : value;
        if (value > 1) {
            value--;
            $(this).parents('.quantity').find('.qty-input').val(value);
        }
    });
}

function handleChangeQuantity() {

    $('.changeQuantity').click(function (e) {
        e.preventDefault();

        var quantity = $(this).closest(".cartpage").find('.qty-input').val();
        var product_id = $(this).closest(".cartpage").find('.product_id').val();

        changeQuantity(quantity, product_id);
    });

    $(".qty-input").change(function() {
        var quantity = $(this).closest(".cartpage").find('.qty-input').val();
        var product_id = $(this).closest(".cartpage").find('.product_id').val();

        if (quantity <= 0) return;

        changeQuantity(quantity, product_id);
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
                alertify.set('notifier', 'position', 'top-center');
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
                alertify.set('notifier', 'position', 'top-center');
                alertify.error(response.status);

                setTimeout(() => {
                    window.location.reload();
                }, 3000);
            }
        });

    });
}

function handleMakeOrder() {
    $('.btn-checkout').click(function (e) {
        e.preventDefault();
        console.log('btn-checkout ==.> ', this);

        // let name = $(this).closest(".cartpage").find('.qty-input').val();
        // let lastname = $(this).closest(".cartpage").find('.qty-input').val();
        // let patronymic = $(this).closest(".cartpage").find('.qty-input').val();
        // let phone = $(this).closest(".cartpage").find('.qty-input').val();

        // let product_id = $(this).closest(".cartpage").find('.product_id').val();

        let data = {
            '_token': $('input[name=_token]').val(),
            'name': 'name',
            'lastname': 'lastname',
            'patronymic': 'patronymic',
            'phone': 'phone',
        };

        $.ajax({
            url: '/make-order',
            type: 'POST',
            data: data,
            success: function (response) {
                if (response.code === -1) {
                    alertify.set('notifier', 'position', 'top-center');
                    alertify.error(response.status);
                    return;
                }

                alertify.set('notifier', 'position', 'top-center');
                alertify.warning(response.status);

                setTimeout(() => {
                    window.location.href = "/";
                }, 3000);
            }
        });
    });
}

// private

function changeQuantity (qty, prod_id) {
    let data = {
        '_token': $('input[name=_token]').val(),
        'quantity': qty,
        'product_id': prod_id,
    };

    $.ajax({
        url: '/update-cart',
        type: 'POST',
        data: data,
        success: function (response) {
            if (response.code === -1) {
                alertify.set('notifier', 'position', 'top-center');
                alertify.error(response.status);
                return;
            }

            alertify.set('notifier', 'position', 'top-center');
            alertify.warning(response.status);

            setTimeout(() => {
                window.location.reload();
            }, 2000);
        }
    });
}