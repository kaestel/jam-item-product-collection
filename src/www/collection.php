<?php
$controller_type = "item";
$controller_itemtype = "productcollection";
$controller_favors = ["view" => "product collection", "list" => "List products"];

$access_item = false;
if(isset($read_access) && $read_access) {
	return;
}


include_once($_SERVER["FRAMEWORK_PATH"]."/config/init.php");


$itemtype = $controller_itemtype;
$action = $page->actions();


// /services/#sindex#
if(count($action) == 1) {

	$page->page([
		"templates" => "productcollection/view.php"
	]);
	exit();

}

$page->page([
	"templates" => "productcollection/index.php"
]);
exit();
