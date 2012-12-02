<?php
/**
 * ShopProductsOptionValue Model
 *
 * @property ShopOptionsValue $ShopOptionsValue
 * @property ShopProductsOptions $ShopProductsOptions
 * @property ShopPrice $ShopPrice
 */
class ShopProductsOptionValue extends ShopAppModel {

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'ShopOptionsValue' => array(
			'className' => 'Shop.ShopOptionsValue',
			'foreignKey' => 'shop_options_value_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'ShopProductsOptions' => array(
			'className' => 'Shop.ShopProductsOptions',
			'foreignKey' => 'shop_products_options_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'ShopPrice' => array(
			'className' => 'Shop.ShopPrice',
			'foreignKey' => 'shop_price_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}