<?php

//CONFIGURATION for SmartAdmin UI

//ribbon breadcrumbs config
//array("Display Name" => "URL");
$breadcrumbs = array(
	"Home" => APP_URL
);

/*navigation array config

ex:
"dashboard" => array(
	"title" => "Display Title",
	"url" => "http://yoururl.com",
	"url_target" => "_blank",
	"icon" => "fa-home",
	"label_htm" => "<span>Add your custom label/badge html here</span>",
	"sub" => array() //contains array of sub items with the same format as the parent
)

*/
//$page_nav = array(
$account = array(
	"title" => "Account",
	"icon" => "fa-user",
	"sub" => array(
		"Change Password" => array(
			"title" => "Change Password",
			"url" => "ajax/change-password.php"
		),
		"Logout" => array(
			"title" => "Logout",
			"url" => "ajax/logout.php"
		)
	)
);

    
	$dashboard = array(
		"title" => "Dashboard",
		"url" => "ajax/dashboard.php",
		"icon" => "fa-home"
	);
    
    $invoice = array(
		"title" => "Sales",
		"icon" => "fa-shopping-cart",
		"sub" => array(
			"New Invoice" => array(
				"title" => "New Invoice",
				"url" => "ajax/new_invoice.php"
			),
//			"New Invoice2" => array(
//				"title" => "New Invoice2",
//				"url" => "ajax/new_invoice2.php"
//			),
			"Sales Ledger" => array(
				"title" => "Sales Ledger",
				"url" => "ajax/daily_sales_ledger.php"
			),
			"Sales Summary" => array(
				"title" => "Sales Summary",
				"url" => "ajax/sales_summary.php"
			),
			"Cashier Summary." => array(
				"title" => "Cashier Summary",
				"url" => "ajax/cashier_sales_summary.php"
			),
			"Promo Summary" => array(
				"title" => "Promo Summary",
				"url" => "ajax/foc_summary.php"
			),
			"Invoice Tracking" => array(
				"title" => "Invoice Tracking",
				'url' => "ajax/invoice_tracker.php"
			),
            "Invoice Confirmation" => array(
				"title" => "Invoice Confirmation",
				'url' => "ajax/invoice_store_confirm.php"
			)
		)
	);
      $supplier_account = array(
		"title" => "Supplier Account",
		"icon" => "fa-building",
		"sub" => array(
			"Update Supplier Account" => array(
				"title" => "Update Supplier Account",
				"url" => "ajax/update_supplier_acct.php"
			),
            "Supplier Account Balance" => array(
				"title" => "Supplier Account Balance",
				"url" => "ajax/supplier_acct_bal.php"
			),
			"Promo Compensation" => array(
				"title" => "Promo Compensation",
				"url" => "ajax/supplier_account/foc_compensation.php"
			)
    
    	)
	);
      
     $customer_account = array(
		"title" => "Customer Account",
		"icon" => "fa-users",
		"sub" => array(
			"Customer Account Balance" => array(
				"title" => "Customer Account Balance",
				"url" => "ajax/customer_acct_bal.php"
			),
			"Debtors" => array(
				"title" => "Debtors",
				"url" => "ajax/debtors.php"
			),
			"Customer Sales Volume" => array(
				"title" => "Customer Sales Volume",
				"url" => "ajax/customer_sales_volume.php"
			),
			"CSV Per Stock" => array(
				"title" => "CSV Per Stock ",
				"url" => "ajax/csv_per_stock.php"
			)
    	)
	);
     $cash_stock = array(
		"title" => "Cash Stock",
		"icon" => "fa-money",
		"sub" => array(
			"Daily Opening Balance" => array(
				"title" => "Daily Opening Balance",
				"url" => "ajax/opening_balance.php"
			),
			"Payment To Supplier" => array(
				"title" => "Payment To Supplier",
				"url" => "ajax/payment_to_supplier.php"
			),
			"Other Expenses" => array(
				"title" => "Other Expenses",
				"url" => "ajax/other_expenses.php"
			),
			"Cash Stock Account" => array(
				"title" => "Cash Stock Account",
				"url" => "ajax/cash_stock.php"
			)
    	)
	);
     
    $stock_inventory = array(
		"title" => "Stock Inventory",
		"icon" => "fa-list-ul",
		"sub" => array(
			"Stock Ledger" => array(
				"title" => "Stock Ledger",
				"url" => "ajax/stock_ledger.php"
			),
			"Update Stock" => array(
				"title" => "Update Stock",
				"url" => "ajax/update_stock.php"
			),
			"Stock Summary" => array(
				"title" => "Stock Summary",
				"url" => "ajax/stock_summary.php"
			),
			"Stock Valuation" => array(
				"title" => "Stock Valuation",
				"url" => "ajax/stock_valuation.php"
			)
        )
	);
    $allocation = array(
		"title" => "Allocation",
		"icon" => "fa-thumb-tack",
		"sub" => array(
			"Sales Contribution" => array(
				"title" => "Sales Contribution",
				"url" => "ajax/sales_contribution.php"
			),
			"Total Turnover" => array(
				"title" => "Total Turnover",
				"url" => "ajax/total_turnover.php"
			)
         )
	);
     $haulage = array(
		"title" => "Haulage",
		"icon" => "fa-truck",
		"sub" => array(
			"Haulage" => array(
				"title" => "Haulage",
				"url" => "ajax/haulage.php"
			),
			"Haulage Ledger" => array(
				"title" => "Haulage Ledger",
				"url" => "ajax/haulage_ledger.php"
			)
         )
	);
	$reorder = array(
		"title" => "Reorder Management",
		"icon" => "fa-reorder",
		"sub" => array(
			"Edit_Reorder" => array(
				"title" => "Edit Reorder Level",
				"url" => "ajax/ajax_edit_reorder.php"
				//"url_target" => "_blank"
			),
			"Manage_Reorder" => array(
				"title" => "Manage Reorder Level",
				"url" => "ajax/ajax_manage_reorder.php"

			),
			"Reorder_Gaps" => array(
				"title" => "Re-order GAPs",
				"url" => "reorder_gaps.php",
				"url_target" => "_blank"
			),
			"Stock Transfer Guide" => array(
				"title" => "Stock Transfer Guide",
				"url" => "ajax/ajax_reorder_refuel.php"

			)
		)
	);


     $setup = array(
		"title" => "Setup",
		"icon" => "fa-cogs",
		"sub" => array(
			"Settings" => array(
				"title" => "Settings",
				"url" => "ajax/settings.php"
			),
			"Supplier" => array(
				"title" => "Supplier",
				"url" => "ajax/supplier.php"
			),
			"Store" => array(
				"title" => "Store",
				"url" => "ajax/store.php"
			),
			"Stock" => array(
				"title" => "Stock",
				"url" => "ajax/stock.php"
			),
			"Customer" => array(
				"title" => "Customer",
				"url" => "ajax/customer.php"
			),
			"Vehicle" => array(
				"title" => "Vehicle",
				"url" => "ajax/vehicle.php"
			),
			"Cashier" => array(
				"title" => "Cashier",
				"url" => "ajax/cashier.php"
			),
			"Category" => array(
				"title" => "Category",
				"url" => "ajax/category.php"
			),
			"Promo" => array(
				"title" => "Promo",
				"url" => "ajax/promo.php"
			)
        )
	);
     
     $security = array(
		"title" => "Security",
		"icon" => "fa-lock",
		"sub" => array(
			"Manage System User" => array(
				"title" => "Manage System Users",
				"url" => "ajax/users.php"
			),
			"Edit User Profile Privileges" => array(
				"title" => "Edit User Profile Privileges",
				"url" => "ajax/profile_grid.php"
			)
         )
	);
