<?php
/**
 * ShopProductsOptionIgnore Model
 *
 * @property ShopOption $ShopOption
 * @property ShopProduct $ShopProduct
 * @property ShopCategory $ShopCategory
 */
class ShopProductsOptionIgnore extends ShopAppModel {
/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'ShopOption' => array(
			'className' => 'Shop.ShopOption',
			'foreignKey' => 'shop_option_id',
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
