<?php
/**
 * ShopProductOptionValueOverride Model
 *
 * @property ShopPrice $ShopPrice
 * @property ShopOptionsValue $ShopOptionsValue
 * @property ShopProduct $ShopProduct
 * @property ShopCategory $ShopCategory
 */
class ShopProductsOptionValueOverride extends ShopAppModel {

/**
 * hasOne associations
 *
 * @var array
 */
	public $hasOne = array(
		'ShopPrice' => array(
			'className' => 'Shop.ShopPrice',
			'foreignKey' => 'foreign_key',
			'conditions' => array(
				'ShopPrice.model' => 'Shop.ShopOptionValue'
			),
			'fields' => '',
			'order' => ''
		)
	);

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
