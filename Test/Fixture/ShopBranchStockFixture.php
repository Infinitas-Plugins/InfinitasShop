<?php
/**
 * ShopBranchStockFixture
 *
 */
class ShopBranchStockFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'primary'),
		'shop_branch_id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'index'),
		'shop_product_id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'index'),
		'stock' => array('type' => 'integer', 'null' => false, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'fk_shop_branch_stocks_shop_products1' => array('column' => 'shop_product_id', 'unique' => 0),
			'fk_shop_branch_stocks_shop_branches1' => array('column' => 'shop_branch_id', 'unique' => 0)
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
			'id' => 'branch-stock-1',
			'shop_branch_id' => 'branch-1',
			'shop_product_id' => 'active',
			'stock' => 10
		),
		array(
			'id' => 'branch-stock-2',
			'shop_branch_id' => 'branch-2',
			'shop_product_id' => 'active',
			'stock' => 15
		),
		array(
			'id' => 'branch-stock-3',
			'shop_branch_id' => 'branch-1',
			'shop_product_id' => 'out-of-stock',
			'stock' => 0
		),
	);

}
