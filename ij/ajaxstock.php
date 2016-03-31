    <?php
    require_once 'PHPSuito/jq-config.php';
// include the jqGrid Class

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
$grid->SelectCommand = 'SELECT * FROM stock';
// Set the table to where you add the data
$grid->table = 'stock';
$grid->setPrimaryKeyId('stock_id');
$grid->serialKey = false;
// Set output format to json
$grid->dataType = 'json';
// Let the grid create the model
$grid->setColModel();
// Set the url from where we obtain the data
$grid->setUrl('ajaxstock.php');
//Add Action Col
$grid->addCol(array(
    "name"=>"actions",
    "formatter"=>"actions",
    "editable"=>false,
    "sortable"=>false,
    "resizable"=>false,
    "fixed"=>true,
    "width"=>"60",
    "formatoptions"=>array("keys"=>true)
), "first");
// Set some grid options
$grid->setGridOptions(array(
    "caption"=>"Stock",
    "hoverrows"=>true,
    "rowNum"=>10,
    "rowList"=>array(10,20,30),
    "sortname"=>"stock_id",
    "sortorder"=>"asc",
    "scroll"=>0,
    "editable"=>true,
    "multiselect"=>true
));
// The primary key should be entered
$grid->setColProperty('stock_id', array("editrules"=>array("required"=>true),"label"=>"Stock Id","editable"=>false));
$grid->setColProperty('stock_name', array("label"=>"Stock Name","editrules"=>array("text"=>true,"required"=>true)));
$grid->setColProperty('costprice', array("label"=>"Customer Price","editrules"=>array("number"=>true,"required"=>true)));
$grid->setColProperty('sales_person_price', array("label"=>"Sales Person Price","editrules"=>array("number"=>true,"required"=>true)));
$grid->setColProperty('high_purchase', array("label"=>"High Purchase","editrules"=>array("number"=>true,"required"=>true)));
$grid->setColProperty('low_purchase', array("label"=>"Low Purchase","editrules"=>array("number"=>true,"required"=>true)));


$grid->setColProperty('block', array("label"=>"Block Stock","edittype"=> "checkbox","formatter"=>"checkbox",
    "editoptions"=>array("value"=>"1:0")
));
$grid->setColProperty('reorder_level', array("label"=>"Reorder Level","editrules"=>array("number"=>true,"required"=>true)));
$grid->setColProperty('supplier_name', array("label"=>"Supplier Name","edittype"=> "select",
    "editoptions"=>array(
        "dataUrl"=>"get_suppliername.php",
        "cacheUrlData"=>true
    )));
$grid->setColProperty('category_name', array("label"=>"Category Name","edittype"=> "select",
    "editoptions"=>array(
        "dataUrl"=>"get_category.php",
        "cacheUrlData"=>true
    )));
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


