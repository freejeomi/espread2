<?php
require_once 'PHPSuito/jq-config.php';
// include the jqGrid Class
include "PHPSuito/jqGridUtils.php";
require_once "PHPSuito/jqGrid.php";
// include the driver class
require_once "PHPSuito/DBdrivers/jqGridPdo.php";
// Connection to the server
//$conn = new PDO('mysql:host=localhost;dbname=espread', 'root', 'Heaven192');
$conn = new PDO(DB_DSN,DB_USER,DB_PASSWORD);
// Tell the db that we use utf-8
$conn->query("SET NAMES utf8");
//$sql = 'SELECT role_name FROM users';
// Create the jqGrid instance
$grid = new jqGridRender($conn);
// Write the SQL Query
$grid->SelectCommand = 'SELECT supplier.supplier_id,supplier.supplier_name,supplier.supplier_email,supplier.supplier_phone,supplier.supplier_address,supplier.supplier_city,supplier.supplier_state,supplier.supplier_country,supplier.dateregistered,supplier.username FROM supplier LEFT JOIN users ON supplier.username = users.username';
// Set the table to where you add the data
$grid->table ='supplier';
$grid->setPrimaryKeyId('supplier_id');
$grid->serialKey = false;
// Set output format to json
$grid->dataType = 'json';
// Let the grid create the model





// Set the url from where we obtain the data


// Lets create the model manually
//$Model = array(
//    array("name"=>"supplier_id","editable"=>false,
//
//    ),
//    array("name"=>"supplier_name","editable"=>true,
//        "editrules"=>array("text"=>true,"required"=>true)
//    ),
//    array("name"=>"supplier_email","editable"=>true,
//        "formatter"=>"email",
//        "editrules"=>array("email"=>true,"required"=>true)
//    ),
//    array("name"=>"supplier_phone", "editable"=>true,"sorttype"=>"number",
//        "editrules"=>array("required"=>true, "integer"=>true, "minValue"=>11) ),
//    array("name"=>"supplier_address","editable"=>true,
//        "editrules"=>array("text"=>true,"required"=>true)
//    ),
//
//    array("name"=>"supplier_city","editable"=>true,
//        "editrules"=>array("text"=>true,"required"=>true)
//    ),
//    array("name"=>"supplier_state","editable"=>true,
//        "editrules"=>array("text"=>true,"required"=>true)
//    ),
//    array("name"=>"supplier_country","editable"=>true,
//        "editrules"=>array("text"=>true,"required"=>true)
//    ),
//    array("name"=>"dateregistered","editable"=>true,
//        "editrules"=>array("date"=>true,"required"=>true,)
//    ),
//    array("name"=>"username  ","editable"=>true
//
//    ),
//
//
//
//);
// Let the grid create the model
$grid->setColModel();
//$grid->setJSCode( $custom_check);
// Set grid option datatype to be local and editurl to point to dummy file

$grid->setUrl('ajaxsupplier.php');

//Add Action Col
$grid->addCol(array(
    "name"=>"actions",
    "formatter"=>"actions",
    "editable"=>false,
    "sortable"=>false,
    "resizable"=>false,
    "fixed"=>true,
    "width"=>60,
    "formatoptions"=>array("keys"=>true)
), "first");
// Set some grid options
$grid->setGridOptions(array(
    "caption"=>"Supplier Account",
    "hoverrows"=>true,
    "rowNum"=>10,
    "rowList"=>array(10,20,30),
    "sortname"=>"supplier_id",
    "sortorder"=>"asc",
    "scroll"=>0,
    "editable"=>true,
    "multiselect"=>true
));
// The primary key should be entered
$grid->setColProperty('supplier_id', array("editrules"=>array("required"=>true),"label"=>"ID","editable"=>false));



$grid->setColProperty('supplier_name', array("label"=>"Suplier Name","editrules"=>array("text"=>true,"required"=>true)));
$grid->setColProperty('supplier_email', array("label"=>"Supplier Email","formatter"=>"email",
    "editrules"=>array("email"=>true,"required"=>true)));
$grid->setColProperty('supplier_phone', array("label"=>"Supplier Phone","sorttype"=>"number",
    "editrules"=>array("required"=>true, "integer"=>true, "minValue"=>9)
));
$grid->setColProperty('supplier_address', array("label"=>"Supplier Address","editrules"=>array("required"=>true)));
$grid->setColProperty('supplier_city', array("label"=>"Supplier City","editrules"=>array("text"=>true,"required"=>true)));
$grid->setColProperty('supplier_state', array("label"=>"Supplier State","editrules"=>array("text"=>true,"required"=>true)));
$grid->setColProperty('supplier_country', array("label"=>"Supplier Country","editrules"=>array("text"=>true,"required"=>true)));


//For Date Registered
$grid->setColProperty('username', array("label"=>"User Name","edittype"=> "select",
    "editoptions"=>array(
        "dataUrl"=>"get_username.php",
        "cacheUrlData"=>true
    )));
$grid->setColProperty('dateregistered   ',
    array("formatter"=>"date","readonly"=>true,"label"=>"Date Registered",
        "formatoptions"=>array("reformatAfterEdit"=>true, "srcformat"=>"Y-m-d H:i:s", "newformat"=>"Y-m-d")
    )
);
// We need to configure the server dates. Call it before datepicker
$grid->setUserDate("Y-m-d");
$grid->setDbDate("Y-m-d H:i:s");
$grid->setUserTime("Y-m-d");

// Use the direct method to set a date picker
$grid->setDatepicker('dateregistered');
$today = date("Y/m/d");
// This command is executed immediatley after edit occur.
//$grid->setAfterCrudAction('add', "UPDATE suppliers SET dateregistered =? ",$today);

// For demonstration purposes only we will update the Customer name adding at end of
// the field U after the data is updated from the user

// We can set ulimited commands after edit occur.
// The same apply for del and add operation
//$cid = jqGridUtils::GetParam('users.username');
//// This command is executed immediatley after edit occur.
//$grid->setAfterCrudAction('edit', "UPDATE supplier INNER JOIN users ON supplier.user_id = users.user_id SET supplier.user_id =users.user_id WHERE users.username=?",array($cid));
//
//$grid->setAfterCrudAction('add', "UPDATE supplier INNER JOIN users ON supplier.user_id = users.user_id SET supplier.user_id =users.user_id  WHERE users.username=?",array($cid));


//$grid->setSelect('role_name', "SELECT role_name FROM users");
// Enable navigator
$grid->navigator = true;
$grid->setNavOptions('navigator', array("add"=>false,"edit"=>false,"excel"=>false));
// and just enable the inline
$inlineAdd = <<<INLINEADD
function()
{
//alert("oneditfunc");
}
INLINEADD;
$grid->inlineNav = true;
$grid->inlineNavOptions('add', array("addRowParams"=>array('oneditfunc'=> "js:".$inlineAdd,'keys'=>true)));

$custom = <<<CUSTOM
jQuery(window).on('resize.jqGrid', function() {
				$("#grid").jqGrid('setGridWidth', $("#content").width());
			});
jQuery("#getselected").click(function(){
    var selr = jQuery('#grid').jqGrid('getGridParam','selarrrow');
    if(selr) alert(selr);
});
CUSTOM;

$grid->setJSCode($custom);



// Enjoy
$grid->renderGrid('#grid','#pager',true, null, null, true,true);


