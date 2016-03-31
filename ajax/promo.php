<?php
require_once("inc/init.php");
require_once("userlogcheck_admin_and_manager.php");
$_SESSION['last_screen'] = "promo.php";
?>
<!-- row -->
<?php


include "../lib/util.php";

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
$query1 = "SELECT stock_code, stock_name FROM stock";
$result1 = mysqli_query($conn,$query1);
$response2 ='<option value="blank">--- Select Product ---</option>';
$response1='';
while($row = mysqli_fetch_array($result1)) {
    $response2 .= '<option value="'.$row[0].'">'.$row[1].'</option>';
    $response1 .= '<option value="'.$row[0].'">'.$row[1].'</option>';
}



?>
<div class="row"  xmlns="http://www.w3.org/1999/html">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

<!--    for the promo selects -->
    <div class="box box-default box-solid">
        <div class="box-header with-border">
            <h3 class="box-title"><i class="fa fa-gift"></i>
                Add Promo </h3>
            <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div><!-- /.box-tools -->
        </div><!-- /.box-header -->
        <div class="box-body" id="promo_div" >
        <form class="smart-form" id="add_promo" action="submit_add_promo">

<!--            First select first quantity to buy-->
    <section class="form-group col-md-12 col-xs-12 col-lg-12 col-sm-12">
        <label class="label col-xs-offset-2 col-xs-1" style="color: #333;padding: 0.5em 0 0 1em;">Buy This</label>

            <section class="col-xs-2">
        <label class="select">
            <select id="select1">
                <?php echo $response1;?>
            </select> <i></i> </label>
    </section>
        <section class="form-group" id="quantity1_group">
        <label for="quantity1" class="col-xs-1" id="quantity1_label" style="padding: 0.5em 0 0 5em;">Quantity:</label>
        <div class="col-xs-2 input">
            <input type="text" class="form-control " id="quantity1" name="quantity1" placeholder="Please Enter the Quanity" value="" autocomplete="off"/></div>

    </section>
        </section>

<!--            Second select what other quantity to buy-->
            <section class="form-group col-md-12 col-xs-12 col-lg-12 col-sm-12">
                <label class="label col-xs-offset-2 col-xs-1" style="color: #333;padding: 0.5em 0 0 1em;">And Buy This</label>

                <section class="col-xs-2">
                    <label class="select">
                        <select id="select2">
                            <?php echo $response2;?>
                        </select> <i></i> </label>
                </section>
                <section class="form-group" id="quantity2_group">
                    <label for="quantity2" class="col-xs-1" id="quantity2_label" style="padding: 0.5em 0 0 5em;">Quantity:</label>
                    <div class="col-xs-2 input">
                        <input type="text" class="form-control " id="quantity2" name="quantity2" placeholder="Please Enter the Quanity" autocomplete="off" /></div>
                    <div class="error_show"></div>

                </section>
            </section>

<!--            for the quantity that will be promoed-->
            <section class="form-group col-md-12 col-xs-12 col-lg-12 col-sm-12">
                <label class="label col-xs-offset-2 col-xs-1" style="color: #333;padding: 0.5em 0 0 1em;">Get This</label>

                <section class="col-xs-2">
                    <label class="select">
                        <select id="select_get">
                            <?php echo $response1;?>
                        </select> <i></i> </label>
                </section>
                <section class="form-group " id="promo_group">
                    <label for="quantity_get" class="col-xs-1" id="quantity_get_label" style="padding: 0.5em 0 0 5em;">Quantity:</label>
                    <div class="col-xs-2 input">
                        <input type="text" class="form-control " id="quantity_get" name="quantity_get" placeholder="Please Enter the Quanity" value="" autocomplete="off"/></div>
                    <div class="col-xs-5">
                        <div class="inline-group" style="margin: 0 0 0 3em">
                            <label class="checkbox">
                                <input type="checkbox" name="activate_promo" id="activate_promo" checked="checked">
                                <i></i>Activate Promo</label>

                        <button type="submit" class="btn btn-primary btn-lg" name="submit" id="submit" style="padding: 5px 16px 8px;">Add Promo
                        </button>
                        <button type="reset" class="btn btn-danger pull-right btn-lg" style="padding: 5px 16px 8px;">Clear
                        </button>
                        </div>
                    </div>

                </section>

            </section>
            <section class="show_result col-md-12 col-xs-12 col-lg-12 col-sm-12" style="display: none;">
                </section>
        </form>
            </div>
        </div>

