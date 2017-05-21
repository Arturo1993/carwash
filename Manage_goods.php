<?php
include ("head.php");
include("connect.php");

if(isset($_POST['g_name']) && $_POST['g_name'] != "" ) {
    $worker_query = mysqli_prepare($mysql, "INSERT INTO goods(GoodsName, date_w) VALUES(?, NOW())") or die(mysqli_error($mysql));

    mysqli_stmt_bind_param($worker_query, "s", $_POST['g_name']);
    if (mysqli_stmt_execute($worker_query)) {
        echo "<div class='res'>'ჩაწერა ხოშიანად'</div>";
    } else {
        echo "<div class='res'>'რაღაც ვვერ წერს ჩახედე აბა'</div>";
    }
}


?>
<script>
    //როცა ჩაიტვირთება დოკუმენტი გაეშვას ფუნქცია
    $( document ).ready(function() {

        //დაითრიე HTML ელემენტი რომელსაც აქვს ეს ID. და მაგის დაკლიკებაზე გაუშვი ფუნქცია რომელიც შედის ფუნქციის შიგნით.
        $("#br_id").on( "click", function() {
            //გამოცხადებულია 2 ცვლადი ბრენჩის სახელი და ბრენჩის მისამართი
            var GoodsName = $("#g_name").val();
            //.val იღებს ინფუთად შეტანილ მნიშვნელობებს b_name ის val ში შეყვანილ მნიშვნელობას
            // და მნიშვნელობას ანიჭებს ჯავასკრიპტში გამოცხადებულ ცვლადს.
            //var branch_phone = $("#b_phone").val();
            $.ajax({
                //გაგზავნე აჯაქს რიქვესთი branch.php რიქვესტის ტიპი იყოს პოსტი.
                url: 'Manage_goods.php',
                type: 'POST',
                data: { g_name: GoodsName} ,
                // ეს ცვალდები გაიგზავნოს php ფაილში აჯაქსიდან
                success: function (response) {
                    alert($(response).filter('div.res').text());
                    $("#g_name").val("");
                    $("#sel1").val("");
                }
            });
        });
    });
</script>
<form action="" method="post">
    <div class="col-sm-4">

        <div class="form-group">
            <label>პროდუქტის დასახელება:</label>
            <input type="text" class="form-control" id="g_name">
        </div>

        <div align="right">
            <input type="button" class="btn btn-default" name="branch_submit" id="br_id" value="დამატება">
        </div>
    </div>
</form>
