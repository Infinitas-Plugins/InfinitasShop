<?php
/**
 * ShopProductVariant
 *
 * @copyright Copyright (c) 2009 Carl Sutton (dogmatic69)
 *
 * @link http://infinitas-cms.org/
 * @package Shop.Model
 * @license http://infinitas-cms.org/mit-license The MIT License
 * @since 0.9b1
 *
 * @author Carl Sutton <dogmatic69@infinitas-cms.org>
 */

class ShopProductVariant extends ShopAppModel {

/**
 * belongsTo relations
 *
 * @var array
 */
	public $belongsTo = array(
		'ShopProduct' => array(
			'className' => 'Shop.ShopProduct',
			'foreignKey' => 'shop_product_id',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'counterCache' => true,
			'counterScope' => array(
				'ShopProductVariant.active' => 1
			),
		)
	);

/**
 * hasMany relations
 *
 * @var array
 */
	public $hasMany = array(
		'ShopListProduct' => array(
			'className' => 'Shop.ShopListProduct',
			'foreignKey' => 'shop_product_variant_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'ShopOptionVariant' => array(
			'className' => 'Shop.ShopOptionVariant',
			'foreignKey' => 'shop_product_variant_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'ShopOrderProduct' => array(
			'className' => 'Shop.ShopOrderProduct',
			'foreignKey' => 'shop_product_variant_id',
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

/**
 * Constructor
 *
 * @param mixed $id string uuid or id
 * @param string $table the table that the model is for
 * @param string $ds the datasource being used
 *
 * @return void
 */
	public function __construct($id = false, $table = null, $ds = null) {
		parent::__construct($id, $table, $ds);

		$this->validate = array(
		);
	}
}