$archive = array(
	"title" => "Archive",
	"icon" => "fa-archive",
	"sub" => array(
		"Sales Repository Manager" => array(
			"title" => "Sales Repository Manager ",
			"url" => "ajax/transfer_sales_ledger.php"
		),
		"Sales Ledger Archive" => array(
			"title" => "Sales Ledger Archive",
			"url" => "ajax/sales_ledger.php"
		)
	)
);

$upload_file = array(
	"title" => "Upload Daily Summary",
	"icon" => " fa-cloud-upload",
    "sub" => array(
    "Upload Daily Summary" => array(
        "title" => "Upload Daily Summary ",
        "url" => "ajax/upload_daily_summary2.php"
    ),
    "Request Manager" => array(
        "title" => "Request Manager",
        "url" => "ajax/request_manager.php"
    )
)
);
//);

$page_nav = array();

if(isset($_SESSION['role_name'])) {
	if($_SESSION['role_name'] == 'admin' || $_SESSION['role_name'] == 'manager' || $_SESSION['role_name'] == 'superadmin' ) {
		$page_nav["dashboard"] = $dashboard;
	}
}


if(isset($_SESSION['menu_invoice'])){
	if($_SESSION['menu_invoice'] == '1'){
		$page_nav["Invoice"] = $invoice;
	}
}

