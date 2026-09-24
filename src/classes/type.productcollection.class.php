<?php
/**
* @package janitor.itemtypes
* This file contains itemtype functionality
*/

class TypeProductcollection extends Itemtype {


	public $db;
	public $db_items;


	/**
	* Init, set varnames, validation rules
	*/
	function __construct() {

		// construct ItemType before adding to model
		parent::__construct(get_class());


		// itemtype database
		$this->db = SITE_DB.".item_productcollection";
		$this->db_items = SITE_DB.".item_productcollection_items";


		// Name
		$this->addToModel("name", array(
			"type" => "string",
			"label" => "Collection name",
			"required" => true,
			"hint_message" => "Name of the product collection.", 
			"error_message" => "Name must be filled out."
		));

		// description
		$this->addToModel("description", array(
			"type" => "text",
			"label" => "Short SEO description",
			"max" => 155,
			"hint_message" => "Write a short description of the product collection for SEO and listings.",
			"error_message" => "Your product needs a description – max 155 characters."
		));

		// HTML
		$this->addToModel("html", array(
			"type" => "html",
			"label" => "Full description",
			"allowed_tags" => "p,h2,h3,h4,ul,ol,download,jpg,png,code",
			"hint_message" => "Describe the product.",
			"error_message" => "A product collection description without any words? How weird."
		));

		// Brand
		$this->addToModel("brand", array(
			"type" => "string",
			"label" => "Brand name",
			"hint_message" => "Brand of the product collection.", 
			"error_message" => "Invalid brand value."
		));

		// product_id
		$this->addToModel("product_id", array(
			"type" => "item_id",
			"label" => "Product ID",
			"required" => true,
			"hint_message" => "Id of product to add to collection.", 
			"error_message" => "Invalid product ID."
		));

		// Class
		$this->addToModel("classname", array(
			"type" => "string",
			"label" => "CSS Class for list",
			"pattern" => "[a-z]+[a-z\-\:]*",
			"hint_message" => "CSS class for custom styling. If you don't know what this is, just leave it empty. Must be a valid, implemented css-classname to have any effect.",
			"error_message" => "Invalid CSS class syntax",
		));

		// Single media
		$this->addToModel("single_media", array(
			"type" => "files",
			"label" => "Add media here",
			"max" => 1,
			"allowed_formats" => "png,jpg",
			"hint_message" => "Add single image by dragging it here. PNG or JPG allowed.",
			"error_message" => "Media does not fit requirements."
		));

		// Mediae
		$this->addToModel("mediae", array(
			"type" => "files",
			"label" => "Add media here",
			"max" => 20,
			"allowed_formats" => "png,jpg,mp4",
			"hint_message" => "Add images or videos here. Use png, jpg or mp4.",
			"error_message" => "Media does not fit requirements."
		));

	}

	function get($item_id, $_options = false) {

		$query = new Query();

		$sql = "SELECT * FROM ".$this->db." WHERE item_id = $item_id";
		if($query->sql($sql)) {
			$item = $query->result(0);
			unset($item["id"]);

			$item["items"] = [];

			$sql = "SELECT * FROM ".$this->db_items." WHERE item_id = $item_id ORDER BY position";
			// debug([$sql]);
			if($query->sql($sql)) {
				$items = $query->results();
				foreach($items as $item) {
					$item["items"][] = items()->getItem(["id" => $item["item_id"], $_options]);
				}
			}

			return $item;
		}
		return [];

	}


	function API_add($action) {
		// Get posted values to make them available for models
		$this->getPostedEntities();

		// does values validate
		if(count($action) === 1 && $this->validateList(array("item_id", "product_id"))) {

			$item_id = $this->getProperty("item_id", "value");
			$product_id = $this->getProperty("product_id", "value");

			$result = $this->add([
				"productcollect_id" => $item_id,
				"product_id" => $product_id,
			]);

			if($result) {
				message()->addMessage("Product added to collection");
				return $result;
			}

		}

		message()->addMessage("Product could not be added", array("type" => "error"));
		return false;

	}

	/**
	* Delete item function
	*/
	function add($_options = false) {

		$productcollection_id = false;
		$product_id = false;

		// overwrite defaults
		if($_options !== false) {
			foreach($_options as $_option => $_value) {
				switch($_option) {

					case "productcollection_id"       : $productcollection_id         = $_value; break;
					case "product_id"                 : $product_id                   = $_value; break;

				}
			}
		}


		if($productcollection_id && $product_id) {

			$query = new Query();

			// delete item + itemtype + files
			$sql = "SELECT id FROM ".$this->db_items." WHERE item_id = $productcollection_id AND product_id = $product_id";
			// debug([$sql]);
			if(!$query->sql($sql)) {

				$sql = "INSERT INTO ".$this->db_items." SET item_id = $productcollection_id, product_id = $product_id";
				// debug([$sql]);
				if($query->sql($sql)) {

					// add log
					logger()->addLog("Productcollection->add, item_id: $productcollection_id, product_id: $product_id");

					return true;
				}
			}
			else {
				return true;
			}

		}

		return false;
	}

}
