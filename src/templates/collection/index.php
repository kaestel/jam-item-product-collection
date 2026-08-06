<?php
global $action;
global $itemtype;


$page_item = items()->getItem([
	"itemtype" => "page",
	"tags" => "page:Products", 
	"status" => 1, 
	"extend" => [
		"user" => true, 
		"mediae" => true, 
	]
]);


if($page_item) {
	$this->sharingMetaData($page_item);
}

$items = items()->getItems([
	"itemtype" => $itemtype, 
	"status" => 1, 
	"order" => "$itemtype.position ASC", 
	"extend" => [
		"tags" => true, 
		"mediae" => true, 
		"prices" => true,
	]
]);

?>

<div class="scene products i:productitems">

<? if($page_item): 
	$media = items()->sliceMediae($page_item, "single_media"); ?>
	<div class="article i:article id:<?= $page_item["item_id"] ?> product" itemscope itemtype="http://schema.org/Article">

		<?= HTML()->renderSnippet("snippets/media.php", [
			"item" => $page_item,
			"media" => $media,
		]) ?>


		<h1 itemprop="headline"><?= $page_item["name"] ?></h1>


		<?= HTML()->renderSnippet("snippets/info.php", [
			"item" => $page_item,
			"url" => HTML()->path,
			"media" => $media,
			"sharing" => true
		]) ?>


		<? if($page_item["html"]): ?>
		<div class="articlebody" itemprop="articleBody">
			<?= $page_item["html"] ?>
		</div>
		<? endif; ?>

	</div>

<? else:?>

	<div class="article">
		<h1>Products</h1>
	</div>

<? endif; ?>


	<div class="all_products">

<?		if($items): ?>
		<ul class="items products i:productlist">
<?			foreach($items as $item):
				$media = items()->sliceMediae($item, "single_media"); ?>
			<li class="item article product id:<?= $item["item_id"] ?><?= $item["classname"] ? " ".$item["classname"] : "" ?>" itemscope itemtype="http://schema.org/Product">

				<?= HTML()->renderSnippet("snippets/media.php", [
					"item" => $item,
					"media" => $media,
				]) ?>


				<?= HTML()->renderSnippet("snippets/tags.php", [
					"item" => $item,
					"context" => [$itemtype]
				]) ?>


				<h3 itemprop="name"><a href="<?= HTML()->path ?>/<?= $item["sindex"] ?>"><?= $item["name"] ?></a></h3>


				<?= HTML()->renderSnippet("snippets/productinfo.php", [
					"item" => $item,
					"media" => $media,
				]) ?>


				<?= HTML()->renderSnippet("snippets/offer.php", [
					"item" => $item,
				]) ?>


				<? if($item["description"]): ?>
				<div class="description" itemprop="description">
					<p><?= nl2br($item["description"]) ?></p>
				</div>
				<? endif; ?>

			</li>
<?			endforeach; ?>
		</ul>

<?		else: ?>

		<p>No products</p>

<?		endif; ?>

	</div>

</div>
