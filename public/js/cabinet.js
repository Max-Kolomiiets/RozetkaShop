$(function(){
    $("#edit-cabinet-data-btn").click(StartEdit);


});
function GetStartEditButton()
{
    return '<td><div class="cart-checkout-btn text-center" id="edit-cabinet-data-btn"><a class="btn btn-block checkout-btn">Редагувати</a></div></td>'
}
function GetEditButtons()
{  
    return '<td><input type="submit" class="btn btn-block checkout-btn" value="Підтвердити" id="submit-cabinet-data-btn"></td><td><div class="cart-checkout-btn text-center" id="cencel-cabinet-data-btn"><a class="btn btn-block checkout-btn">Скасувати</a></div></td>'
}
function StartEdit()
{
    $(this).off('click');
    $(".personal-data-value input").removeAttr('class');
    $(".personal-data-value input").removeAttr('readonly');
    $("#edit-change-content").html(GetEditButtons());
    $("#cencel-cabinet-data-btn").click(EndEdit);
}
function EndEdit()
{
    $(this).off('click');
    $(".personal-data-value input").attr("class", "read-only-input");
    $(".personal-data-value input").attr('readonly', "true");
    $("#edit-change-content").html(GetStartEditButton());
    $("#edit-cabinet-data-btn").click(StartEdit);
}