function getCatalog(amt) {
    if (amt===undefined){
        amt=4;
    }
    var str="amt="+amt;
    $.ajax({
        type:"POST",
        url:"../../js/catalog.php",
        data:str,
        success:function (html) {
            $("#catalog").html(html);
        }
    });
}
$(document).ready(function(){
    getCatalog();
});