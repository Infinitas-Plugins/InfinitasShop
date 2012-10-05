<?php
App::uses('ShopOption', 'Shop.Model');

/**
 * ShopOption Test Case
 *
 */
class ShopOptionTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.shop.shop_option',
		'plugin.shop.shop_option_value',
		'plugin.shop.shop_products_option',
		'plugin.shop.shop_price'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->ShopOption = ClassRegistry::init('Shop.ShopOption');
		$this->modelClass = $this->ShopOption->alias;
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->ShopOption);

		parent::tearDown();
	}

/**
 * @brief test options exception
 *
 * @expectedException InvalidArgumentException
 */
	public function testFindOptionsException() {
		$this->{$this->modelClass}->find('options');
	}

/**
 * @brief test finding product options
 *
 * @dataProvider findOptionsDataProvider
 */
	public function testFindOptions($data, $expected) {
		$results = $this->{$this->modelClass}->find('options', $data);
		$this->assertEquals($expected, $results);
	}

/**
 * @brief find options data provider
 *
 * @return array
 */
	public function findOptionsDataProvider() {
		return array(
			array(
				'multi-category',
				array()
			),
			array(
				'active',
				array(
					array(
						'ShopOption' => array(
							'id' => 'option-size',
							'name' => 'Size',
							'ShopOptionValue' => array(
								array(
									'id' => 'option-size-large',
									'name' => 'Large',
									'shop_option_id' => 'option-size'
								),
								array(
									'id' => 'option-size-medium',
									'name' => 'Medium',
									'shop_option_id' => 'option-size'
								),
								array(
									'id' => 'option-size-small',
									'name' => 'Small',
									'shop_option_id' => 'option-size'
								)
							)
						)
					)
				)
			)
		);
	}

}
