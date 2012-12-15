<?php
App::uses('ShopAppModel', 'Shop.Model');
/**
 * ShopSize Model
 *
 * @property ShopProduct $ShopProduct
 */
class ShopSize extends ShopAppModel {

/**
 * belongsTo relations
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
 * overload construct to translate validation messages
 *
 * @param type $id
 * @param type $table
 * @param type $ds
 */
	public function __construct($id = false, $table = null, $ds = null) {
		parent::__construct($id, $table, $ds);

		foreach ($this->schema() as $field => $config) {
			if (strstr($field, 'shipping') === false && strstr($field, 'product') === false) {
				continue;
			}

			$this->validate[$field] = array(

			);
		}
	}

/**
 * Get the fields for finds
 *
 * @return array
 */
	public function findFields($alias = null) {
		return array(
			$this->fullFieldName($this->primaryKey, $alias),
			$this->fullFieldName('product_width', $alias),
			$this->fullFieldName('product_height', $alias),
			$this->fullFieldName('product_length', $alias),
			$this->fullFieldName('shipping_width', $alias),
			$this->fullFieldName('shipping_height', $alias),
			$this->fullFieldName('shipping_length', $alias),
			$this->fullFieldName('product_weight', $alias),
			$this->fullFieldName('shipping_weight', $alias)
		);
	}
}
