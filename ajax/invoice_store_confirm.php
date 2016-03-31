<!-- widget grid -->
<?php
require_once("inc/init.php");
require_once("userlogcheck_admin_and_invoice_confirmer.php");
$_SESSION['last_screen'] = "invoice_store_confirm.php";
 ?>

<section id="widget-grid" class="">
    <!-- row -->
    <div class="row" id="newinvoice-slide">
    	<!-- NEW WIDGET START -->
    	<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<!-- Widget ID (each widget will need unique ID)-->
            <div class="jarviswidget" id="wid-id-0" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-editbutton="false">
                <header>
                    <span class="widget-icon"> <i class=""></i> </span>
                    <h2>Invoice/Store Supply Confirmation </h2>
                </header>
                <!-- widget div-->
                <div>
                    <!-- widget edit box -->
                    <div class="jarviswidget-editbox">
                        <!-- This area used as dropdown edit box -->
                        <input class="form-control" type="text">
                    </div>
                    <!-- end widget edit box -->
                    <!-- widget content -->
                    <div class="widget-body">
                        <div class=" row" id="form_container">
                        <form action="" method="POST" autocomplete="off" name="search_invoice" id="search_invoice">
                            <div class="row" style="padding: 10px 0 20px;" id="success_group">
                                <div class="col-md-3">
                                    <input id="invoice_num_hidden" type="hidden" >
                                </div>
                                <div class="col-xs-9 col-sm-5 col-md-4 col-lg-4" id="error-group">
                                	<div class="input-group">
                                		<input id="amount" name="amount" class="form-control" type="text"  value="">
                                        <div class="input-group-btn">
                                        	<button type="submit" class="btn btn-primary" name="search" id="search">Search</button>
                                        </div><!-- /btn-group -->
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <button class="btn btn-default" id="cancel" name="cancel" type="reset" >
                            			<i class="fa fa-refresh"></i> <span class="hidden-mobile">Clear</span>
                            		</button>
                            	</div>
                                <div class="col-md-3"></div>
                            </div>
    					</form>
    					</div>
                        <div class="row">
<!--                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">-->

                            <section class="col-xs-12 col-sm-12 col-md-8 col-lg-8" id="show_result">

                            </section>
                            <section class="col-xs-12 col-sm-12 col-md-4  col-lg-4">
                                <div class="well" style=" height: 300px;display: none;" id="result_main">
                                <div id="result_container" style="font-size: 18px;">
                                    <div id="show_customer_result">

                                    </div>
                                    </br></br>
                                    <div id="show_invoice_result">

                                    </div>
                                </div>
                                <div id="display_supply" style="display: none">
                                   <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"
                                        style="margin-top: 30px; font-size: 17px;">

                                    <?php //echo $response;?>
                                       </br></br>
                                        <button class="btn btn-primary pull-right" id="mark_supplied">Mark as supplied</button>
                                       <button class="btn btn-default" type="button" id="cancel_cashier">Cancel
                                       </button>
                                       </br>
                                   </div>
                                </div>
<!--                            </div>-->
                                </div>
                            </section>
                    </div>
                        <!-- end widget content -->
                </div>
    			<!-- end widget div -->
            </div>
            <!-- end widget -->
        </article>
    	<!-- WIDGET END -->
    </div>
</section>


