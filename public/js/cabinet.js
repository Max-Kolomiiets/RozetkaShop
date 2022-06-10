$(function () {
    let currInfo = getUser();

    $("#edit-cabinet-data-btn").click(StartEdit);

    function StartEdit() {
        $(this).off('click');
        $(".personal-data-value input").removeAttr('class');
        $(".personal-data-value input").removeAttr('readonly');
        $("#edit-change-content").html(GetEditButtons());
        $("#cencel-cabinet-data-btn").click(cancelEdit);

        $('#submit-cabinet-data-btn').click(changeUserInfo);

        currInfo = getUser();
    }
    function cancelEdit(user = currInfo) {
        if(typeof user === 'object' && 'name' in user && 'email' in user) 
            setUser(user);
        else
            setUser(currInfo);

        $(this).off('click');
        $(".personal-data-value input").attr("class", "read-only-input");
        $(".personal-data-value input").attr('readonly', "true");
        $("#edit-change-content").html(GetStartEditButton());
        $("#edit-cabinet-data-btn").click(StartEdit);
    }

    function changeUserInfo() {
        let user = getUser();

        $.ajax({
            url: "/update-user-info",
            type: "POST",
            data: user,
            success: function (response) {
                if (response.code === -1) {
                    alertify.set('notifier', 'position', 'top-center');
                    alertify.error(response.status);
                } else {
                    alertify.set('notifier', 'position', 'top-center');
                    alertify.success(response.status);
                }
                cancelEdit(getUser());
            },
            error: function (response) {
                // make validation
                alertify.set('notifier', 'position', 'top-center');
                alertify.error(response.status);
            }
        });
    }

});
function GetStartEditButton() {
    return '<td><div class="cart-checkout-btn text-center" id="edit-cabinet-data-btn"><a class="btn btn-block checkout-btn">Редагувати</a></div></td>'
}
function GetEditButtons() {
    return '<td><input type="submit" class="btn btn-block checkout-btn" value="Підтвердити" id="submit-cabinet-data-btn"></td><td><div class="cart-checkout-btn text-center" id="cencel-cabinet-data-btn"><a class="btn btn-block checkout-btn">Скасувати</a></div></td>'
}

//private

function getUser() {
    let login = $('#user-login').val();
    let name = $('#user-name').val();
    let lastname = $('#user-lastname').val();
    let email = $('#user-email').val();
    let phone = $('#user-phone').val();
    let address = $('#user-address').val();

    return {
        login: login,
        name: name,
        lastname: lastname,
        email: email,
        phone: phone,
        address: address
    };
}

function setUser(user) {
    $('#user-login').val(user.login);
    $('#user-name').val(user.name);
    $('#user-lastname').val(user.lastname);
    $('#user-email').val(user.email);
    $('#user-phone').val(user.phone);
    $('#user-address').val(user.address);
}