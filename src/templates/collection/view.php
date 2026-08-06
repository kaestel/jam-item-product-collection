<?php
global $action;
global $itemtype;


$sindex = $action[0];


$pagination_pattern = [
	"pattern" => [
		"itemtype" => $itemtype, 
		"status" => 1, 
		"extend" => [
			"tags" => true, 
			"prices" => true, 
			"mediae" => true,
		]
	],
	"sindex" => $sindex,
	"limit" => 1
];


$pagination_items = items()->paginate($pagination_pattern);


if($pagination_items && $pagination_items["range_items"]) {

	$item = $pagination_items["range_items"][0];

	$this->pageTitle($item["name"]);
	$this->bodyClass($item["classname"] ? $item["classname"] : "services");
	$this->sharingMetaData($item);

	// set related pattern
	$related_pattern = [
		"itemtype" => $item["itemtype"], 
		"tags" => $item["tags"], 
		"exclude" => $item["id"]
	];

	$related_title = "Related services";

}
else {
	// itemtype pattern for missing item
	$related_pattern = ["itemtype" => $itemtype];
	$related_title = "Other products";

}

// add base pattern properties
$related_pattern["limit"] = 5;
$related_pattern["extend"] = [
	"tags" => true, 
	"prices" => true, 
	"mediae" => true
];

// get related items
$related_items = items()->getRelatedItems($related_pattern);

?>

<div class="scene product i:productitem">

<? if($item):
	$media = items()->sliceMediae($item, "single_media"); ?>

	<div class="article id:<?= $item["item_id"] ?> product" itemscope itemtype="http://schema.org/Product">

		<?= HTML()->renderSnippet("snippets/tags.php", [
			"item" => $item,
			"context" => [$itemtype],
			"default" => [HTML()->path, translate("All products")]
		]) ?>


		<?= HTML()->renderSnippet("snippets/media.php", [
			"item" => $item,
			"media" => $media,
		]) ?>


		<h1 itemprop="name"><?= $item["name"] ?></h1>


		<?= HTML()->renderSnippet("snippets/productinfo.php", [
			"item" => $item,
			"media" => $media,
		]) ?>


		<?= HTML()->renderSnippet("snippets/offer.php", [
			"item" => $item,
		]) ?>


		<?= shop()->formStart("/shop/addToCart", array("class" => "add_to_cart labelstyle:inject")) ?>
			<?= shop()->input("quantity", array("value" => 1, "type" => "hidden")); ?>
			<?= shop()->input("item_id", array("value" => $item["item_id"], "type" => "hidden")); ?>

			<ul class="actions">
				<?= shop()->submit("Add to cart", array("class" => "primary", "wrapper" => "li.add")) ?>
			</ul>
		<?= shop()->formEnd() ?>


		<div class="articlebody" itemprop="articleBody">
			<?= $item["html"] ?>
		</div>

	</div>


	<?= HTML()->renderSnippet("snippets/pagination.php", [
		"items" => $pagination_items,
		"type" => "sindex",
		"show_total" => false,
		"labels" => ["prev" => "{name}", "next" => "{name}"]
	]) ?>


<? else: ?>

	<h1>Technology has limits</h1>
	<p>We could not find the specified service.</p>

<? endif; ?>


<?= HTML()->renderSnippet("snippets/related.php", [
	"items" => $related_items,
]) ?>


</div>
