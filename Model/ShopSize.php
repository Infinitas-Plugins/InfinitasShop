<?php
App::uses('ShopAppModel', 'Shop.Model');
/**
 * ShopSize Model
 *
 * @property ShopProduct $ShopProduct
 */
class ShopSize extends ShopAppModel {
/**
 * @brief belongsTo relations
 *
 * @var array
 */
	public $belongsTo = array(
		'ShopProduct' => array(
			'className' => 'Shop.ShopProduct',
			'foreignKey' => 'foreign_key'
		)
	);

/**
 * @brief overload construct to translate validation messages
 *
 * @param type $id
 * @param type $table
 * @param type $ds
 */
	public function __construct($id = false, $table = null, $ds = null) {
		parent::__construct($id, $table, $ds);

		foreach($this->schema() as $field => $config) {
			if(strstr($field, 'shipping') === false && strstr($field, 'product') === false) {
				continue;
			}

			$this->validate[$field] = array(

			);
		}
	}
}
