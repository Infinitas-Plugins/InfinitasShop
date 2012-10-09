<?php
App::uses('ShopListProductOption', 'Shop.Model');

/**
 * ShopListProductOption Test Case
 *
 */
class ShopListProductOptionTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.shop.shop_list_product_option',
		'plugin.shop.shop_list',
		'plugin.shop.shop_option',
		'plugin.shop.shop_option_value',
		'plugin.shop.shop_products_option_value_override',
		'plugin.shop.shop_price',
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->ShopListProductOption = ClassRegistry::init('Shop.ShopListProductOption');
		$this->modelClass = $this->ShopListProductOption->alias;
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->ShopListProductOption);

		parent::tearDown();
	}

/**
 * @brief test find options exception
 *
 * @expectedException InvalidArgumentException
 */
	public function testFindOptionsException() {
		$this->{$this->modelClass}->find('options');
	}

/**
 * @brief test find options
 *
 * @dataProvider findOptionsDataProvider
 */
	public function testFindOptions($data, $expected) {
		$results = $this->{$this->modelClass}->find('options', array(
			'shop_list_product_id' => $data['shop_list_product_id']
		));
		$this->assertEquals($expected, $results);
	}

/**
 * @brief find options data provider
 */
	public function findOptionsDataProvider() {
		return array(
			'made-up' => array(
				array(
					'shop_list_product_id' => 'made-up'
				),
				array(
				)
			),
			'bob' => array(
				array(
					'shop_list_product_id' => 'shop-list-bob-cart-active'
				),
				array(
					array(
						'id' => 'bob-cart-option-size-large',
						'shop_list_product_id' => 'shop-list-bob-cart-active',
						'shop_option_id' => 'option-size',
						'shop_option_value_id' => 'option-size-large',
						'ShopOption' => array(
							'id' => 'option-size',
							'name' => 'option-size',
							'slug' => 'option-size',
							'required' => '1',
						),
						'ShopOptionValue' => array(
							'id' => 'option-size-large',
							'name' => 'option-size-large',
							'product_code' => 'l',
							'ShopOverridePrice' => array(
								'selling' => null,
								'retail' => null
							),
							'ShopPrice' => array(
								'selling' => '3.00000',
								'retail' => '4.00000'
							)
						)
					)
				)
			),
			'sally-multi-options' => array(
				array(
					'shop_list_product_id' => 'shop-list-sally'
				),
				array(
					array(
						'id' => 'sally-cart-option-colour-red',
						'shop_list_product_id' => 'shop-list-sally',
						'shop_option_id' => 'option-colour',
						'shop_option_value_id' => 'option-colour-red',
						'ShopOption' => array(
							'id' => 'option-colour',
							'name' => 'option-colour',
							'slug' => 'option-colour',
							'required' => '0',
						),
						'ShopOptionValue' => array(
							'id' => 'option-colour-red',
							'name' => 'option-colour-red',
							'product_code' => 'red',
							'ShopOverridePrice' => array(
								'selling' => null,
								'retail' => null
							),
							'ShopPrice' => array(
								'selling' => null,
								'retail' => null
							)
						)
					),
					array(
						'id' => 'sally-cart-option-size-medium',
						'shop_list_product_id' => 'shop-list-sally',
						'shop_option_id' => 'option-size',
						'shop_option_value_id' => 'option-size-medium',
						'ShopOption' => array(
							'id' => 'option-size',
							'name' => 'option-size',
							'slug' => 'option-size',
							'required' => '1',
						),
						'ShopOptionValue' => array(
							'id' => 'option-size-medium',
							'name' => 'option-size-medium',
							'product_code' => 'm',
							'ShopOverridePrice' => array(
								'selling' => null,
								'retail' => null
							),
							'ShopPrice' => array(
								'selling' => null,
								'retail' => null
							)
						)
					)
				)
			)
		);
	}

}
