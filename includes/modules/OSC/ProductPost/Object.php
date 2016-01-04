<?php

namespace OSC\ProductPost;

use
	Aedea\Core\Database\StdObject as DbObj
	, OSC\ProductDescription\Collection
			as ProductDescriptionCol
;

class Object extends DbObj {
		
	protected
		$customersId
		, $productsId
		, $locationId
		, $productsImage
		, $productsImageThumbnail
		, $productsPrice
		, $productsDateAdded
		, $productsStatus
		, $manufacturersId
		, $fields
	;
	
	public function toArray( $params = array() ){
		$args = array(
			'include' => array(
				'id',
				'customers_id',
				'location_id',
				'products_image',
				'products_image_thumbnail',
				'products_price',
				'products_date_added',
				'products_status',
				'manufacturers_id',
				'fields'
			)
		);
		return parent::toArray($args);
	}

	public function __construct( $params = array() ){
 		parent::__construct($params);
		
 		$this->fields = new ProductDescriptionCol;
	}

	public function load( $params = array() ){
		$q = $this->dbQuery("
			SELECT
				customers_id,
				location_id,
				products_image,
				products_price,
				products_date_added,
				products_status,
				manufacturers_id,
				products_image_thumbnail
			FROM
				products
			WHERE
				products_id = '" . (int)$this->getId() . "'
		");
		
		if( ! $this->dbNumRows($q) ){
			throw new \Exception(
				"404: Products not found",
				404
			);
		}
		
		$this->setProperties($this->dbFetchArray($q));
		
 		$this->fields->setFilter('id', $this->getId());
 		$this->fields->populate();
	}
	
	public function updateStatus() {
		if( !$this->getProductsId() ) {
			throw new Exception("save method requires id");
		}
		$q = $this->dbQuery("
			UPDATE
				products
			SET 
				products_status = '" . (int)$this->getProductsStatus() . "'
			WHERE
				products_id = '" . (int)$this->getProductsId() . "'
		");
	}

	public function delete(){
		if( !$this->getProductsId() ) {
			throw new Exception("delete method requires id to be set");
		}
		$this->dbQuery("
			DELETE FROM
				products
			WHERE
				products_id = '" . (int)$this->getProductsId() . "'
		");
	}

	public function update(){
		$this->dbQuery("
			UPDATE
				products
			SET
				location_id = '" . (int)$this->getLocationId() . "',
				products_image = '" . $this->getProductsImage() . "',
				products_image_thumbnail = '" . $this->getProductsImageThumbnail() . "',
 				products_price = '" . $this->getProductsPrice() . "'
			WHERE
				products_id = '" . (int)$this->getProductsId() . "'
		");
		
	}
	
	public function insert(){	
		$this->dbQuery("
			INSERT INTO
				products
			(
				customers_id,
				location_id,
				products_image,
				products_image_thumbnail,
				products_price,
				products_date_added,
				products_status,
				manufacturers_id
			)
				VALUES
			(
				'" . (int)$this->getCustomersId() . "',
				'" . (int)$this->getLocationId() . "',
 				'" . $this->dbEscape( $this->getProductsImage() ) . "',
 				'" . $this->dbEscape( $this->getProductsImageThumbnail() ) . "',
				'" . $this->getProductsPrice() . "',
 				NOW(),
 				1,
				'" . (int) $this->getManufacturersId() . "'
			)
		");	
		$this->setProductsId( $this->dbInsertId() );
	}
	
	public function setCustomersId( $int ){
		$this->customersId = (int)$int;
	}
	
	public function getCustomersId(){
		return $this->customersId;
	}
	
	public function setLocationId( $int ){
		$this->locationId = (int)$int;
	}
	
	public function getLocationId(){
		return $this->locationId;
	}
	
	public function setProductsId( $int ){
		$this->productsId = (int)$int;
	}
	
	public function getProductsId(){
		return $this->productsId;
	}
	
	public function setProductsDateAdded( $date ){
		$this->productsDateAdded = $date;
	}
	
	public function getProductsDateAdded(){
		return $this->productsDateAdded;
	}

	public function setProductsImageThumbnail( $string ){
		$this->productsImageThumbnail = (string)$string;
	}

	public function getProductsImageThumbnail(){
		return $this->productsImageThumbnail;
	}

	public function setProductsImage( $string ){
		$this->productsImage = (string)$string;
	}
	
	public function getProductsImage(){
		return $this->productsImage;
	}
	
	public function setProductsStatus( $int ){
		$this->productsStatus = (int)$int;
	}
	
	public function getProductsStatus(){
		return $this->productsStatus;
	}

	public function setManufacturersId( $int ){
		$this->manufacturersId = (int)$int;
	}

	public function getManufacturersId(){
		return $this->manufacturersId;
	}

	public function getFields(){
		return $this->fields;
	}
	public function setFields( $int ){
		$this->fields = $int;
	}

	public function getProductsPrice(){
		return $this->productsPrice;
	}
	public function setProductsPrice( $int ){
		$this->productsPrice = $int;
	}
}
