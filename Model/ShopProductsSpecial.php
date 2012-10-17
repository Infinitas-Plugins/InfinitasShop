<?php
/**
 * ShopProductsSpecial model
 *
 * @brief Add some documentation for ShopProductsSpecial model.
 *
 * @copyright Copyright (c) 2009 Carl Sutton (dogmatic69)
 *
 * @link		  http://infinitas-cms.org/Shop
 * @package	   Shop.Model
 * @license	   http://infinitas-cms.org/mit-license The MIT License
 * @since 0.9b1
 *
 * @author dogmatic69
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 */

class ShopProductsSpecial extends ShopAppModel {
/**
 * belongsTo relations for this model
 *
 * @access public
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
				'ShopProductsSpecial.active' => 1
			),
		),
		'ShopSpecial' => array(
			'className' => 'Shop.ShopSpecial',
			'foreignKey' => 'shop_special_id',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'counterScope' => array(
				'ShopProductsSpecial.active' => 1
			),
		)
	);

/**
 * overload the construct method so that you can use translated validation
 * messages.
 *
 * @access public
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
