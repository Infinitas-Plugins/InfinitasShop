<?php
/**
 * ShopPriceFixture
 *
 * @package Shop.Test.Fixture
 * @since 0.9b1
 */

class ShopPriceFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'cost' => array('type' => 'float', 'null' => true, 'default' => null, 'length' => '15,5'),
		'selling' => array('type' => 'float', 'null' => true, 'default' => null, 'length' => '15,5'),
		'retail' => array('type' => 'float', 'null' => true, 'default' => null, 'length' => '15,5'),
		'model' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'foreign_key' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 36, 'key' => 'unique', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'shop_product_id_UNIQUE' => array('column' => 'foreign_key', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => 'active',
			'cost' => 10,
			'selling' => 12,
			'retail' => 15,
			'model' => 'Shop.ShopProduct',
			'foreign_key' => 'active',
			'created' => '2012-10-05 10:04:09',
			'modified' => '2012-10-05 10:04:09'
		),
		array(
			'id' => 'inactive',
			'cost' => 11,
			'selling' => 13,
			'retail' => 15,
			'model' => 'Shop.ShopProduct',
			'foreign_key' => 'inactive',
			'created' => '2012-10-05 10:04:09',
			'modified' => '2012-10-05 10:04:09'
		),
		array(
			'id' => 'inactive-category',
			'cost' => 10.5,
			'selling' => 12.5,
			'retail' => 15,
			'model' => 'Shop.ShopProduct',
			'foreign_key' => 'inactive-category',
			'created' => '2012-10-05 10:04:09',
			'modified' => '2012-10-05 10:04:09'
		),
		array(
			'id' => 'inactive-parent-category',
			'cost' => 9.5,
			'selling' => 11.5,
			'retail' => 15,
			'model' => 'Shop.ShopProduct',
			'foreign_key' => 'inactive-parent-category',
			'created' => '2012-10-05 10:04:09',
			'modified' => '2012-10-05 10:04:09'
		),
		array(
			'id' => 'multi-category',
			'cost' => 5,
			'selling' => 6,
			'retail' => 7,
			'model' => 'Shop.ShopProduct',
			'foreign_key' => 'multi-category',
			'created' => '2012-10-05 10:04:09',
			'modified' => '2012-10-05 10:04:09'
		),
		array(
			'id' => 'multi-category-mixed-state',
			'cost' => 11,
			'selling' => 12,
			'retail' => 15,
			'model' => 'Shop.ShopProduct',
			'foreign_key' => 'multi-category-mixed-state',
			'created' => '2012-10-05 10:04:09',
			'modified' => '2012-10-05 10:04:09'
		),
		array(
			'id' => 'multi-category-parent-inactive',
			'cost' => 11,
			'selling' => 12,
			'retail' => 15,
			'model' => 'Shop.ShopProduct',
			'foreign_key' => 'multi-category-parent-inactive',
			'created' => '2012-10-05 10:04:09',
			'modified' => '2012-10-05 10:04:09'
		),
		array(
			'id' => 'multi-option',
			'cost' => 20,
			'selling' => 25,
			'retail' => 30,
			'model' => 'Shop.ShopProduct',
			'foreign_key' => 'multi-option',
			'created' => '2012-10-05 10:04:09',
			'modified' => '2012-10-05 10:04:09'
		),
		array(
			'id' => 'option-value-large',
			'cost' => 2,
			'selling' => 3,
			'retail' => 4,
			'model' => 'Shop.ShopOptionValue',
			'foreign_key' => 'option-size-large',
			'created' => '2012-10-05 10:04:09',
			'modified' => '2012-10-05 10:04:09'
		)
	);

}
