<?php
/**
 * @brief fixture file for ShopAttributeGroup tests.
 *
 * @package .Fixture
 * @since 0.9b1
 */
class ShopAttributeGroupFixture extends CakeTestFixture {
	public $name = 'ShopAttributeGroup';

	public $fields = array(
		'id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'primary', 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'slug' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'shop_attribute_count' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 5),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);

	public $records = array(
		array(
			'id' => 'attr-group-condition',
			'name' => 'attr-group-condition',
			'slug' => 'attr-group-condition',
			'shop_attribute_count' => 2,
			'created' => '2013-01-31 21:13:54',
			'modified' => '2013-01-31 21:13:54'
		),
	);
}