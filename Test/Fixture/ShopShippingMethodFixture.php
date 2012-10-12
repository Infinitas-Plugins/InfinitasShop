<?php
/**
 * ShopShippingMethodFixture
 *
 */
class ShopShippingMethodFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'active' => array('type' => 'boolean', 'null' => true, 'default' => '1'),
		'shop_shipping_method_value_count' => array('type' => 'integer', 'null' => true, 'default' => null),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
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
			'id' => 'royal-mail-1st',
			'name' => 'royal-mail-1st',
			'active' => 1,
			'shop_shipping_method_value_count' => 1,
			'created' => '2012-10-08 21:08:12',
			'modified' => '2012-10-08 21:08:12'
		),
		array(
			'id' => 'royal-mail-2nd',
			'name' => 'royal-mail-2nd',
			'active' => 1,
			'shop_shipping_method_value_count' => 1,
			'created' => '2012-10-08 21:08:12',
			'modified' => '2012-10-08 21:08:12'
		),
		array(
			'id' => 'inactive',
			'name' => 'inactive',
			'active' => 0,
			'shop_shipping_method_value_count' => 0,
			'created' => '2012-10-08 21:08:12',
			'modified' => '2012-10-08 21:08:12'
		),
	);

}
