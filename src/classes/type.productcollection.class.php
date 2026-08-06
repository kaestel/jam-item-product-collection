<?php
/**
* @package janitor.itemtypes
* This file contains itemtype functionality
*/

class TypeProductcollection extends Itemtype {


	public $db;
	public $db_variants;


	/**
	* Init, set varnames, validation rules
	*/
	function __construct() {

		// construct ItemType before adding to model
		parent::__construct(get_class());


		// itemtype database
		$this->db = SITE_DB.".item_productcollection";


		// Name
		$this->addToModel("name", array(
			"type" => "string",
			"label" => "Product name",
			"required" => true,
			"hint_message" => "Name of the product.", 
			"error_message" => "Name must be filled out."
		));

		// description
		$this->addToModel("description", array(
			"type" => "text",
			"label" => "Short SEO description",
			"max" => 155,
			"hint_message" => "Write a short description of the product for SEO and listings.",
			"error_message" => "Your product needs a description – max 155 characters."
		));

		// HTML
		$this->addToModel("html", array(
			"type" => "html",
			"label" => "Full description",
			"allowed_tags" => "p,h2,h3,h4,ul,ol,download,jpg,png,code",
			"hint_message" => "Describe the product.",
			"error_message" => "A product description without any words? How weird."
		));

		// Brand
		$this->addToModel("brand", array(
			"type" => "string",
			"label" => "Brand name",
			"hint_message" => "Brand of the product.", 
			"error_message" => "Invalid brand value."
		));

		// Stock
		$this->addToModel("stock", array(
			"type" => "integer",
			"label" => "Available stock",
			"hint_message" => "How many are available for sale? Leave empty for no limit.", 
			"error_message" => "Invalid stock value."
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

	function get($item_id) {

		$query = new Query();

		$sql = "SELECT * FROM ".$this->db." WHERE item_id = $item_id";
		if($query->sql($sql)) {
			$item = $query->result(0);
			unset($item["id"]);

			$sql = "SELECT * FROM ".$this->db_variants." WHERE item_id = $item_id";
			if($query->sql($sql)) {
				$item["variants"] = $query->results();
			}

			return $item;
		}
		return [];
		
	}
}

?>