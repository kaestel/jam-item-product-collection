<?php
$controller_type = "item";
$controller_itemtype = "product-variants";
$controller_favors = ["view" => "product", "list" => "List products"];

$access_item = false;
if(isset($read_access) && $read_access) {
	return;
}


include_once($_SERVER["FRAMEWORK_PATH"]."/config/init.php");


$itemtype = $controller_itemtype;
$action = $page->actions();


// /services/#sindex#
if(count($action) == 1) {

	$page->page(array(
		"templates" => "products/view.php"
	));
	exit();

}

$page->page(array(
	"templates" => "products/index.php"
));
exit();
