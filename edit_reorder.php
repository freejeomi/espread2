<?php
$sql= "";
$result= "";
include "lib/util.php";

$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$store_id=array();
$store_name=array();
$total_table="";
$thead="";
$counter_store=0;
$counter_stock=0;
$tbody="";
$stock_number=0;
$stock_code=array();
$stock_name=array();
$stock_id=array();
$trow_stock="";
$serial=1;
$number_store=0;

$stock_count_array=array();
//QUERY FOR STORE
$sql_store="SELECT store_id,store_name FROM store WHERE useinreorder=1";
$result_store=mysqli_query($conn,$sql_store);

//QUERY WAS EXECUTED
if($result_store){

//THERE ARE STORES
    if(mysqli_num_rows($result_store) > 0)
    {
    $number_store=mysqli_num_rows($result_store);
        $thead="<thead id=".$number_store."><tr ><th class='text-center hidden-print' colspan='".($number_store + 5)."' style='font-size: 2em;'>Edit Reorder Level</th></tr><tr ><th class='text-center visible-print' colspan='".($number_store + 4)."' style='font-size: 2em;'>Manage Reorder Level</th></tr><tr class='info'><th>S/No</th><th>Product</th><th>SKU</th><th>General</th>";
        while($row_store=mysqli_fetch_assoc($result_store)){
            $thead.="<th>".$row_store['store_name']."</th>";
            $store_id[$counter_store]=$row_store['store_id'];
            $counter_store++;

//END OF WHILE LOOP
        }
        $thead.="<th class='hidden-print'>Update</th></tr></thead>";

        //Get the Stock ID and Name And Stock Code

    }
    //NO STORE SO...
else{
    $thead="<thead id=".$number_store."><tr ><th class='text-center hidden-print' colspan='".($number_store + 5)."' style='font-size: 2em;'>Manage Reorder Level</th></tr><tr ><th class='text-center visible-print' colspan='".($number_store + 4)."' style='font-size: 2em;'>Edit Reorder Level<span class='text-danger'>(Only General Store)</span></th></tr><tr class='info'><th>S/No</th><th>Product</th><th>SKU</th><th>General</th><th class='hidden-print'>Update</th></tr></thead>";
}
    $sql_stock="SELECT stock_id,stock_code,stock_name,reorder_level FROM stock";
    $result_stock=mysqli_query($conn,$sql_stock);

//IF THE QUERY RAN
    if($result_stock){
// CHECK IF THERE IS A STOCK AT ALL
        if(mysqli_num_rows($result_stock)>0){

// IF THERE IS START TBODY
            $tbody="<tbody>";

// GET THE NUMBER OF THE STOCK I.E THE COUNT
            $stock_number=mysqli_num_rows($result_stock);

// FETCH EACH RESULT
            while($row_stock=mysqli_fetch_assoc($result_stock)){
// GET THE STOCK ID
                $stock_id[$counter_stock]=$row_stock['stock_id'];

                // MAKE THE TBODY HAVE A SERIAL NUMBER
                $tbody.="<tr><td>".$serial."</td><td><input type='hidden' value='".$row_stock['stock_id']."'>".$row_stock['stock_name']."</td><td>".$row_stock['stock_code']."</td><td ><input type='text' value='".$row_stock['reorder_level']."'></td>";
                // LOOP THRU THE STORES AND GET THE COUNT FOR EACH STOCK
                $i=0;
                foreach($store_id as $store){

//GET THE STOCK COUNT
                    $sql_position="SELECT reorder_level_store as reorder_level FROM stockposition WHERE stock_id='$stock_id[$counter_stock]' AND store_id='$store'";
                    $result_position=mysqli_query($conn,$sql_position);

                    // IF THE QUERY RAN....
                    if($result_position){
                        // CHECK IF THERE IS A ROW
                        if(mysqli_num_rows($result_position)>0){
                            // GET THE STOCK COUNT AND RUN THROUGH IT AGAIN
                            while($row_position=mysqli_fetch_assoc($result_position)){
                                $tbody.="<td><input type='text' class='reorder_level' value='".$row_position['reorder_level']."'><input type='hidden'  class='store_reorder' value='".$store."'></td>";
                                //$stock_count_array[$i]=$row_position['stock_count2'];
                            }
                        }

                        // IF THERE IS NO ROW, GIVE THE COUNT AS A ZERO
                        else{
                            $tbody.="<td><input type='text' class='reorder_level' value='0'><input type='hidden'  class='store_reorder' value='".$store."'></td>";
                            $stock_count_array[$i]=0;
                        }



                    }
                    $i++;
                }


                $tbody.="<td><button class='btn btn-primary btn-sm btn_update hidden-print' onclick='updateItem(this)'>Update</button></td></tr>";
                $serial++;


                $counter_stock++;
            }

            $tbody.="</tbody>";
        }

    }

}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit Reorder Level</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
</head>
<body>

