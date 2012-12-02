<?php
/**
 * ShopPrice Model
 *
 * @property ShopProductsOptionValue $ShopProductsOptionValue
 */

class ShopPrice extends ShopAppModel {

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'ShopProductsOptionValue' => array(
			'className' => 'Shop.ShopProductsOptionValue',
			'foreignKey' => 'shop_price_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);
}