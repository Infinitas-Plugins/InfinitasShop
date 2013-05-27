<?php
/**
 * @brief fixture file for ShopAddress tests.
 *
 * @package .Fixture
 * @since 0.9b1
 */
class ShopAddressFixture extends CakeTestFixture {

	public $name = 'ShopAddress';

	public $fields = array(
		'id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'user_id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'address_1' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'address_2' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'geo_location_region_id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'geo_location_country_id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'post_code' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 10, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'billing' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

	public $records = array(
		array(
			'id' => 'bob-address-home',
			'user_id' => 'bob',
			'name' => 'Home',
			'address_1' => 'line 1',
			'address_2' => 'line 2',
			'geo_location_region_id' => 1,
			'geo_location_country_id' => 1,
			'post_code' => 'abc123',
			'billing' => 1,
			'created' => '2013-01-09 00:08:57',
			'modified' => '2013-01-09 00:08:57'
		),
		array(
			'id' => 'bob-address-work',
			'user_id' => 'bob',
			'name' => 'Work',
			'address_1' => 'line 1',
			'address_2' => 'line 2',
			'geo_location_region_id' => 1,
			'geo_location_country_id' => 1,
			'post_code' => 'xyz987',
			'billing' => 0,
			'created' => '2013-01-09 00:08:57',
			'modified' => '2013-01-09 00:08:57'
		),
		array(
			'id' => 'sally-address',
			'user_id' => 'sally',
			'name' => 'sally',
			'address_1' => 'line 1',
			'address_2' => 'line 2',
			'geo_location_region_id' => 2,
			'geo_location_country_id' => 3,
			'post_code' => 'xyz987',
			'billing' => 0,
			'created' => '2013-01-09 00:08:57',
			'modified' => '2013-01-09 00:08:57'
		),
	);
}