</div>
    </div>

<div class="row"  xmlns="http://www.w3.org/1999/html">

    <!-- col -->
    <!--    For the Stock Task-->


    <!-- /.box -->

    <!-- end col end stock task-->

    <!-- right side of the page for the tables -->
    <!-- col -->
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" id="resize-grid">





            <!-- widget content -->


            <!-- this is what the user will see -->
            <table id="jqgrid"></table>
            <div id="pjqgrid"></div>
<!--            <div id="m1">Get selected row</div>-->

        <!-- end widget content -->


        <!-- end widget div -->




        <!-- end of table -->

        <!-- end col -->

    </div>

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
            jQuery("#jqgrid").jqGrid({
                //data : jqgrid_data,
                url: "ajax/setup/promo_grid_get.php",
                datatype: "json",
                mtype: "GET",
                height : 'auto',
                page: 1,
                colNames : [ 'Actions','Buy This Stock', 'In Quantity','And Buy Stock','In Quantity','To Get This','In Quantity', 'Promo Status'],
                colModel : [

                    {
                        name : 'act',
                        index : 'act',
                        sortable : false,
                        formatter:'actions',
                        formatoptions:{keys:true}
                    },
                    {
                        name : 'stock_code',
                        index : 'stock_code',
                        editable : true,
                        editoptions: { readonly: "readonly" }


                    },
                    {
                        name : 'purchase_qty',
                        index : 'purchase_qty',
                        editable : true,




                    },{
                        name : 'stock_code2',
                        index : 'stock_code2',
                        editable : true,
                        editoptions: { readonly: "readonly" }




                    },{
                        name : 'purchase_qty2',
                        index : 'purchase_qty2',
                        editable : true,

                    },{
                        name : 'giveaway_stock',
                        index : 'giveaway_stock',
                        editable : true,
                        edittype:"select",
                        //gets the stockname and stockcode as a value, stockname to display
                        editoptions:{dataUrl:"get_stockname_promo.php",cacheUrlData:true}

                    },
                    {
                        name : 'giveaway_qty',
                        index : 'giveaway_qty',
                        editable : true,

                    },
                    {
                        name : 'promo_status',
                        index : 'promo_status',
                        editable : true,
                        edittype:"checkbox",

                        editoptions:{value:"active:inactive"}

                    }




                ],
                rowNum : 10,
                rowList : [10, 20, 30],
                rowTotal:-1,
                pager : '#pjqgrid',
                sortname : 'promo_id',
                toolbarfilter : true,
                viewrecords : true,
                sortorder : "asc",

                ignoreCase: true,
                loadComplete: function () {


                    $(this).find("div.ui-inline-del>span")
                        .removeClass("ui-icon ui-icon-trash")
                        .addClass("fa fa-trash-o fa-1x").wrap("<button class='btn btn-xs btn-default'></button>");
                    $(this).find("div.ui-inline-edit>span")
//                        .removeClass("ui-icon ui-icon-trash")
//                        .addClass("fa fa-trash-o fa-1x")
                        .wrap("<button class='btn btn-xs btn-default'></button>");
                    $(this).find("div.ui-inline-save>span")
//                        .removeClass("ui-icon ui-icon-trash")
//                        .addClass("fa fa-trash-o fa-1x")
                        .wrap("<button class='btn btn-xs btn-default'></button>");
                    $(this).find("div.ui-inline-cancel>span")
                        .removeClass("ui-icon ui-icon-cancel")
                        .addClass("fa fa-times fa-1x")
                        .wrap("<button class='btn btn-xs btn-default'></button>");


                },
                editurl : "ajax/setup/promo_grid_set.php",
                caption : "Promo",
                autowidth : true


            });

            //I'm submitting the form now


//            Show tool Tip
            $('.navtable .ui-pg-button').tooltip({
                container : 'body'
            });

            $('#jqgrid').jqGrid('navGrid',"#pjqgrid", {
                search: true, // show search button on the toolbar
                add: false,
                edit: false,
                del: true,
                refresh: true
            });

           // jQuery("#jqgrid").jqGrid('inlineNav', "#pjqgrid");
            /* Add tooltips */


            jQuery("#m1").click(function() {
                var s;
                s = jQuery("#jqgrid").jqGrid('getGridParam', 'selrow');
                console.log(s);
                alert(s);
            });


