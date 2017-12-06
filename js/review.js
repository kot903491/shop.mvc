function setReview() {
    var nam=$("#username").val();
    var email=$("#email").val();
    var review=$("#text").val();
    var id=$("#id").val();
    var str="name="+nam+"&email="+email+"&review="+review+"&id="+id;
    alert(str);
    $.ajax({
        type:'POST',
        url:"/js/review.php",
        data:str,
        success:function (data) {
            $('#answer').html(data);
        }
    });
    getReview();
    $(".reset").val("");
    getReview();
}

function getReview(){
    var id=$("#id").val();
    $.ajax({
        type:"POST",
        url:"/js/review.php",
        data:"id="+id,
        success:function (html) {
            $("#review").html(html);
        }
    });
}
$(document).ready(function(){
    getReview();
    setInterval('getReview()',300000);
});