<div class="row "  xmlns="http://www.w3.org/1999/html">
    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 table-responsive">
        <table class="table table-striped table-hover table-bordered hidden-print" id="table_update">
            <?php echo $thead; //print_r($store_id);?>
            <?php echo $tbody;?>
        </table>


    </div>
</div>
<table class="table table-striped table-hover table-bordered visible-print" style="width: 937px;" id="table_print">
    <?php echo $thead; //print_r($store_id);?>
    <?php echo $tbody;?>
</table>
<script src="js/libs/jquery-2.1.1.min.js"></script>
<script src="js/bootstrap/bootstrap.min.js"></script>
<script src="js/jquery.blockui.js"></script>
<script>


//$('input[type=text]').keyup(function () {
//   var input_val=$(this).val();
//    input_val=parseFloat(input_val.replace(/,/g, ''));
//    if(isNaN(input_val)){
//        $(this).val(0);
//    }
//});
function removeCommas(x){
    return parseFloat(x.replace(/,/g, ''));
}

    var button_td;
    var parent_row;
    var number_store;
    var store_to_start;
    var serial=0;
    var id=0;
    var td_reorder = new Array();
    var stock_id;
    var general;
    var i;
    var td_store = new Array();
    function updateItem (clicked) {
        //event.preventDefault();
        $.blockUI({
            message: '<h1 style=""><img style="" width="100" height="100" src="btn-ajax-loader.gif" />Loading...</h1>',
            css: {backgroundColor: '#000',opacity: .3, color: '#fff'}
        });
        td_reorder=[];
        td_store=[];
        var serial=0;
        var id=0;
        button_td = $(clicked).parent();
        number_store= $(clicked).parents('tbody').siblings('thead').attr('id');
        store_to_start= 4 + Number(number_store);
        parent_row=button_td.parent();
        stock_id= parent_row.children('td').eq(1).children('input').val();
       // console.log(stock_id);
        general= parent_row.children('td').eq(3).children('input').val();
        general=removeCommas(general);
        if(isNaN(general)){
            general=0;
        }
        //console.log(general);
        // alert(store_to_start);
        for(i=4;i<store_to_start;i++){
            console.log(i);
            td_reorder[serial]=parent_row.children('td').eq(i).children('.reorder_level').val();
            td_reorder[serial]=removeCommas(td_reorder[serial]);
            if(isNaN(td_reorder[serial])){
                td_reorder[serial]=0;
            }
            td_store[serial]=parent_row.children('td').eq(i).children('.store_reorder').val();
            serial++;
        }
        //alert(number_store);

        $.ajax({
            type 		: 'POST',
            url 		: 'edit_reorder_set.php',
            data 		: {
                data:JSON.stringify({reorder:td_reorder,store_id:td_store}),
                general:general,
                stock_id:stock_id

            },
            dataType 	: 'json',
            encode 		: true
        })
            // using the done promise callback
            .done( function (result1) {
                $.unblockUI();
                if(result1.success) {
                    // alert(result1.message);
                    $('#table_update').empty().html(result1.message);
                    $('#table_print').empty().html(result1.message);

                }

                else{
                    //alert(result.message);
                    alert(result1.message);
                    // $('#show_loader').html('');
                    //  $.unblockUI();
                }
            });
    }





</script>
</body>
</html>
