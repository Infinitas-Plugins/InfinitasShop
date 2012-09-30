<?php
/* ShopBranchesCategory Fixture generated on: 2010-08-17 14:08:42 : 1282055202 */
class ShopBranchesCategoryFixture extends CakeTestFixture {
	public $name = 'ShopBranchesCategory';

	public $fields = array(
		'id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'key' => 'primary'),
		'branch_id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36),
		'category_id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

	public $records = array(
	);
}
?>