<?php
/**
 * ShopShippingMethodValueFixture
 *
 * @package Shop.Test.Fixture
 * @since 0.9b1
 */

class ShopShippingMethodValueFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'shop_shipping_method_id' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'active' => array('type' => 'boolean', 'null' => true, 'default' => '1'),
		'insurance' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'rates' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'surcharge' => array('type' => 'float', 'null' => true, 'default' => null, 'length' => '15,5'),
		'delivery_time' => array('type' => 'integer', 'null' => true, 'default' => null),
		'total_minimum' => array('type' => 'float', 'null' => true, 'default' => null, 'length' => '15,5'),
		'total_maximum' => array('type' => 'float', 'null' => true, 'default' => null, 'length' => '15,5'),
		'require_login' => array('type' => 'boolean', 'null' => true, 'default' => null),
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
			'id' => 'royal-mail-1st-rate-1',
			'name' => 'royal-mail-1st-rate-1',
			'shop_shipping_method_id' => 'royal-mail-1st',
			'active' => 1,
			'insurance' => '39:0,100:1,250:2.25,500:3.5',
			'rates' => '100:1.58,250:1.96,500:2.48,750:3.05,1000:3.71',
			'surcharge' => 0,
			'delivery_time' => 48,
			'total_minimum' => 0,
			'total_maximum' => 150,
			'require_login' => 0,
			'created' => '2012-10-08 21:08:12',
			'modified' => '2012-10-08 21:08:12'
		),
		array(
			'id' => 'royal-mail-2nd-rate-1',
			'name' => 'royal-mail-2nd-rate-1',
			'shop_shipping_method_id' => 'royal-mail-2nd',
			'active' => 1,
			'insurance' => null,
			'rates' => '100:1.33,250:1.72,500:2.16,750:2.61,1000:3.15',
			'surcharge' => 0,
			'delivery_time' => 96,
			'total_minimum' => 0,
			'total_maximum' => 150,
			'require_login' => 0,
			'created' => '2012-10-08 21:08:12',
			'modified' => '2012-10-08 21:08:12'
		),
		array(
			'id' => 'royal-mail-2nd-rate-2',
			'name' => 'royal-mail-2nd-rate-2',
			'shop_shipping_method_id' => 'royal-mail-2nd',
			'active' => 1,
			'insurance' => null,
			'rates' => '100:5,250:10,500:15,750:20,1000:25',
			'surcharge' => 0,
			'delivery_time' => 240,
			'total_minimum' => 0,
			'total_maximum' => 150,
			'require_login' => 1,
			'created' => '2012-10-08 21:08:12',
			'modified' => '2012-10-08 21:08:12'
		)
	);

}
