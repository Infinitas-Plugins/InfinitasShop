<?php
App::uses('ShopBranch', 'Shop.Model');

/**
 * ShopBranch Test Case
 *
 */
class ShopBranchTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.shop.shop_branch',
		'plugin.shop.shop_branch_stock',
		'plugin.shop.shop_product',
		'plugin.shop.shop_branch_stock_log',
		'plugin.shop.contact_branch',

		'plugin.users.user',
		'plugin.users.group',
		'plugin.view_counter.view_counter_view',
		'plugin.management.ticket'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->ShopBranch = ClassRegistry::init('Shop.ShopBranch');
		$this->modelClass = $this->ShopBranch->alias;
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->ShopBranch);

		parent::tearDown();
	}

/**
 * @brief test no default branch
 *
 * @expectedException ShopBranchNotConfiguredException
 */
	public function testDefaultBranchIdNon() {
		$this->assertTrue($this->{$this->modelClass}->query('TRUNCATE ' . $this->{$this->modelClass}->fullTableName()));
		$this->assertTrue($this->{$this->modelClass}->find('count') === 0);
		$this->{$this->modelClass}->find('defaultBranchId');
	}

/**
 * @brief test multiple branches available
 *
 * @expectedException ShopBranchMultipleConfiguredException
 */
	public function testDefaultBranchIdMany() {
		$this->assertTrue($this->{$this->modelClass}->find('count') >= 2);
		$this->{$this->modelClass}->find('defaultBranchId');
	}

/**
 * @brief test single branch in use
 */
	public function testDefaultBranchIdOne() {
		$this->assertTrue($this->{$this->modelClass}->deleteAll(array($this->modelClass . '.id !=' => 'branch-1')));

		$expected = 'branch-1';
		$result = $this->{$this->modelClass}->find('defaultBranchId');
		$this->assertEquals($expected, $result);

		$this->assertTrue($this->{$this->modelClass}->find('count') === 1);
	}

}
