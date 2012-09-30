<?php
/**
 * @brief fixture file for ShopBranch tests.
 *
 * @package Shop.Fixture
 * @since 0.9b1
 */
class ShopBranchFixture extends CakeTestFixture {
	public $name = 'ShopBranch';

	public $fields = array(
		'id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'primary'),
		'branch_id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36),
		'manager_id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36),
		'ordering' => array('type' => 'integer', 'null' => false, 'default' => '1'),
		'active' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

	public $records = array(
	);
}