<?php
/**
 * @brief fixture file for ImagesProduct tests.
 *
 * @package Shop.Fixture
 * @since 0.9b1
 */
class ImagesProductFixture extends CakeTestFixture {
	public $name = 'ImagesProduct';

	public $fields = array(
		'id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'primary'),
		'image_id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36),
		'product_id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	public $records = array(
	);
}