<?php
App::uses('ShopProductSize', 'Shop.Model');

/**
 * ShopProductSize Test Case
 *
 */
class ShopProductSizeTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.shop.shop_product_size',
		'plugin.shop.shop_product',
		'plugin.view_counter.view_counter_view',
		'plugin.shop.shop_unit',
		'plugin.shop.shop_unit_type'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->ShopProductSize = ClassRegistry::init('Shop.ShopProductSize');
		$this->modelClass = $this->ShopProductSize->alias;
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->ShopProductSize);

		parent::tearDown();
	}

/**
 * @brief test find sizes exception
 *
 * @expectedException  InvalidArgumentException
 */
	public function testFindSizesException() {
		$this->{$this->modelClass}->find('sizes');
	}

/**
 * @brief test find sizes
 *
 * @param type $data
 * @param type $expected
 *
 * @dataProvider findSizesDataProvider
 */
	public function testFindSizes($data, $expected) {
		$result = $this->{$this->modelClass}->find('sizes', array('shop_product_id' => $data));
		$this->assertEquals($expected, $result);
	}

/**
 * @brief data provider for product sizes
 *
 * @return array
 */
	public function findSizesDataProvider() {
		return array(
			'active' => array(
				'active',
				array(
					array(
						'ShopProductSize' => array(
							'id' => 'active-product-weight',
							'value' => '100.000',
							'symbol' => 'g',
							'ShopUnit' => array(
								'id' => 'product-weight',
								'name' => 'product-weight',
								'slug' => 'product-weight',
								'shop_unit_type_id' => 'mass'
							)
						)
					),
					array(
						'ShopProductSize' => array(
							'id' => 'active-ship-weight',
							'value' => '200.000',
							'symbol' => 'g',
							'ShopUnit' => array(
								'id' => 'ship-weight',
								'name' => 'ship-weight',
								'slug' => 'ship-weight',
								'shop_unit_type_id' => 'mass'
							)
						)
					)
				)
			),
			'fake-product' => array(
				'fake-product',
				array()
			)
		);
	}

/**
 * @brief test find sizes extracted
 *
 * @param type $data
 * @param type $expected
 *
 * @dataProvider findSizesExtractedDataProvider
 */
	public function testFindSizesExtracted($data, $expected) {
		$result = $this->{$this->modelClass}->find('sizes', array('shop_product_id' => $data, 'extract' => true));
		$this->assertEquals($expected, $result);
	}

/**
 * @brief data provider for product sizes
 *
 * @return array
 */
	public function findSizesExtractedDataProvider() {
		return array(
			'active' => array(
				'active',
				array(
					array(
						'id' => 'active-product-weight',
						'value' => '100.000',
						'symbol' => 'g',
						'ShopUnit' => array(
							'id' => 'product-weight',
							'name' => 'product-weight',
							'slug' => 'product-weight',
							'shop_unit_type_id' => 'mass'
						)
					),
					array(
						'id' => 'active-ship-weight',
						'value' => '200.000',
						'symbol' => 'g',
						'ShopUnit' => array(
							'id' => 'ship-weight',
							'name' => 'ship-weight',
							'slug' => 'ship-weight',
							'shop_unit_type_id' => 'mass'
						)
					)
				)
			),
			'fake-product' => array(
				'fake-product',
				array()
			)
		);
	}

}
