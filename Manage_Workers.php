<?php
include ("head.php");
include("connect.php");

if(isset($_POST['w_name']) && $_POST['w_name'] != "" && isset($_POST['w_surname']) && $_POST['w_surname'] != "" && isset($_POST['branch_n']) && $_POST['branch_n'] != "") {
    $worker_query = mysqli_prepare($mysql, "INSERT INTO workers(Workers_Name, Worker_Surname, Branch_id, date_w) VALUES(?,?,?, NOW())") or die(mysqli_error($mysql));
    mysqli_stmt_bind_param($worker_query, "ssi", $_POST['w_name'], $_POST['w_surname'], $_POST['branch_n']);
    if (mysqli_stmt_execute($worker_query)) {
        echo "<div class='res'>'ჩაწერა ხოშიანად'</div>";
    } else {
        echo "<div class='res'>'რაღაც ვვერ წერს ჩახედე აბა'</div>";
    }
}
$branch_query = mysqli_query($mysql, "SELECT * FROM branch"); //branch lookup

?>
<script>
    //როცა ჩაიტვირთება დოკუმენტი გაეშვას ფუნქცია
    $( document ).ready(function() {
        var branch_name = "";
        $("#sel1").on( "change", function(){
            branch_name = $(this).val();
        });
        //დაითრიე HTML ელემენტი რომელსაც აქვს ეს ID. და მაგის დაკლიკებაზე გაუშვი ფუნქცია რომელიც შედის ფუნქციის შიგნით.
        $("#br_id").on( "click", function() {
            //გამოცხადებულია 2 ცვლადი ბრენჩის სახელი და ბრენჩის მისამართი
            var Workers_Name = $("#w_name").val();
            var Worker_Surname = $("#w_surname").val();
            //.val იღებს ინფუთად შეტანილ მნიშვნელობებს b_name ის val ში შეყვანილ მნიშვნელობას
            // და მნიშვნელობას ანიჭებს ჯავასკრიპტში გამოცხადებულ ცვლადს.
            //var branch_phone = $("#b_phone").val();
            $.ajax({
                //გაგზავნე აჯაქს რიქვესთი branch.php რიქვესტის ტიპი იყოს პოსტი.
                url: 'Manage_Workers.php',
                type: 'POST',
                data: { w_name: Workers_Name, w_surname: Worker_Surname, branch_n: branch_name } ,
                // ეს ცვალდები გაიგზავნოს php ფაილში აჯაქსიდან
                success: function (response) {
                    alert($(response).filter('div.res').text());
                    $("#w_name").val("");
                    $("#w_surname").val("");
                    $("#sel1").val("");
                }
            });
        });
    });
</script>
<form action="" method="post">
    <div class="col-sm-4">

        <div class="form-group">
            <label>თანამშრომლის სახელი:</label>
            <input type="text" class="form-control" id="w_name">
        </div>

        <div class="form-group">
            <label>თანამშრომლის გვარი:</label>
            <input type="text" class="form-control" id="w_surname">
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
