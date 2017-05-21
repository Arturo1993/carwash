
<?php
include ("head.php");
include("connect.php");

if(isset($_POST['goods_ID']) && $_POST['goods_ID'] != "" && isset($_POST['quantity']) && $_POST['quantity'] != "" && isset($_POST['P_price']) && $_POST['P_price'] != "" && isset($_POST['branch_n']) && $_POST['branch_n'] != "") {
    $worker_query = mysqli_prepare($mysql, "INSERT INTO goods_details(idGood, Quantity, unit_paid, date_w) VALUES(?,?,?, NOW())") or die(mysqli_error($mysql));

    mysqli_stmt_bind_param($worker_query, "issi", $_POST['goods_ID'], $_POST['quantity'], $_POST['P_price'], $_POST['branch_n']);
    if (mysqli_stmt_execute($worker_query)) {
        echo "<div class='res'>'ჩაწერა ხოშიანად'</div>";
    } else {
        echo "<div class='res'>'რაღაც ვვერ წერს ჩახედე აბა'</div>";
    }
}
$branch_query = mysqli_query($mysql, "SELECT * FROM branch"); //branch lookup
$goods_query = mysqli_query($mysql, "SELECT * FROM goods"); //branch lookup

?>
<script>
    //როცა ჩაიტვირთება დოკუმენტი გაეშვას ფუნქცია
    $( document ).ready(function() {
        var branch_name = "";
        $("#sel1").on( "change", function(){
            branch_name = $(this).val();
        });

        var goods_ID = "";
        $("#sel2").on( "change", function(){
            goods_ID  = $(this).val();
        });
        //დაითრიე HTML ელემენტი რომელსაც აქვს ეს ID. და მაგის დაკლიკებაზე გაუშვი ფუნქცია რომელიც შედის ფუნქციის შიგნით.
        $("#br_id").on( "click", function() {
            //გამოცხადებულია 2 ცვლადი ბრენჩის სახელი და ბრენჩის მისამართი
            var crew_manager_name = $("#quantity").val();
            var crew_manager_surname = $("#P_price").val();
            //.val იღებს ინფუთად შეტანილ მნიშვნელობებს b_name ის val ში შეყვანილ მნიშვნელობას
            // და მნიშვნელობას ანიჭებს ჯავასკრიპტში გამოცხადებულ ცვლადს.
            //var branch_phone = $("#b_phone").val();
            $.ajax({
                //გაგზავნე აჯაქს რიქვესთი branch.php რიქვესტის ტიპი იყოს პოსტი.
                url: 'Manage_goods_details.php',
                type: 'POST',
                data: { Goods_N: goods_ID, quantity: crew_manager_name, P_price: crew_manager_surname, branch_n: branch_name } ,
                // ეს ცვალდები გაიგზავნოს php ფაილში აჯაქსიდან
                success: function (response) {
                    alert($(response).filter('div.res').text());
                    $("#quantity").val("");
                    $("#P_price").val("");
                    $("#sel1").val("");
                    $("#sel2").val("");
                }
            });
        });
    });
</script>
<form action="" method="post">
    <div class="col-sm-4">

        <div class="form-group">
            <label>პროდუქტის დასახელება:</label>
            <select class="form-control" id="sel2" required>
                <option></option>
                <?php while($goods_array = mysqli_fetch_array($goods_query)) {

                    echo "<option value='$goods_array[idGoods]' id='brn_opt'>$goods_array[GoodsName]</option>"; //branch lookup gagrdzeleba
                } ?>
            </select>
        </div>

        <div class="form-group">
            <label>რაოდენობა:</label>
            <input type="text" class="form-control" id="quantity">
        </div>

        <div class="form-group">
            <label>პროდუქტის ღირებულება:</label>
            <input type="text" class="form-control" id="P_price">
        </div>

        <div class="form-group">
            <label>ფილიალის დასახელება:</label>
            <select class="form-control" id="sel1" required>
                <option></option>
                <?php while($branch_array = mysqli_fetch_array($branch_query)) {
                    echo "<option value='$branch_array[idBranch]' id='brn_opt'>$branch_array[Branch_Name]</option>"; //branch lookup gagrdzeleba
                } ?>
            </select>
        </div>

        <div align="right">
            <input type="button" class="btn btn-default" name="branch_submit" id="br_id" value="დამატება">
        </div>
    </div>
</form>
<?php print_r($goods_array);