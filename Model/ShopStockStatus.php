<?php
/**
 * ShopStockStatus Model
 *
 */

class ShopStockStatus extends ShopAppModel {

/**
 * validation rules
 *
 * @var array
 */
	public $validate = array();

/**
 * overload construct for translated validation
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
