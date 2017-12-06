function changeOrderStatus(key) {
    $.ajax({
        method:"POST",
        url:"/js/basket_admin.php",
        data:"act=setBasket&id="+key,
        success:function (html) {
            $("#admin_basket").html(html);
        }
    });
}