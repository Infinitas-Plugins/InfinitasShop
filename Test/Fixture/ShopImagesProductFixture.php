<?php
/* ShopImagesProduct Fixture generated on: 2010-08-17 14:08:58 : 1282055218 */
class ShopImagesProductFixture extends CakeTestFixture {
	public $name = 'ShopImagesProduct';

	public $fields = array(
		'id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'key' => 'primary'),
		'image_id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36),
		'product_id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

	public $records = array(
		array(
			'id' => 34,
			'image_id' => 1,
			'product_id' => 14
		),
		array(
			'id' => 33,
			'image_id' => 1,
			'product_id' => 12
		),
		array(
			'id' => 32,
			'image_id' => 1,
			'product_id' => 13
		),
	);
}
?>