if(isset($_SESSION['menu_supplier'])){
	if($_SESSION['menu_supplier'] == '1'){
		$page_nav["Supplier Account"] = $supplier_account;
	}
}

if(isset($_SESSION['menu_customer'])){
	if($_SESSION['menu_customer'] == '1'){
		$page_nav["Customer Account"] = $customer_account;
	}
}

if(isset($_SESSION['menu_cashstock'])){
	if($_SESSION['menu_cashstock'] == '1'){
		$page_nav["Cash  Stock"] = $cash_stock;
	}
}

if(isset($_SESSION['menu_stock'])){
	if($_SESSION['menu_stock'] == '1'){
		$page_nav["Stock Inventory"] = $stock_inventory;
	}
}

if (isset($_SESSION['role_name'])) {
	if ($_SESSION['role_name'] == 'admin' || $_SESSION['role_name'] == 'superadmin') {
		$page_nav["Allocation"] = $allocation;
	}
}

if(isset($_SESSION['menu_haulage'])){
	if($_SESSION['menu_haulage'] == '1'){
		$page_nav["Haulage"] = $haulage;
	}
}
if (isset($_SESSION['role_name'])) {
	if ($_SESSION['role_name'] == 'admin' || $_SESSION['role_name'] == 'manager' || $_SESSION['role_name'] == 'superadmin') {
		$page_nav["reorder_management"] = $reorder;
	}
}
if (isset($_SESSION['role_name'])) {
	if ($_SESSION['role_name'] == 'admin' || $_SESSION['role_name'] == 'manager' || $_SESSION['role_name'] == 'superadmin') {
		$page_nav["archive"] = $archive;
	}
}
if (isset($_SESSION['role_name'])) {
	if ($_SESSION['role_name'] == 'admin' || $_SESSION['role_name'] == 'manager' || $_SESSION['role_name'] == 'superadmin') {
		$page_nav['upload_file'] = $upload_file;
	}
}

if(isset($_SESSION['menu_setup'])){
	if($_SESSION['menu_setup'] == '1'){
		$page_nav["Setup"] = $setup;
	}
}

if(isset($_SESSION['role_name'])){
	if(strtolower($_SESSION['role_name']) == "admin" || strtolower($_SESSION['role_name']) == "superadmin"){
		$page_nav["Security"] = $security;

	}
}

$page_nav["logout"] = $account;
//configuration variables
$page_title = "";
$page_css = array();
$no_main_header = false; //set true for lock.php and login.php
$page_body_prop = array(); //optional properties for <body>
$page_html_prop = array(); //optional properties for <html>
?>