<?php
/**
 * ShopOptionValueFixture
 *
 */
class ShopOptionValueFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'shop_option_id' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 36, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'fk_shop_attributes_shop_attribute_groups1' => array('column' => 'shop_option_id', 'unique' => 0)
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
			'id' => 'option-size-small',
			'name' => 'Small',
			'shop_option_id' => 'option-size',
			'created' => '2012-10-05 10:01:02',
			'modified' => '2012-10-05 10:01:02'
		),
		array(
			'id' => 'option-size-medium',
			'name' => 'Medium',
			'shop_option_id' => 'option-size',
			'created' => '2012-10-05 10:01:02',
			'modified' => '2012-10-05 10:01:02'
		),
		array(
			'id' => 'option-size-large',
			'name' => 'Large',
			'shop_option_id' => 'option-size',
			'created' => '2012-10-05 10:01:02',
			'modified' => '2012-10-05 10:01:02'
		),
		array(
			'id' => 'option-colour-red',
			'name' => 'Red',
			'shop_option_id' => 'option-colour',
			'created' => '2012-10-05 10:01:02',
			'modified' => '2012-10-05 10:01:02'
		),
		array(
			'id' => 'option-colour-blue',
			'name' => 'Blue',
			'shop_option_id' => 'option-colour',
			'created' => '2012-10-05 10:01:02',
			'modified' => '2012-10-05 10:01:02'
		),
	);

}
