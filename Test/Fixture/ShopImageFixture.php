<?php
/**
 * ShopImageFixture
 *
 */
class ShopImageFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'primary'),
		'image' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'ext' => array('type' => 'string', 'null' => false, 'default' => 'jpg', 'length' => 4, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
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
			'id' => 'image-spotlight-multi-option',
			'image' => 'image-spotlight-multi-option.png',
			'ext' => 'png',
			'created' => '2012-10-06 15:55:43',
			'modified' => '2012-10-06 15:55:43'
		),
		array(
			'id' => 'image-spotlight-active-pending',
			'image' => 'image-spotlight-active-pending.png',
			'ext' => 'png',
			'created' => '2012-10-06 15:55:43',
			'modified' => '2012-10-06 15:55:43'
		),
		array(
			'id' => 'image-special-multi-option',
			'image' => 'image-special-multi-option.png',
			'ext' => 'png',
			'created' => '2012-10-06 15:55:43',
			'modified' => '2012-10-06 15:55:43'
		),
		array(
			'id' => 'image-special-active-pending',
			'image' => 'image-special-active-pending.png',
			'ext' => 'png',
			'created' => '2012-10-06 15:55:43',
			'modified' => '2012-10-06 15:55:43'
		),
		array(
			'id' => 'image-product-active',
			'image' => 'image-product-active.png',
			'ext' => 'png',
			'created' => '2012-10-06 15:55:43',
			'modified' => '2012-10-06 15:55:43'
		),
		array(
			'id' => 'image-product-multi-option',
			'image' => 'image-product-multi-option.png',
			'ext' => 'png',
			'created' => '2012-10-06 15:55:43',
			'modified' => '2012-10-06 15:55:43'
		)
	);

}
