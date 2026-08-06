<?php
global $action;
global $model;
global $itemtype;

$item_id = $action[1];
$item = items()->getItem(array("id" => $item_id, "extend" => array("tags" => true, "mediae" => true)));
?>
<div class="scene i:scene defaultEdit <?= $itemtype ?>Edit">
	<h1>Edit product</h1>
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

	<?= $JML->editTags($item, ["context" => "size", "label" => "Size"]) ?>

	<?= $JML->editTags($item, ["context" => "color", "label" => "Color"]) ?>

	<?= $JML->editMediae($item) ?>

	<?= $JML->editTags($item, ["context" => "$itemtype,on"]) ?>

	<?= $JML->editPrices($item) ?>

	<?= $JML->editCannonicalUrl($item) ?>

	<?= $JML->editSindex($item) ?>

	<?= $JML->editOwner($item) ?>

	<?= $JML->editDeveloperSettings($item) ?>

</div>
