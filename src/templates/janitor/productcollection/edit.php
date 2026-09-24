<?php
global $action;
global $model;
global $itemtype;

$item_id = $action[1];
$item = items()->getItem(array("id" => $item_id, "extend" => array("tags" => true, "mediae" => true)));

// debug([$item]);

$all_items = items()->getItems(["itemtype" => "product", "status" => true, "order" => "position ASC", "extend" => ["tags" => true]]);

?>
<div class="scene i:scene defaultEdit <?= $itemtype ?>Edit">
	<h1>Edit product collection</h1>
	<h2><?= strip_tags($item["name"]) ?></h2>

	<?= $JML->editGlobalActions($item) ?>

	<?= $JML->previewUrl($item) ?>

	<?= $JML->editSingleMedia($item, ["label" => "Main product image"]) ?>


	<div class="item i:defaultEdit">
		<h2>Product details</h2>
		<?= $model->formStart("update/".$item["id"], array("class" => "labelstyle:inject")) ?>

			<fieldset>
				<?= $model->input("name", array("value" => $item["name"])) ?>
				<?= $model->input("brand", array("value" => $item["brand"])) ?>
				<?= $model->input("description", array("class" => "autoexpand short", "value" => $item["description"])) ?>
				<?= $model->input("html", array("value" => $item["html"])) ?>
			</fieldset>

			<?= $JML->editActions($item) ?>

		<?= $model->formEnd() ?>
	</div>

	<div class="i:defaultEditItems all_items collection sortable<?= (!$item["items"] ? " empty" : "") ?>"<?= HTML()->jsData(["sortable"]) ?>>
		<h2>Collection items</h2>
		<ul class="items products">
<?		foreach($item["items"] as $collection_item):
			$size_tag_index = arrayKeyValue($collection_item["tags"], "context", "size");
			$size = $size_tag_index !== false ? $collection_item["tags"][$size_tag_index]["value"] : false;

			$color_tag_index = arrayKeyValue($collection_item["tags"], "context", "color");
			$color = $color_tag_index !== false ? $collection_item["tags"][$color_tag_index]["value"] : false;
			?>
			<li class="item project" data-item-id="<?= $collection_item["item_id"] ?>"><h3><?= $collection_item["name"] ?></h3></li>
<?		endforeach; ?>
		</ul>

<?		if(!$item["items"]): ?>
		<p class="empty">No items in this collection yet. Add available items below.</p>
<?		endif; ?>

	</div>

	<div class="all_items available i:collapseHeader">
		<h2>Available items</h2>
		<ul class="items">
<?		foreach($all_items as $available_item):
			if(!$item["items"] || array_search($available_item, $item["items"]) === false):
				$size_tag_index = arrayKeyValue($available_item["tags"], "context", "size");
				$size = $size_tag_index !== false ? $available_item["tags"][$size_tag_index]["value"] : false;

				$color_tag_index = arrayKeyValue($available_item["tags"], "context", "color");
				$color = $color_tag_index !== false ? $available_item["tags"][$color_tag_index]["value"] : false;
				?>
			<li class="item product" data-item-id="<?= $available_item["item_id"] ?>">
				<h3><?= $available_item["name"] . ($size ? '<span class="tag">'.$size.'</span>' : ""). ($color ? '<span class="tag">'.$color.'</span>' : "") ?></h3>
				<ul class="actions">
					<?= HTML()->oneButtonForm("Add", "add", array(
						"wrapper" => "li.add",
						"inputs" => [
							"item_id" => $available_item["id"],
						],
						"success-function" => "added",
						"class" => "primary",
					)); ?>
				</ul>
			</li>
<?			endif;
		endforeach; ?>
		</ul>
	</div>

	<?= $JML->editMediae($item) ?>

	<?= $JML->editTags($item, ["context" => "$itemtype,on"]) ?>

	<?= $JML->editPrices($item, ["text" => "The collection price works as a fallback price for products without a specific price. This allows you to have a default price for a collection, while certain variants may still have a different price."]) ?>

	<?= $JML->editCannonicalUrl($item) ?>

	<?= $JML->editSindex($item) ?>

	<?= $JML->editOwner($item) ?>

	<?= $JML->editDeveloperSettings($item) ?>

</div>
