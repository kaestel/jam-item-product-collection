<?php
global $module_group_id;
global $module_id;

$module = module()->getModule($module_group_id, $module_id);
$controller = module()->getMainControllerPath($module_id);

?>
<div class="scene module i:module item-product i:itemProduct">
	<h1>Itemtype, Product collection</h1>
	<h2>Configuration</h2>

	<?= HTML()->renderSnippet("snippets/modules/actions-back.php") ?>

	<h3>Module description</h3>
	<?= HTML()->renderSnippet("snippets/modules/panel-info.php", [
		"module" => $module,
	]) ?>
	<?= HTML()->renderSnippet("snippets/modules/panel-version.php", [
		"module" => $module,
	]) ?>


	<div class="controllers">
		<h2>Controller</h2>

		<p>
			The product collection controller is used to access product collections and create meaningful urls on your website.
		</p>
		<p>
			Your product collections can be accessed via the product collection controller by adding the product item sindex to the 
			controller path, like this:
		</p>
		<code><?= SITE_URL ?><span class="controller"><?= $controller ?></span>/productcollection-item-sindex</code>

		<h3>Product collection controller</h3>
		<ul class="controllers">
			<li>
				<h4><span class="controller"><?= $controller ?></span></h4>
			</li>
		</ul>

		<?= HTML()->formStart("modules/renameController/item/productcollection", array("class" => "rename_controller labelstyle:inject")) ?>
			<fieldset>
				<h3>Rename controller</h3>
				<p>
					You can rename the controller to make up the url structure you prefer. Use meaningful name, without special 
					characters or spaces since these does not work well acroos different platforms. Use - to separate words.
				</p>
				<?= HTML()->input("controller_path", [
					"type" => "string",
					"label" => "New controller name",
					"required" => true,
					"pattern" => "^\/[a-z\/]+$",
					"hint_message" => "State the path/name of the controller relative to your domain root. Must be lowercase, only a-z and /.",
					"error_message" => "Controller path is invalid. It must start with / and contain only a-z and /.",
				]) ?>
			</fieldset>

			<ul class="actions">
				<?= HTML()->submit("Rename controller", array("wrapper" => "li.update", "class" => "primary")) ?>
			</ul>
		<?= HTML()->formEnd() ?>

	</div>

	<?= HTML()->renderSnippet("snippets/modules/panel-upgrade.php", [
		"module" => $module,
	]) ?>
	<?= $HTML->renderSnippet("snippets/modules/panel-uninstall.php",  [
		"module" => $module,
	]) ?>

</div>
