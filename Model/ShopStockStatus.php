<?php
/**
 * ShopStockStatus Model
 *
 */
class ShopStockStatus extends ShopAppModel {
/**
 * @brief validation rules
 *
 * @var array
 */
	public $validate = array();

/**
 * @brief overload construct for translated validation
 *
 * @param type $id
 * @param type $table
 * @param type $ds
 */
	public function __construct($id = false, $table = null, $ds = null) {
		parent::__construct($id, $table, $ds);

		$this->validate = array(

		);
	}

}