<script>
    $('document').ready(function () {

        $('#cancel_cashier').click(function () {
            $('#form_container').slideDown(300);
            $('#display_supply').hide('slow');
            $('#result_container').hide('slow');
            $('#show_result').empty();
            $('#amount').val('');
            $('#search').prop('disabled', true);
            $('#result_main').hide('slow');
        });

        $('#search').prop('disabled', true);

        $('#amount').on('keyup', function () {
                $('#search').prop('disabled', false);
        });

        $('#cancel').on('click', function () {
            $('#error-group').removeClass('has-error'); // remove the error class
            $('.help-block').remove();
            $('#search').prop('disabled', true);
        });

        $('#search_invoice').submit(function(event){
            $('#error-group').removeClass('has-error'); // remove the error class
            $('.help-block').remove();
            $('.alert').remove();
            $('.alert-warning').remove();
            $('#show_customer_result').empty();
            $('#show_invoice_result').empty();

            event.preventDefault();
            $('#show_result').removeClass(' bg-success');
            $('#invoice_num_hidden').val(''+$('#amount').val()+'');
            var formData={
                'invoice_num':$('#amount').val()
            };
            $.ajax(
            {
                type:'POST',
                url:'ajax/invoice/invoice_confirm_search.php',
                data:formData,
                dataType:'json',
                encode:true
            }
            ).done(function(data){
                if (!data.success) {
                    if (data.invoice) {
                        $('#error-group').addClass('has-error').append('<div class="alert alert-danger help-block">' + data.invoice + '</div>');
                    }
                    if(data.empty) {
                        $('#error-group').addClass('has-error').append('<div class="alert alert-warning help-block">' + data.empty + '</div>');
                    }
                    if(data.message == 'marked as supplied') {
                        <?php if ($_SESSION['username'] != "admin" && $_SESSION['username'] != "superadmin") {?>
                        $('#error-group').addClass('has-error').append('<div class="help-block">Invoice already marked as supplied</div>');
                        <?php } else { ?>
                        $('#error-group').addClass('has-error').append('<div class="help-block">Invoice already marked as supplied&nbsp;<button class="btn btn-danger" id="mark_not_supplied">Mark as NOT SUPPLIED</button> </div>');
                        <?php } ?>
                        $('#mark_not_supplied').click(function (event) {
                            $('#error-group').removeClass('has-error');
                            $('.help-block').remove();
                            event.preventDefault();
                            //alert($('#invoice_num_hidden').val());
                            var formData={
                                'invoice_num_hidden':$('#invoice_num_hidden').val()
                            };
                            $.ajax(
                            {
                                type:'POST',
                                url:'ajax/invoice/invoice_confirm_search.php',
                                data:formData,
                                dataType:'json',
                                encode:true
                            }
                            )
                            .done(function(data){
                                if (!data.success) {
                                    $('#display_supply').addClass('has-error').append('<div class="help-block">' + data.message + '</div>');
                                  $('#display_supply').hide('fast');
                                }
                                else{
                                    $('#error-group').append('<div class="col-xs-12 col-sm-12  help-block bg-success" style="font-size: 20px;">' + data.message + '</div>').fadeIn(5000);
                                    $('#display_supply').hide('fast');
                                    $('#amount').val('');
                                    $('#search').prop('disabled', true);
                                }
                            })
                        });
                    }
                }
                else{
                    $('#show_result').empty().append('<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" >' + data.message + '</div>');
                    $('#show_customer_result').append(data.cust);
                    $('#show_invoice_result').append(data.invnum);
                    $('#display_supply').slideDown('fast');
                    $('#form_container').slideUp(300);
                    $('#result_container').show('fast');
                    $('#result_main').show('fast');
                }
            })
        });

        $('#mark_supplied').click(function (event) {
            $('#error-group').removeClass('has-error'); // remove the error class
            $('.help-block').remove(); // remove the error text
            event.preventDefault();
            var formData={
//                  'cashier_selected':$('#cashier_selected').val(),
                'invoice_num_obtained':$('#invoice_num_obtained').text()
            };
            $.ajax(
            {
                type:'POST',
                url:'ajax/invoice/invoice_confirm_search.php',
                data:formData,
                dataType:'json',
                encode:true
            }
            )
            .done(function(data){
                if (!data.success) {
                    $('#display_supply').addClass('has-error').append('<div class="help-block">'+data.message+'</div>');
                }
                else{
                    $('#form_container').slideDown(300);
                    $('#error-group').append('<div class="col-xs-12 col-sm-12  help-block bg-success" style="font-size: 20px;">' + data.message + '</div>').fadeIn(5000);
                    $('#display_supply').hide('fast');
                    $('#result_container').hide('fast');
                    $('#show_result').empty();
                    $('#amount').val('');
                    $('#result_main').hide('fast');
                    $('#search').prop('disabled', true);
                }
            })
        });
    });
</script>