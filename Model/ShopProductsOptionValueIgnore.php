<?php
/**
 * ShopProductsOptionValueIgnore Model
 *
 * @property ShopOptionValue $ShopOptionValue
 * @property ShopProduct $ShopProduct
 * @property ShopCategory $ShopCategory
 */
class ShopProductsOptionValueIgnore extends ShopAppModel {
/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'ShopOptionValue' => array(
			'className' => 'ShopOptionValue',
			'foreignKey' => 'shop_option_value_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'ShopProduct' => array(
			'className' => 'Shop.ShopOption',
			'foreignKey' => 'foreign_key',
			'conditions' => array(
				'ShopProductsOptionIgnore.model' => 'Shop.ShopProduct'
			),
			'fields' => '',
			'order' => ''
		),
		'ShopCategory' => array(
			'className' => 'Shop.ShopCategory',
			'foreignKey' => 'foreign_key',
			'conditions' => array(
				'ShopProductsOptionIgnore.model' => 'Shop.ShopCategory'
			),
			'fields' => '',
			'order' => ''
		)
	);
}
