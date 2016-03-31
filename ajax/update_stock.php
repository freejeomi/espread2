<?php
require_once("inc/init.php");
require_once("userlogcheck_admin_and_manager.php");
$_SESSION['last_screen'] = "update_stock.php";
?>
<!-- row -->
<?php

include "../lib/util.php";
/**
 * Created by PhpStorm.
 * User: DQ
 * Date: 14/01/2016
 * Time: 4:02 PM
 */
//ini_set("display_errors","1");
//$servername = "localhost";
//$username = "root";
//$password = "Heaven192";
//$dbname = "espread";

// Create connection
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
$query1 = "SELECT store_id, store_name FROM store";
$result1 = mysqli_query($conn,$query1);
$response ='<option value="select_store">Select Store</option>';
while($row = mysqli_fetch_array($result1)) {
    $response .= '<option value="'.$row[0].'">'.$row[1].'</option>';
}
if(isset($_SESSION['user_id'])){
    $user_id=$_SESSION['user_id'];
}



?>


<div class="row"  xmlns="http://www.w3.org/1999/html">

    <!-- col -->


<!--    THE STOCK ID IS NOT SET, SO SHOW THE FULL PAGE-->
<?php
if(isset($_GET['stock_id']) && isset($_GET['store_id'])&& isset($_GET['stock_name'])){
?>
    <!--    For the Stock Task-->
    <div class="col-xs-12 col-sm-12 col-md-offset-3 col-lg-offset-3 col-md-6 col-lg-6">
        <div class="box box-default box-solid">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-gift"></i>
                    Update Stock </h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                </div><!-- /.box-tools -->
            </div><!-- /.box-header -->
            <div class="box-body" id="update_stock_div" >


                <!--                            form starts here-->
                <form class="form" name="stock_form" id="stock_form" action="submit_update_stock.php" method="post">
                    <!--                            stock name and date-->


                    <!--        HIDE THE STOCK NAME AND STOCK CODE-->
                    <input class="stock_name" type="hidden"></input>
                    <input type="hidden" name="stock_name" class="stock_name_input">

             <!--  For the Task Type-->

                    <div class="col-md-12" >

                        <!--                        FOR RESET-->
                        <div class="col-md-3 " style="padding: 0">
                            <label class="radio radio-inline">
                                <input type="radio" class="radiobox style-0"  name="task_type" value="reset">
                                <span>Reset</span>
                            </label>
                        </div>

               <!--                        FOR RECEIPT FROM SUPPLIER-->
                        <div class="col-md-3" style="padding: 0">
                            <label class="radio radio-inline">
                                <input type="radio" class="radiobox style-0" name="task_type" value="receipt">
                                <span>Receive</span>
                            </label>
                        </div>

                 <!--                        FOR STOCK TRANSFERED IN-->
                        <div class="col-md-3" style="padding: 0">
                            <label class="radio radio-inline">
                                <input type="radio" class="radiobox style-0" name="task_type" value="transfer_in">
                                <span>Transfer In</span>
                            </label>
                        </div>

                  <!--                        FOR STOCK TRANSFERED OUT-->
                        <div class="col-md-3" style="padding: 0">
                            <label class="radio radio-inline">
                                <input type="radio" class="radiobox style-0" name="task_type" value="transfer_out">
                                <span>Transfer Out</span>
                            </label>
                        </div>
                    </div>


                    <!--        For the Select and Count-->
                    <div class="bg-success col-md-12" id="enter_stock" style="margin-top: 2em; padding: 1em;">
                    <span>Current Store:&nbsp;<?php echo $_GET['store_name']?></span>
                        <input type="hidden" id="store_select" name="store_select" value="<?php echo $_GET['store_id'];?>">
         <span style="float: right">Current Stock Count:&nbsp;
             <span id="stock_count_orig">Not Available<input type="hidden" name="stock_count_input_orig" id="stock_count_input_orig">
             </span>
         </span>

                    </div>
                    <!--  For the Quantity-->
                    <div class="update_remark col-md-12" style="display: none;padding-top: 1em; padding-bottom: 2em; ">

                        <!--         TO SHOW THE RESULT OF THE SUBMIT OR ANY ERROR-->
                        <span class="show_result col-md-12 text-center"></span>

                        <!--         SHOW WHAT IS BEING DONE ON THE STORE-->
                        <div class="form-group col-md-12 text-center" id="task_description"  style="padding-top: 0;font-size: 1.1em" >Quantity</div>

                        <!--         THE QUANTITY INPUT COLUMN-->
                        <div class="form-group text-center" style="padding-bottom: 0;" id="quantity_error" >


                            <input type="number" min="0" step="1" class="form-control" id="quantity" name="quantity" placeholder="Enter Quantity" required autocomplete="off"/>

                        </div>

                        <!--         THE UPDATE DESCRIPTION-->
                        <div class="form-group col-md-12 text-center" id="update_description"  style="padding-top: 0;font-size: 1.1em; display: none;padding-bottom: 0;" >The new stock count will be:&nbsp;
                            <b> <span id="stock_count">Not Available</span></b>
                            <input type="hidden" name="stock_count_input" id="stock_count_input"></input>

                        </div>

                        <!--         THE REMARK DIV-->
                        <div class="form-group" style="padding-top: 1.2em;">


                            <input type="text" class="form-control" id="remark" name="remark" placeholder="Please Enter Remark"  autocomplete="off"/>

                        </div>
                    </div>

                    <!--  For the Update or reset stock-->
                    <div class="update_reset_stock col-md-12"  style="padding-top: 3em; display: none">
                        <button type="submit" class="btn btn-primary" name="submit" id="submit">Update Stock
                        </button>
                        <button type="reset" class="btn btn-default pull-right">Reset
                        </button>
                    </div>
                </form>


            </div><!-- /.box-body -->
        </div>
    </div>
    <?php
}
else{?>

    <div class="col-xs-12 col-sm-12 col-md-5 col-lg-4">
        <div class="box box-default box-solid">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-gift"></i>
                    Update Stock </h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                </div><!-- /.box-tools -->
            </div><!-- /.box-header -->
            <div class="box-body" id="update_stock_div" style="display: none;">


                <!--                            form starts here-->
                <form class="form" name="stock_form" id="stock_form" action="submit_update_stock.php" method="post">
                    <!--                            stock name and date-->


                    <!--        HIDE THE STOCK NAME AND STOCK CODE-->
                    <input class="stock_name" type="hidden"></input>
                    <input type="hidden" name="stock_name" class="stock_name_input">

                    <!--  For the Task Type-->

                    <div class="col-md-12" style="padding: 0;" >

<!--                        FOR RESET-->
                        <div class="col-md-3 " style="padding: 0">
                            <label class="radio radio-inline">
                                <input type="radio" class="radiobox style-0"  name="task_type" value="reset">
                                <span>Reset </span>
                            </label>
                        </div>

<!--                        FOR RECEIPT FROM SUPPLIER-->
                        <div class="col-md-3" style="padding: 0">
                            <label class="radio radio-inline">
                                <input type="radio" class="radiobox style-0" name="task_type" value="receipt">
                                <span class="text-center">Receive</span>
                            </label>
                        </div>

<!--                        FOR STOCK TRANSFERED IN-->
                        <div class="col-md-3" style="padding: 0">
                            <label class="radio radio-inline">
                                <input type="radio" class="radiobox style-0" name="task_type" value="transfer_in">
                                <span>Transfer In</span>
                            </label>
                        </div>

<!--                        FOR STOCK TRANSFERED OUT-->
                        <div class="col-md-3" style="padding: 0">
                            <label class="radio radio-inline">
                                <input type="radio" class="radiobox style-0" name="task_type" value="transfer_out">
                                <span>Transfer Out</span>
                            </label>
                        </div>
                    </div>


                    <!--        For the Select and Count-->
                    <div class="bg-success col-md-12" id="enter_stock" style="margin-top: 2em; padding: 1em;">

                        <select id="store_select" name="store_select"><?php echo $response;?></select>
         <span style="float: right">Current Stock Count:&nbsp;
             <span id="stock_count_orig">Not Available<input type="hidden" name="stock_count_input_orig" id="stock_count_input_orig">
             </span>
         </span>

                    </div>
                    <!--  For the Quantity-->
                    <div class="update_remark col-md-12" style="display: none;padding-top: 1em; padding-bottom: 2em; ">

                        <!--         TO SHOW THE RESULT OF THE SUBMIT OR ANY ERROR-->
                        <span class="show_result col-md-12 text-center"></span>

                        <!--         SHOW WHAT IS BEING DONE ON THE STORE-->
                        <div class="form-group col-md-12 text-center" id="task_description"  style="padding-top: 0;font-size: 1.1em" >Quantity</div>

                        <!--         THE QUANTITY INPUT COLUMN-->
                        <div class="form-group text-center" style="padding-bottom: 0;" id="quantity_error" >


                            <input type="number" min="0" step="1" class="form-control" id="quantity" name="quantity" placeholder="Enter Quantity" required autocomplete="off"/>

                        </div>

                        <!--         THE UPDATE DESCRIPTION-->
                        <div class="form-group col-md-12 text-center" id="update_description"  style="padding-top: 0;font-size: 1.1em; display: none;padding-bottom: 0;" >The new stock count will be:&nbsp;
                            <b> <span id="stock_count">Not Available</span></b>
                            <input type="hidden" name="stock_count_input" id="stock_count_input"></input>

                        </div>

                        <!--         THE REMARK DIV-->
                        <div class="form-group" style="padding-top: 1.2em;">


                            <input type="text" class="form-control" id="remark" name="remark" placeholder="Please Enter Remark"  autocomplete="off"/>

                        </div>
                    </div>

                    <!--  For the Update or reset stock-->
                    <div class="update_reset_stock col-md-12"  style="padding-top: 3em; display: none">
                        <button type="submit" class="btn btn-primary" name="submit" id="submit">Update Stock
                        </button>
                        <button type="reset" class="btn btn-default pull-right">Reset
                        </button>
                    </div>
                </form>


            </div><!-- /.box-body -->
        </div>
    </div>
    <!-- /.box -->

    <!-- end col end stock task-->

    <!-- right side of the page for the tables -->
    <!-- col -->
    <div class="col-xs-12 col-sm-12 col-md-7 col-lg-8">

        <div id="resize-grid">



            <!-- widget content -->


            <!-- this is what the user will see -->
            <table id="jqgrid"></table>
            <div id="pjqgrid"></div>

        </div>
        <!-- end widget content -->


        <!-- end widget div -->




        <!-- end of table -->

        <!-- end col -->

    </div>

    <?php


}?>

