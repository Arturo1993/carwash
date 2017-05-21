<?php
include ("head.php");
include("connect.php");

if(isset($_POST['b_name']) && $_POST['b_name'] != "" && isset($_POST['b_address']) && $_POST['b_address'] != "") {

    $branch_query = mysqli_prepare($mysql, "INSERT INTO branch(Branch_Name, Address, date_b) VALUES(?, ?, NOW())") or die(mysqli_error($mysql));
    mysqli_stmt_bind_param($branch_query, "ss", $_POST['b_name'], $_POST['b_address']);
    if (mysqli_stmt_execute($branch_query)) {
        echo "<div class='res'>1</div>";
    } else {
        echo "<div class='res'>0</div>";
    }
}


?>
<script>
   //როცა ჩაიტვირთება დოკუმენტი გაეშვას ფუნქცია
    $( document ).ready(function() {
        //დაითრიე HTML ელემენტი რომელსაც აქვს ეს ID. და მაგის დაკლიკებაზე გაუშვი ფუნქცია რომელიც შედის ფუნქციის შიგნით.
        $("#br_id").on( "click", function() {
            //გამოცხადებულია 2 ცვლადი ბრენჩის სახელი და ბრენჩის მისამართი
            var branch_name = $("#b_name").val();
            var branch_address = $("#b_address").val();
            //.val იღებს ინფუთად შეტანილ მნიშვნელობებს b_name ის val ში შეყვანილ მნიშვნელობას
            // და მნიშვნელობას ანიჭებს ჯავასკრიპტში გამოცხადებულ ცვლადს.
            //var branch_phone = $("#b_phone").val();
            $.ajax({
                //გაგზავნე აჯაქს რიქვესთი branch.php რიქვესტის ტიპი იყოს პოსტი.
                url: 'Manage_branchs.php',
                type: 'POST',
                data: { b_name: branch_name, b_address: branch_address } ,
                // ეს ცვალდები გაიგზავნოს php ფაილში აჯაქსიდან
                success: function (response) {
                    var result = $($.parseHTML(response)).find("#res").text();
                    alert($(response).filter('div.res').text());
                    $("#b_name").val("");
                    $("#b_address").val("");
                }
            });
        });
    });
</script>
<form action="" method="post">
    <div class="col-sm-4">
        <div class="form-group">
            <label>ფილიალის სახელი:</label>
            <input type="text" class="form-control" id="b_name">
        </div>
        <div class="form-group">
            <label>ფილიალის მისამართი:</label>
            <input type="text" class="form-control" id="b_address">
        </div>
<!--        <div class="form-group">-->
<!--            <label>ფილიალის ტელეფონი:</label>-->
<!--            <input type="text" class="form-control" id="b_phone">-->
<!--        </div>-->
        <div align="right">
            <input type="button" class="btn btn-default" name="branch_submit" id="br_id" value="დამატება">
        </div>
    </div>
</form>