//            How the Left column starts showing initially

//            For the collapsible menu


//This is the function needed for the table and left side display
            $("#submit").prop('disabled', true);
            var quantity1_val;
            var quantity_get_val;
            var quantity2_val;
            var select1_val;
            var select2_val;
            var select_get_val;
            var activate_promo;
            var activate_input;
            activate_promo='active';
            $('#promo_group, #quantity1_group, #quantity2_group').removeClass('has-error');
            $('.help-block').remove();
            $('#activate_promo').change(function () {
                 activate_input =$(this).prop('checked');
                if(activate_input == true){
                    activate_promo='active';

                }
                else{
                    activate_promo='inactive';

                }
            });


            $("#quantity1,#quantity2, #quantity_get").on("keyup", function () {
                quantity1_val = $('#quantity1').val();
                $('#promo_group, #quantity1_group, #quantity2_group').removeClass('has-error');
                $('.show_result').empty().fadeIn('fast');

                if(isNaN($(this).val())){
                    $(this).parent('div').parent('section').addClass('has-error');
                        $('.show_result').empty().fadeIn('fast').append('<div class="help-block">Please Quantity Must be a Number</div>');
                }
                else{
                    $('#promo_group, #quantity1_group, #quantity2_group').removeClass('has-error');
                    $('.show_result').empty().hide('fast');
                    quantity_get_val=$('#quantity_get').val();
                    quantity2_val=$('#quantity2').val();
                    if(Number(quantity1_val) > 0 && Number(quantity_get_val)>0){
                        $("#submit").prop('disabled', false);
                    }
                    else{
                        $("#submit").prop('disabled', true);
                    }
                }


            });
//            select1_val=$('#select1').val();
//            select2_val=$('#select2').val();
//            select_get_val=$('#select_get').val();
//            $('#select1, #select2, #select_get ').change(function () {select1_val=$('#select1').val();
//                select2_val=$('#select2').val();
//                select_get_val=$('#select_get').val();});


//            I'm submitting ooo
            $('#add_promo').submit(function(event) {
                event.preventDefault();
                $('#promo_group, #quantity1_group, #quantity2_group').removeClass('has-error');
                select1_val=$('#select1').val();
                select2_val=$('#select2').val();
                select_get_val=$('#select_get').val();
                var formData = {
                    'quantity1' : quantity1_val,
                    'quantity2': quantity2_val,
                    'quantity_get' : quantity_get_val,
                    'select1' : select1_val,
                    'select2'    : select2_val,
                    'select_get'    : select_get_val,
                    'activate_promo':activate_promo

                };
                $.post('submit_add_promo.php',formData, function (result) {
                    if(result == '1'){

                        $('.show_result').empty().fadeIn('fast').append("<div class='alert alert-success text-center'><button class='close' data-dismiss='alert'>&times;</button><strong>Success! </strong>  Promo has been added </div>").fadeOut(5000);
                        jQuery("#jqgrid").setGridParam({datatype: 'json'}).trigger("reloadGrid");



                        $("#quantity1,#quantity2, #quantity_get").val('');
                        $("#submit").prop('disabled', true);

                        $('#select2').val('blank').trigger('change');
                    }
                    if(result=='error'){

                        $('.show_result').empty().fadeIn('fast').append("<div class='alert alert-error text-center'><button class='close' data-dismiss='alert'>&times;</button><strong>Sorry!</strong>  Stock Promo has already been activated</div>").fadeOut(5000);

                    }
                    if(result=='select'){

                        $('.show_result').empty().fadeIn('fast').append("<div class='alert alert-error text-center'><button class='close' data-dismiss='alert'>&times;</button><strong>Sorry!&nbsp;</strong>  Select two different stocks for Promo</div>").fadeOut(5000);

                    }
                    if(result=='0'){

                        $('.show_result').empty().fadeIn('fast').append("<div class='alert alert-error text-center'><button class='close' data-dismiss='alert'>&times;</button><strong>Sorry!</strong>  Stock Promo Could Not be added</div>").fadeOut(5000);

                    }


                });
            });




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