</div>





<script type="text/javascript">

    /* DO NOT REMOVE : GLOBAL FUNCTIONS!
     *
     * pageSetUp(); WILL CALL THE FOLLOWING FUNCTIONS
     *
     * // activate tooltips
     * $("[rel=tooltip]").tooltip();
     *
     * // activate popovers
     * $("[rel=popover]").popover();
     *
     * // activate popovers with hover states
     * $("[rel=popover-hover]").popover({ trigger: "hover" });
     *
     * // activate inline charts
     * runAllCharts();
     *
     * // setup widgets
     * setup_widgets_desktop();
     *
     * // run form elements
     * runAllForms();
     *
     ********************************
     *
     * pageSetUp() is needed whenever you load a page.
     * It initializes and checks for all basic elements of the page
     * and makes rendering easier.
     *
     */

    pageSetUp();

    /*
     * ALL PAGE RELATED SCRIPTS CAN GO BELOW HERE
     * eg alert("my home function");
     *
     * var pagefunction = function() {
     *   ...
     * }
     * loadScript("js/plugin/_PLUGIN_NAME_.js", pagefunction);
     *
     * TO LOAD A SCRIPT:
     * var pagefunction = function (){
     *  loadScript(".../plugin.js", run_after_loaded);
     * }
     *
     * OR you can load chain scripts by doing
     *
     * loadScript(".../plugin.js", function(){
     * 	 loadScript("../plugin.js", function(){
     * 	   ...
     *   })
     * });
     */

    // pagefunction

    var pagefunction = function() {
        loadScript("js/plugin/jqgrid/jquery.jqGrid.min.js", run_jqgrid_function);


        function run_jqgrid_function() {
// Customize the grid
            var rowkey = "<?php if(isset($_GET['stock_id'])){echo $_GET['stock_id'];}?>";
            <?php if(isset($_GET['stock_id'])){
            $stock_id=$_GET['stock_id'];
            echo "$('.stock_name_input').val('".$stock_id."');";

            }?>
            var myRadio;
            var radio_value;var checkedValue;
            var tasktype;
            var store_select;
            var requestData;
            var stock_count_present;
            var quantity_now;
            var quantity_change;var new_stock;
            var stock_name="";
            var stock_name_input;
            var grid;

            var user_id="<?php echo $user_id;?>";
            var tasktype_desc;
            var stock_name_show="<?php if(isset($_GET['stock_id'])) echo $_GET['stock_name'];?>";
            var store_select_show="<?php if(isset($_GET['stock_id'])) echo $_GET['store_name'];?>";
            var store_id_show="<?php if(isset($_GET['stock_id'])) echo $_GET['store_id'];?>";

            if(store_select_show!=""){
                requestData={stock_id: $('.stock_name_input').val(), store_id:store_id_show };
                makeajax(requestData);
            }

            //TO MAKE THE NUMBERS HAVE COMMAS
            function numberWithCommas(x) {
                return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            }

            //FUNCTION TO CHANGE THE TASK TYPE AND QUANTITY
            function task_check(task){
                if(stock_name_show!="") {

                    if (task == "receipt") {
                        $('#task_description').empty().html("Receive <b>" + stock_name_show + "</b> in <b>" + store_select_show + "</b> of quantity " + numberWithCommas(Number($('#quantity').val())));
                    }
                    if (task == "transfer_out") {
                        $('#task_description').empty().html("Transfer <b>" + stock_name_show + "</b> from <b>" + store_select_show + "</b>, quantity " + numberWithCommas(Number($('#quantity').val())));
                    }
                    if (task == "transfer_in") {
                        $('#task_description').empty().html("Receive <b>" + stock_name_show + "</b> in <b>" + store_select_show + "</b> of quantity " + numberWithCommas(Number($('#quantity').val())));
                    }
                    if (task == "reset") {
                        $('#task_description').empty().html("Reset <b>" + stock_name_show + "</b> count for <b>" + store_select_show + "</b> to " + numberWithCommas(Number($('#quantity').val())));
                    }
                    if ($("#store_select").val() == "select_store") {
                        $('#task_description').empty().html("<b>Please Select store to perform operation on </b>" + stock_name_show);
                    }
                }
                else {
                    if (task == "receipt") {
                        $('#task_description').empty().html("Receive <b>" + $('tr#' + rowkey + '').children('td').eq(2).text() + "</b> in <b>" + $("#store_select option:selected").text() + "</b> of quantity " + numberWithCommas(Number($('#quantity').val())));
                    }
                    if (task == "transfer_out") {
                        $('#task_description').empty().html("Transfer <b>" + $('tr#' + rowkey + '').children('td').eq(2).text() + "</b> from <b>" + $("#store_select option:selected").text() + "</b>, quantity " + numberWithCommas(Number($('#quantity').val())));
                    }
                    if (task == "transfer_in") {
                        $('#task_description').empty().html("Receive <b>" + $('tr#' + rowkey + '').children('td').eq(2).text() + "</b> in <b>" + $("#store_select option:selected").text() + "</b> of quantity " + numberWithCommas(Number($('#quantity').val())));
                    }
                    if (task == "reset") {
                        $('#task_description').empty().html("Reset <b>" + $('tr#' + rowkey + '').children('td').eq(2).text() + "</b> count for <b>" + $("#store_select option:selected").text() + "</b> to " + numberWithCommas(Number($('#quantity').val())));
                    }
                    if ($("#store_select").val() == "select_store") {
                        $('#task_description').empty().html("<b>Please Select store to perform operation on </b>" + $('tr#' + rowkey + '').children('td').eq(2).text());
                    }
                }
            }

            function makeajax(requestdata){
                $.post('get_stock_count.php', requestdata, function (data) {

                    if (data == '') {
                        $('#stock_count_orig').text(0);
                        $('#stock_count').text(0);
                        $('#stock_count_input').val(0);
                        stock_count_present =0;
                    }
                    else {
                        $('#stock_count_orig').text(numberWithCommas(Number(data)));
                        $('#stock_count').text(numberWithCommas(Number(data)));
                        stock_count_present =data;
                        $('#stock_count_input').val(data);
                    }






                });
            }
            jQuery("#jqgrid").jqGrid({
                //data : jqgrid_data,
                url: "ajax/stock_inventory/update_stock_grid_get.php",
                datatype: "json",
                mtype: "GET",
                height : 'auto',
                page: 1,
                colNames : [ 'Stock Id', 'SKU','Stock Name', 'Supplier name'],
                colModel : [
                     {

                        name : 'stock_id',
                        index : 'stock_id',
                        sortable : true,
                         hidden: true


                    },{
                        name : 'stock_code',
                        index : 'stock_code',
                        editable : false,
                        search:true,
                        searchoptions: {
                            attr:{title:'Filter by Stock Code',placeholder:'Search by Stock Code'},
                            clearSearch:true,
                            //sopt:['cn','in']
                        }

                    }, {
                        name : 'stock_name',
                        index : 'stock_name',
                        editable : false,
                        search:true,
                        searchoptions: {
                        attr:{title:'Filter by Stock Name',placeholder:'Search by stock name'},
                            clearSearch:true,
                            //sopt:['cn','in']
                        }

                    },



                    {

                        name : 'supplier_name',
                        index : 'supplier_name',
                        sortable : true,
                        editable : false,
                        search:true,
                        searchoptions: {
                            attr:{title:'Select Supplier Name',placeholder:'Search by Supplier name'},

                            clearSearch:true,
                           //sopt:['cn','in']
                        }

                    }


                ],
                rowNum : 10,
                //rowList : [10, 20, 30],
                rowTotal:-1,

                loadonce:true,
                ignoreCase: true,



                pager : '#pjqgrid',
                sortname : 'stock_id',
                toolbarfilter : true,
                viewrecords : true,
                caption : "Stock",
                autowidth : true,

//                UNCOMMENT TO CHANGE BEHAVIOUR OF GRID BACK TO DEFAULT WITH GET
//                onSelectRow: function (rowid) {
//                    $('.stock_name_input').val('');
////This sets of code gets the selected row id
//                    $('.box-body').slideDown('slow');
//                    $('#store_select').val('select_store').trigger('change');
//                    rowkey=rowid;
//                    task_check(radio_value);
//                    // $('.show_result').empty().hide('fast');
//                    $('#quantity_error').removeClass('has-error');
//                    $('.help-block').remove();
////Trigger the select to select the default select store
//
//                    //this makes the stock_name to be displayed on the stock_name input
//                    stock_name = $('tr#' + rowkey + '').children('td').eq(2).text();
//                    $('.stock_name').text(stock_name);
//                    $('.stock_name_input').text(stock_name).val(rowkey);
//                    stock_name_input = $('.stock_name_input').val();
//                },
//                gridComplete: function () {
//                    <?php //if(isset($_GET['stock_id'])){
//                    $stock_id=$_GET['stock_id'];
//                    echo 'jQuery("#jqgrid").jqGrid("setSelection", "'.$stock_id.'");';
//                    }?>
//                }


            });

            //I'm submitting the form now


//            Show tool Tip
            $('.navtable .ui-pg-button').tooltip({
                container : 'body'
            });
//            $('#jqgrid').jqGrid('filterToolbar',{ searchOnEnter: false});
            $('#jqgrid').jqGrid('navGrid',"#pjqgrid",
            {
                search: true, // show search button on the toolbar
                add: false,
                edit: false,
                del: false,
                refresh: true
            },
                {},//default settings edit
                {},//default settings add
                {},//default settings delete
                {caption: "Search Stock...",
                    closeAfterSearch: true,
                    closeAfterReset: true,
                    closeOnEscape: true

                },//default settings search
                {}//default settings view
            );




//            How the Left column starts showing initially

//            For the collapsible menu



//This is the function needed for the table and left side display
//            CHECKS THE ROW THAT IS CLICKED
            $('#jqgrid').click(function () {

                grid = $("#jqgrid");

                rowkey = grid.jqGrid('getGridParam', "selrow");


                $('.box-body').slideDown('slow');
                $('#store_select').val('select_store').trigger('change');

                task_check(radio_value);
                // $('.show_result').empty().hide('fast');
                $('#quantity_error').removeClass('has-error');
                $('.help-block').remove();

                //If this is a row, then
                if (rowkey) {
                    task_check(radio_value);
                   // $('.show_result').empty().hide('fast');
                    $('#quantity_error').removeClass('has-error');
                    $('.help-block').remove();
//Trigger the select to select the default select store

                    //this makes the stock_name to be displayed on the stock_name input
  stock_name = $('tr#' + rowkey + '').children('td').eq(2).text();
             $('.stock_name').text(stock_name);
               $('.stock_name_input').text(stock_name).val(rowkey);
                  stock_name_input = $('.stock_name_input').val();
                    //this gets the value of this input i.e the id because that will be sent to the server
                }

                //Check if the radio button was clicked and which one
            });


                        //IF THE RADIO BUTTON CHANGES
$('#stock_form input[name=task_type]:radio').change(function () {
    //$('#store_select').val('select_store').trigger('change');
    $('.show_result').empty().hide('fast');
    $('#quantity_error').removeClass('has-error');
    $('.help-block').remove();

    myRadio = $('input[name=task_type]');
    radio_value = myRadio.filter(':checked').val();

       $('.update_reset_stock, .update_remark').slideDown('fast');
        $('#quantity').val('');
       $("#submit").prop('disabled', true);

    checkedValue = myRadio.filter(':checked').parent().children('span').text();
    $('#task_type_change').text(checkedValue);
    task_check(radio_value);


                switch(radio_value) {
                  case 'reset':
                      tasktype= 'reset';
                      tasktype_desc="Reset ";
                      if(isNaN($('#store_count').text())){
                       $("#quantity,#remark").prop('disabled', true);

                        }

                     break;
                  case 'receipt':
                     tasktype='receipt';

                     if(isNaN($('#store_count').text())){
                       $("#quantity,#remark").prop('disabled', true);}
                    break;
                    case 'transfer_in':
                        tasktype='transfer_in';

                        if(isNaN($('#store_count').text())){
                            $("#quantity,#remark").prop('disabled', true);}
                        break;
                  case 'transfer_out':
                  tasktype='transfer_out';

                  if(isNaN($('#store_count').text())){
                    $("#quantity,#remark").prop('disabled', true);}
                  break;

                        }
      });


      //STORE SELECTED CHANGES
      $('#store_select').change(function () {
         // $('.show_result').empty().hide('fast');
          $('#quantity_error').removeClass('has-error');
          $('.help-block').remove();
      $('#quantity').val('');
     store_select = $("#store_select").val();
      task_check(radio_value);

//if the select store is the default, display non-available
  if (store_select == 'select_store') {
   $('#stock_count').text('Not Available');
      $('#stock_count_orig').text('Not Available');
      $("#quantity,#remark").prop('disabled', true);
      $('#stock_count_input').val(0);
     }

  //if it is another option perform some ajaxing and other things
   if (store_select != 'select_store') {
       $("#quantity,#remark").prop('disabled', false);


  requestData = {stock_id: $('.stock_name_input').val(), store_id: store_select};
      makeajax(requestData);
//     Check for quantity

                                    }
                                    //End of if select store_select
                                });
                        //END OF SELECTED STORE

            //QUANTITY HAS CHANGED
       $("#quantity").on("keyup click", function () {
           $('.show_result').empty().hide('fast');
           $('#quantity_error').removeClass('has-error');
           $('.help-block').remove();
           task_check(radio_value);
           if ($('#quantity').val() == "") {
               $('#quantity').val(0);
           }

           if (isNaN(parseInt($('#quantity').val()))) {

               $('#quantity').val('');
               $("#submit").prop('disabled', true);
               $('#quantity_error').addClass('has-error').append('<div class="help-block">Quantity must be a number</div>');
           }
           else {
               quantity_now = Number($('#quantity').val());
               $('#update_description').show('fast');
               if (quantity_now < 0) {
                   $('#quantity').val('');
                   $("#submit").prop('disabled', true);
                   $('#quantity_error').addClass('has-error').append('<div class="help-block">Quantity must be a positive number</div>');

               }
               else {//     Check for the type of task
                   $('.show_result').empty().hide('fast');
                   if (tasktype == 'reset') {
                       quantity_change = quantity_now;
                       $('#stock_count').text(numberWithCommas(quantity_change));
                       new_stock = quantity_change;
                       $("#submit").prop('disabled', false);
                   }

                   if (tasktype == 'receipt') {
                       //if there is no quantity in the input
                       if(quantity_now==0){
                           $('#quantity_error').addClass('has-error').append('<div class="help-block">Quantity received must be greater than zero</div>');
                           $("#submit").prop('disabled', true);
                       }

                       else{
                           quantity_change = Number(stock_count_present) + Number(quantity_now);

                           $('#stock_count').text(numberWithCommas(quantity_change));
                           new_stock = quantity_change;
                           $("#submit").prop('disabled', false);
                       }


                   }
                   if (tasktype == 'transfer_in') {
                       //if there is no quantity in the input
                       if(quantity_now==0){
                           $('#quantity_error').addClass('has-error').append('<div class="help-block">Quantity received via transfer must be greater than zero</div>');
                           $("#submit").prop('disabled', true);
                       }

                       else{
                           quantity_change = Number(stock_count_present) + Number(quantity_now);

                           $('#stock_count').text(numberWithCommas(quantity_change));
                           new_stock = quantity_change;
                           $("#submit").prop('disabled', false);
                       }


                   }

                   if (tasktype == 'transfer_out') {
                       if (Number(stock_count_present) == 0) {
                           $('#quantity_error').addClass('has-error').append('<div class="help-block">Stock count too low for transfer, update stock count</div>');
                           $('#stock_count').text(0);
                           $('#stock_count_input').text(0);
                           $("#submit").prop('disabled', true);


                       }
                       else if (Number(stock_count_present) > 0 && Number(stock_count_present) < Number(quantity_now)) {
                           $('#quantity_error').addClass('has-error').append('<div class="help-block">Cannot transfer more than the stock count present</div>');

                           $("#submit").prop('disabled', true);

                       }
                       else {
                           quantity_change = Number(stock_count_present) - Number(quantity_now);
                           new_stock = quantity_change;
                           $('#stock_count').text(numberWithCommas(quantity_change));

                           $("#submit").prop('disabled', false);
                       }

                   }


                   $('#stock_count_input').val(new_stock);
               }


           }
       });


    //I'm posting data ooo via ajax

       $('#submit').click(function(event) {
              event.preventDefault();
              var formData = {
                  'task' : $('input[name=task_type]').filter(':checked').val(),
                  'quantity': $('input[name=quantity]').val(),
                  'remark' : $('input[name=remark]').val(),
                  'closingbal' : $('#stock_count_input').val(),
                  'stock_id'    : $('.stock_name_input').val(),
                  'store_id'    : $('#store_select').val(),
                  'user_id':user_id

              };
              $.post('submit_update_stock.php',formData, function (result) {
                    if(result == '1'){
                        if(stock_name_show!=""){
                            $("#quantity").val('');
                            $("#remark").val('');
                            $("#submit").prop('disabled', true);
                            $('#update_description').hide('fast');
                            $('.show_result').empty().fadeIn('fast').append("<div class='alert alert-success'><button class='close' data-dismiss='alert'>&times;</button><strong>Success! </strong>  Stock Has been Updated</div>").fadeOut(4000);
                            requestData={stock_id: $('.stock_name_input').val(), store_id:store_id_show };
                            makeajax(requestData);
                        }
                        else{
                            jQuery('#jqgrid').jqGrid('setGridParam',{url:"ajax/stock_inventory/update_stock_grid_get.php", page: 1,datatype: "json"}).trigger("reloadGrid");
                            $("#quantity").val('');
                            $("#remark").val('');
                            $("#submit").prop('disabled', true);
                            $('#update_description').hide('fast');

                            //$('.stock_name').text('');
                            //$('.stock_name_input').val('');
                            $('#stock_count').text('');

                            $('#quantity_error').removeClass('has-error');
                            $('.help-block').remove();

                            $('.show_result').empty().fadeIn('fast').append("<div class='alert alert-success'><button class='close' data-dismiss='alert'>&times;</button><strong>Success! </strong>  Stock Has been Updated</div>").fadeOut(4000);

                            $('#store_select').val('select_store').trigger('change');
                        }

// $('#stock_form input[name=task_type]:radio').prop('checked',false);
                     // Refresh the jQuery UI buttonset.                  
                       


                       // $('.box-body').delay(3000).slideUp('fast');
                       
                    }
                  if(result == '0') {
                      if (stock_name_show != "") {
                          $("#quantity").val('');
                          $("#remark").val('');
                          $("#submit").prop('disabled', true);
                          $('#update_description').hide('fast');
                          $('.show_result').show('fast').empty().append("<div class='alert alert-error'><button class='close' data-dismiss='alert'>&times;</button><strong>Sorry!</strong>  Update Stock Failed</div>").fadeOut(4000);

                      }

                      else {


                          $('.show_result').show('fast').empty().append("<div class='alert alert-error'><button class='close' data-dismiss='alert'>&times;</button><strong>Sorry!</strong>  Update Stock Failed</div>").fadeOut(4000);

                          $('#store_select').val('select_store').trigger('change');
//      $('#stock_form input[name=task_type]:radio').prop('checked',false);
                          // Refresh the jQuery UI buttonset.
                          $('#quantity_error').removeClass('has-error');
                          $('.help-block').remove();
                          jQuery('#jqgrid').jqGrid('setGridParam',{url:"ajax/stock_inventory/update_stock_grid_get.php", page: 1,datatype: "json"}).trigger("reloadGrid");
                          $("#quantity").val('');
                          $("#remark").val('');
                          $("#submit").prop('disabled', true);

                          // $('.stock_name').text('');
                          // $('.stock_name_input').val('');
                          $('#stock_count').text('');
                          $('#stock_count_input').val(0);
                      }

                  }
                if(result=="no"){
                    if (stock_name_show != "") {
                        $("#quantity").val('');
                        $("#remark").val('');
                        $("#submit").prop('disabled', true);
                        $('#update_description').hide('fast');
                        $('.show_result').show('fast').empty().append("<div class='alert alert-error'><button class='close' data-dismiss='alert'>&times;</button><strong>Sorry!</strong> You are unable to perform any business transaction until the next business day.</div>");

                    }
                    else{
                        $('.show_result').show('fast').empty().append("<div class='alert alert-error'><button class='close' data-dismiss='alert'>&times;</button><strong>Sorry!</strong> You are unable to perform any business transaction until the next business day.</div>");

                        $('#store_select').val('select_store').trigger('change');
//      $('#stock_form input[name=task_type]:radio').prop('checked',false);
                        // Refresh the jQuery UI buttonset.
                        $('#quantity_error').removeClass('has-error');
                        $('.help-block').remove();
                        jQuery("#jqgrid").trigger("reloadGrid");
                        $("#quantity").val('');
                        $("#remark").val('');
                        $("#submit").prop('disabled', true);

                        // $('.stock_name').text('');
                        // $('.stock_name_input').val('');
                        $('#stock_count').text('');
                        $('#stock_count_input').val(0);
                    }

                }

              });
          });
          //close stock name change


//closee if rowkey

                //close left side

            
            
            //for the radio button check


            //forthe button tool
            $('.btn-box-tool').click(function () {
                $('.box-body').slideToggle('slow');
                $('.btn-box-tool i').toggleClass('fa-plus fa-minus');
            });
            // activate the toolbar searching




            // remove classes
            $(".ui-jqgrid").removeClass("ui-widget ui-widget-content");
            $(".ui-jqgrid-view").children().removeClass("ui-widget-header ui-state-default");
            $(".ui-jqgrid-labels, .ui-search-toolbar").children().removeClass("ui-state-default ui-th-column ui-th-ltr");
            $(".ui-jqgrid-pager").removeClass("ui-state-default");
            $(".ui-jqgrid").removeClass("ui-widget-content");

            // add classes
            $(".ui-jqgrid-htable").addClass("table table-bordered table-hover");
            $(".ui-jqgrid-btable").addClass("table table-bordered table-striped");

            $(".ui-pg-div").removeClass().addClass("btn btn-sm btn-primary");
            $(".ui-icon.ui-icon-plus").removeClass().addClass("fa fa-plus");
            $(".ui-icon.ui-icon-pencil").removeClass().addClass("fa fa-pencil");
            $(".ui-icon.ui-icon-trash").removeClass().addClass("fa fa-trash-o");
            $(".ui-icon.ui-icon-search").removeClass().addClass("fa fa-search");
            $(".ui-icon.ui-icon-refresh").removeClass().addClass("fa fa-refresh");
            $(".ui-icon.ui-icon-disk").removeClass().addClass("fa fa-save").parent(".btn-primary").removeClass("btn-primary").addClass("btn-success");
            $(".ui-icon.ui-icon-cancel").removeClass().addClass("fa fa-times").parent(".btn-primary").removeClass("btn-primary").addClass("btn-danger");

            $(".ui-icon.ui-icon-seek-prev").wrap("<div class='btn btn-sm btn-default'></div>");
            $(".ui-icon.ui-icon-seek-prev").removeClass().addClass("fa fa-backward");

            $(".ui-icon.ui-icon-seek-first").wrap("<div class='btn btn-sm btn-default'></div>");
            $(".ui-icon.ui-icon-seek-first").removeClass().addClass("fa fa-fast-backward");

            $(".ui-icon.ui-icon-seek-next").wrap("<div class='btn btn-sm btn-default'></div>");
            $(".ui-icon.ui-icon-seek-next").removeClass().addClass("fa fa-forward");

            $(".ui-icon.ui-icon-seek-end").wrap("<div class='btn btn-sm btn-default'></div>");
            $(".ui-icon.ui-icon-seek-end").removeClass().addClass("fa fa-fast-forward");

            // update buttons

            $(window).on('resize.jqGrid', function() {
                $("#jqgrid").jqGrid('setGridWidth', $("#resize-grid").width());
            });

            //$('#post_result').html(jqgrid_data);
            //});
            //alert ($('#jsondata').val());
            //alert (jqgrid_data);




        }// end function

    }
    loadScript("js/plugin/jqgrid/grid.locale-en.min.js", pagefunction);

</script>
