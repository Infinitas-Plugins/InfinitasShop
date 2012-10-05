<?php
App::uses('ShopBranchStock', 'Shop.Model');

/**
 * ShopBranchStock Test Case
 *
 */
class ShopBranchStockTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.shop.shop_branch_stock',
		'plugin.shop.shop_branch',
		'plugin.shop.shop_product',
		'plugin.shop.shop_branch_stock_log',
		'plugin.view_counter.view_counter_view',
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->ShopBranchStock = ClassRegistry::init('Shop.ShopBranchStock');
		$this->modelClass = $this->ShopBranchStock->alias;
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->ShopBranchStock);

		parent::tearDown();
	}

/**
 * @brief test find productStock exceptions
 *
 * @expectedException InvalidArgumentException
 *
 * @dataProvider customFindExceptionsDataProvider
 */
	public function testCustomFindExceptions($data) {
		$this->{$this->modelClass}->find($data);
	}

/**
 * @brief data provider for testing exceptions in the custom finds
 *
 * @return array
 */
	public function customFindExceptionsDataProvider() {
		return array(
			array('productStock'),
			array('isInStock'),
		);
	}

/**
 * @brief test find product stock
 *
 * @param type $data
 * @param type $expected
 *
 * @dataProvider findProductStockDataProvider
 */
	public function testFindProductStock($data, $expected) {
		$result = $this->{$this->modelClass}->find('productStock', array('shop_product_id' => $data));
		$this->assertEquals($expected, $result);
	}

/**
 * @brief find product stock data provider
 *
 * @return array
 */
	public function findProductStockDataProvider() {
		return array(
			'different-branches' => array(
				'active',
				array(array(
					'ShopBranchStock' => array(
						'id' => 'branch-stock-1',
						'shop_branch_id' => 'branch-1',
						'stock' => '10'
						)), array(
					'ShopBranchStock' => array(
						'id' => 'branch-stock-2',
						'shop_branch_id' => 'branch-2',
						'stock' => '15'
					))
				)
			),
			'no-stock-added' => array(
				'no-stock-added',
				array()
			),
			'out-of-stock' => array(
				'out-of-stock',
				array(array(
					'ShopBranchStock' => array(
						'id' => 'branch-stock-3',
						'shop_branch_id' => 'branch-1',
						'stock' => '0'
					)))
			)

		);
	}

/**
 * @brief test find product stock extracted
 *
 * @param type $data
 * @param type $expected
 *
 * @dataProvider findProductStockExtractedDataProvider
 */
	public function testFindProductStockExtracted($data, $expected) {
		$result = $this->{$this->modelClass}->find('productStock', array(
			'shop_product_id' => $data,
			'extract' => true
		));
		$this->assertEquals($expected, $result);
	}

/**
 * @brief find product stock extracted data provider
 *
 * @return array
 */
	public function findProductStockExtractedDataProvider() {
		return array(
			'different-branches' => array(
				'active',
				array(
					array(
						'id' => 'branch-stock-1',
						'shop_branch_id' => 'branch-1',
						'stock' => '10'
					), array(
						'id' => 'branch-stock-2',
						'shop_branch_id' => 'branch-2',
						'stock' => '15'
					)
				)
			),
			'no-stock-added' => array(
				'no-stock-added',
				array()
			),
			'out-of-stock' => array(
				'out-of-stock',
				array(
					array(
						'id' => 'branch-stock-3',
						'shop_branch_id' => 'branch-1',
						'stock' => '0'
					)
				)
			)
		);
	}

/**
 * @brief test isInStock custom find
 *
 * @dataProvider findIsInStockDataProvider
 */
	public function testFindIsInStock($data, $expected) {
		$result = $this->{$this->modelClass}->find('isInStock', array('shop_product_id' => $data));
		$this->assertEquals($expected, $result);
	}

/**
 * @brief find isInStock data provider
 *
 * @return array
 */
	public function findIsInStockDataProvider() {
		return array(
			'madeup-product' => array(
				'madeup-product',
				array()
			),
			'no-stock-added' => array(
				'no-stock-added',
				array()
			),
			'has-stock' => array(
				'active',
				array(
					'active' => true
				)
			),
			'out-of-stock' => array(
				'out-of-stock',
				array()
			),
			'mixed' => array(
				array(
					'active',
					'no-stock-added',
					'out-of-stock'
				),
				array(
					'active' => true
				)
			)
		);
	}

}