<?php
/**
 * ShopSupplierFixture
 *
 */
class ShopSupplierFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'slug' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'contact_address_id' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 36),
		'email' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'phone' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 15, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'fax' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 15, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'logo' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 150, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'product_count' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'terms' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 50, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'active' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
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
			'id' => 'supplier-1',
			'name' => 'supplier-1',
			'slug' => 'supplier-1',
			'contact_address_id' => 'supplier-1-address',
			'email' => 'supplier-1@supplier-1.com',
			'phone' => '555 5550',
			'fax' => '555 5551',
			'logo' => 'supplier-1.png',
			'product_count' => 1,
			'terms' => 'cash',
			'active' => 1,
			'created' => '2012-10-07 15:15:11',
			'modified' => '2012-10-07 15:15:11'
		),
		array(
			'id' => 'supplier-2',
			'name' => 'supplier-2',
			'slug' => 'supplier-2',
			'contact_address_id' => 'supplier-2-address',
			'email' => 'supplier-2@supplier-2.com',
			'phone' => '555 5552',
			'fax' => '555 5553',
			'logo' => 'supplier-2.png',
			'product_count' => 1,
			'terms' => 'cash',
			'active' => 1,
			'created' => '2012-10-07 15:15:11',
			'modified' => '2012-10-07 15:15:11'
		),
		array(
			'id' => 'mail-supplier',
			'name' => 'mail-supplier',
			'slug' => 'mail-supplier',
			'contact_address_id' => 'mail-supplier-address',
			'email' => 'mail-supplier@mail-supplier.com',
			'phone' => '555 5552',
			'fax' => '555 5553',
			'logo' => 'mail-supplier.png',
			'product_count' => 0,
			'terms' => 'cash',
			'active' => 1,
			'created' => '2012-10-07 15:15:11',
			'modified' => '2012-10-07 15:15:11'
		),
	);

}
