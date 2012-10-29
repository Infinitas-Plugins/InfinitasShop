<?php
/**
 * ContactAddressFixture
 *
 */
class ShopContactAddressFixture extends CakeTestFixture {
/**
 * @brief table to use
 *
 * @var string
 */
	public $table = 'contact_addresses';

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'street' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'city' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'province' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'postal' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 10, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'country_id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'continent_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 2),
		'latitude' => array('type' => 'float', 'null' => true, 'default' => null, 'length' => '9,6'),
		'longitude' => array('type' => 'float', 'null' => true, 'default' => null, 'length' => '9,6'),
		'model' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'foreign_key' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
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
			'id' => '507190e3-1634-43e9-9d40-56ab6318cd70',
			'name' => 'Lorem ipsum dolor sit amet',
			'street' => 'Lorem ipsum dolor sit amet',
			'city' => 'Lorem ipsum dolor sit amet',
			'province' => 'Lorem ipsum dolor sit amet',
			'postal' => 'Lorem ip',
			'country_id' => 'Lorem ipsum dolor sit amet',
			'continent_id' => 1,
			'latitude' => 1,
			'longitude' => 1,
			'model' => 'Lorem ipsum dolor sit amet',
			'foreign_key' => 'Lorem ipsum dolor sit amet',
			'created' => '2012-10-07 15:25:39',
			'modified' => '2012-10-07 15:25:39'
		),
		array(
			'id' => '507190e3-958c-4023-a8a4-56ab6318cd70',
			'name' => 'Lorem ipsum dolor sit amet',
			'street' => 'Lorem ipsum dolor sit amet',
			'city' => 'Lorem ipsum dolor sit amet',
			'province' => 'Lorem ipsum dolor sit amet',
			'postal' => 'Lorem ip',
			'country_id' => 'Lorem ipsum dolor sit amet',
			'continent_id' => 2,
			'latitude' => 2,
			'longitude' => 2,
			'model' => 'Lorem ipsum dolor sit amet',
			'foreign_key' => 'Lorem ipsum dolor sit amet',
			'created' => '2012-10-07 15:25:39',
			'modified' => '2012-10-07 15:25:39'
		),
		array(
			'id' => '507190e3-0350-4aca-9670-56ab6318cd70',
			'name' => 'Lorem ipsum dolor sit amet',
			'street' => 'Lorem ipsum dolor sit amet',
			'city' => 'Lorem ipsum dolor sit amet',
			'province' => 'Lorem ipsum dolor sit amet',
			'postal' => 'Lorem ip',
			'country_id' => 'Lorem ipsum dolor sit amet',
			'continent_id' => 3,
			'latitude' => 3,
			'longitude' => 3,
			'model' => 'Lorem ipsum dolor sit amet',
			'foreign_key' => 'Lorem ipsum dolor sit amet',
			'created' => '2012-10-07 15:25:39',
			'modified' => '2012-10-07 15:25:39'
		),
		array(
			'id' => '507190e3-74fc-41e6-bb9f-56ab6318cd70',
			'name' => 'Lorem ipsum dolor sit amet',
			'street' => 'Lorem ipsum dolor sit amet',
			'city' => 'Lorem ipsum dolor sit amet',
			'province' => 'Lorem ipsum dolor sit amet',
			'postal' => 'Lorem ip',
			'country_id' => 'Lorem ipsum dolor sit amet',
			'continent_id' => 4,
			'latitude' => 4,
			'longitude' => 4,
			'model' => 'Lorem ipsum dolor sit amet',
			'foreign_key' => 'Lorem ipsum dolor sit amet',
			'created' => '2012-10-07 15:25:39',
			'modified' => '2012-10-07 15:25:39'
		),
		array(
			'id' => '507190e3-e4b4-464f-8a03-56ab6318cd70',
			'name' => 'Lorem ipsum dolor sit amet',
			'street' => 'Lorem ipsum dolor sit amet',
			'city' => 'Lorem ipsum dolor sit amet',
			'province' => 'Lorem ipsum dolor sit amet',
			'postal' => 'Lorem ip',
			'country_id' => 'Lorem ipsum dolor sit amet',
			'continent_id' => 5,
			'latitude' => 5,
			'longitude' => 5,
			'model' => 'Lorem ipsum dolor sit amet',
			'foreign_key' => 'Lorem ipsum dolor sit amet',
			'created' => '2012-10-07 15:25:39',
			'modified' => '2012-10-07 15:25:39'
		),
		array(
			'id' => '507190e3-5278-440f-87c4-56ab6318cd70',
			'name' => 'Lorem ipsum dolor sit amet',
			'street' => 'Lorem ipsum dolor sit amet',
			'city' => 'Lorem ipsum dolor sit amet',
			'province' => 'Lorem ipsum dolor sit amet',
			'postal' => 'Lorem ip',
			'country_id' => 'Lorem ipsum dolor sit amet',
			'continent_id' => 6,
			'latitude' => 6,
			'longitude' => 6,
			'model' => 'Lorem ipsum dolor sit amet',
			'foreign_key' => 'Lorem ipsum dolor sit amet',
			'created' => '2012-10-07 15:25:39',
			'modified' => '2012-10-07 15:25:39'
		),
		array(
			'id' => '507190e3-bfd8-4134-8c10-56ab6318cd70',
			'name' => 'Lorem ipsum dolor sit amet',
			'street' => 'Lorem ipsum dolor sit amet',
			'city' => 'Lorem ipsum dolor sit amet',
			'province' => 'Lorem ipsum dolor sit amet',
			'postal' => 'Lorem ip',
			'country_id' => 'Lorem ipsum dolor sit amet',
			'continent_id' => 7,
			'latitude' => 7,
			'longitude' => 7,
			'model' => 'Lorem ipsum dolor sit amet',
			'foreign_key' => 'Lorem ipsum dolor sit amet',
			'created' => '2012-10-07 15:25:39',
			'modified' => '2012-10-07 15:25:39'
		),
		array(
			'id' => '507190e3-2c0c-4f57-bf97-56ab6318cd70',
			'name' => 'Lorem ipsum dolor sit amet',
			'street' => 'Lorem ipsum dolor sit amet',
			'city' => 'Lorem ipsum dolor sit amet',
			'province' => 'Lorem ipsum dolor sit amet',
			'postal' => 'Lorem ip',
			'country_id' => 'Lorem ipsum dolor sit amet',
			'continent_id' => 8,
			'latitude' => 8,
			'longitude' => 8,
			'model' => 'Lorem ipsum dolor sit amet',
			'foreign_key' => 'Lorem ipsum dolor sit amet',
			'created' => '2012-10-07 15:25:39',
			'modified' => '2012-10-07 15:25:39'
		),
		array(
			'id' => '507190e3-96b0-4c82-9968-56ab6318cd70',
			'name' => 'Lorem ipsum dolor sit amet',
			'street' => 'Lorem ipsum dolor sit amet',
			'city' => 'Lorem ipsum dolor sit amet',
			'province' => 'Lorem ipsum dolor sit amet',
			'postal' => 'Lorem ip',
			'country_id' => 'Lorem ipsum dolor sit amet',
			'continent_id' => 9,
			'latitude' => 9,
			'longitude' => 9,
			'model' => 'Lorem ipsum dolor sit amet',
			'foreign_key' => 'Lorem ipsum dolor sit amet',
			'created' => '2012-10-07 15:25:39',
			'modified' => '2012-10-07 15:25:39'
		),
		array(
			'id' => '507190e3-03ac-402a-90aa-56ab6318cd70',
			'name' => 'Lorem ipsum dolor sit amet',
			'street' => 'Lorem ipsum dolor sit amet',
			'city' => 'Lorem ipsum dolor sit amet',
			'province' => 'Lorem ipsum dolor sit amet',
			'postal' => 'Lorem ip',
			'country_id' => 'Lorem ipsum dolor sit amet',
			'continent_id' => 10,
			'latitude' => 10,
			'longitude' => 10,
			'model' => 'Lorem ipsum dolor sit amet',
			'foreign_key' => 'Lorem ipsum dolor sit amet',
			'created' => '2012-10-07 15:25:39',
			'modified' => '2012-10-07 15:25:39'
		),
	);

}
