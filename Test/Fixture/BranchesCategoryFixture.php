<?php
/**
 * @brief fixture file for BranchesCategory tests.
 *
 * @package Shop.Fixture
 * @since 0.9b1
 */
class BranchesCategoryFixture extends CakeTestFixture {
	public $name = 'BranchesCategory';

	public $fields = array(
		'id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'primary'),
		'branch_id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36),
		'category_id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

	public $records = array(
	);
}