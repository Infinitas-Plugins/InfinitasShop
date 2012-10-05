<?php
/**
 * ShopOptionFixture
 *
 */
class ShopOptionFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'primary', 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'option_count' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 6),
		'ordering' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 6),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => 'option-size',
			'name' => 'Size',
			'option_count' => 3,
			'ordering' => 1,
			'created' => '2012-10-05 09:59:11',
			'modified' => '2012-10-05 09:59:11'
		),
		array(
			'id' => 'option-colour',
			'name' => 'Colour',
			'option_count' => 2,
			'ordering' => 2,
			'created' => '2012-10-05 09:59:11',
			'modified' => '2012-10-05 09:59:11'
		),
	);

}
