<?php
require_once 'PHPSuito/jq-config.php';
// include the jqGrid Class

require_once "PHPSuito/jqGrid.php";

include "PHPSuito/jqAutocomplete.php";
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
$grid->SelectCommand = 'SELECT * FROM vehicle';
// Set the table to where you add the data
$grid->table = 'vehicle';
$grid->setPrimaryKeyId('vehicle_number');
$grid->serialKey = false;
// Set output format to json
$grid->dataType = 'json';
// Let the grid create the model
$grid->setColModel();
// Set the url from where we obtain the data
$grid->setUrl('ajaxvehicle.php');
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
    "caption"=>"Stock Category",
    "hoverrows"=>true,
    "rowNum"=>10,
    "rowList"=>array(10,20,30),
    "sortname"=>"vehicle_number",
    "sortorder"=>"asc",
    "scroll"=>0,
    "editable"=>true,
    "multiselect"=>true

));
// The primary key should be entered
$grid->setColProperty('vehicle_number', array("editrules"=>array("required"=>true),"label"=>"Vehicle Number","editable"=>true));
$grid->setColProperty('vehicle_name', array("label"=>"Vehicle Name"));
$grid->setColProperty('balance', array("label"=>"Balance"));


//$grid->setSelect('role_name', "SELECT role_name FROM users");
// Enable navigator
// navigator first should be enabled
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

// Enable only deleting
//$grid->setNavOptions('navigator', array("excel"=>false,"add"=>true,"edit"=>true,"del"=>true,"view"=>false,"save"=>true));
//$grid->setNavOptions('edit', array("height"=>'auto',"dataheight"=>"auto","width"=>'auto',"recreateForm"=>true));
//$grid->setNavOptions('add', array("height"=>'auto',"dataheight"=>"auto","width"=>'auto',"recreateForm"=>true));
//$grid->setNavOptions('search', array("multipleSearch"=>true));
//$grid->setNavOptions('save', array("height"=>'auto',"dataheight"=>"auto","width"=>'auto',"recreateForm"=>true));

//Make Grid referesh from server



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


