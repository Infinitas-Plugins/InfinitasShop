<?php
/**
 * ShopOptionFixture
 *
 * @package Shop.Test.Fixture
 * @since 0.9b1
 */

class ShopOptionFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'slug' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'description' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'required' => array('type' => 'integer', 'null' => false, 'default' => 1, 'length' => 1),
		'shop_option_value_count' => array('type' => 'integer', 'null' => false, 'default' => 0, 'length' => 6),
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
			'id' => 'option-size',
			'name' => 'option-size',
			'slug' => 'option-size',
			'description' => 'some descriptive text about option-size',
			'required' => 1,
			'shop_option_value_count' => 3,
			'created' => '2012-10-05 09:59:11',
			'modified' => '2012-10-05 09:59:11'
		),
		array(
			'id' => 'option-colour',
			'name' => 'option-colour',
			'slug' => 'option-colour',
			'description' => 'some descriptive text about option-colour',
			'required' => 0,
			'shop_option_value_count' => 2,
			'created' => '2012-10-05 09:59:11',
			'modified' => '2012-10-05 09:59:11'
		),
	);

}
