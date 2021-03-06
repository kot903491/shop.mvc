function getBasket(){
    $.ajax({
        url:"/js/basket.php",
        success:function (html) {
            $("#basket").html(html);
        }
    });
}

function setBasket() {
    var id=$("#id").val();
    var str="id="+id;
    $.ajax({
        type:"POST",
        url:"/js/basket.php",
        data:str,
        success:function (html) {
            $("#basket").html(html);
        }
    });
}

$(document).ready(function(){
    getBasket();
    setInterval('getBasket()',30000);
});

function BasketTable() {
    $.ajax({
        method:"POST",
        data:"basket=getBasketTable",
        url:"/js/basket.php",
        success:function (html) {
            $("#baskettable").html(html);
        }
    });
}
$(document).ready(function(){
    BasketTable();
});

function deleteBasketId(key) {
    $.ajax({
        method: "POST",
        url: "/js/basket.php",
        data: "basket=deleteBasket&key=" + key,
        success:function (html) {
            $("#baskettable").html(html);
            getBasket();
            }
    });
}

