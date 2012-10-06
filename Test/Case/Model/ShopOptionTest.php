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
		$results = $this->{$this->modelClass}->find('options', array('shop_product_id' => $data));
		$this->assertEquals($expected, $results);
	}

/**
 * @brief find options data provider
 *
 * @return array
 */
	public function findOptionsDataProvider() {
		return array(
			'multi-category' => array(
				'multi-category',
				array()
			),
			'active' => array(
				'active',
				array(
					array(
						'ShopOption' => array(
							'id' => 'option-size',
							'name' => 'Size',
							'shop_product_id' => 'active',
							'ShopOptionValue' => array(
								array(
									'id' => 'option-size-large',
									'name' => 'Large',
									'shop_option_id' => 'option-size',
									'ShopPrice' => array(
										'id' => 'option-value-large',
										'selling' => '3.00000',
										'retail' => '4.00000'
									)
								),
								array(
									'id' => 'option-size-medium',
									'name' => 'Medium',
									'shop_option_id' => 'option-size',
									'ShopPrice' => array(
										'id' => null,
										'selling' => null,
										'retail' => null
									)
								),
								array(
									'id' => 'option-size-small',
									'name' => 'Small',
									'shop_option_id' => 'option-size',
									'ShopPrice' => array(
										'id' => null,
										'selling' => null,
										'retail' => null
									)
								)
							)
						)
					)
				)
			),
			'multi-option' => array(
				'multi-option',
				array(
					array(
						'ShopOption' => array(
							'id' => 'option-size',
							'name' => 'Size',
							'shop_product_id' => 'multi-option',
							'ShopOptionValue' => array(
								array(
									'id' => 'option-size-large',
									'name' => 'Large',
									'shop_option_id' => 'option-size',
									'ShopPrice' => array(
										'id' => 'option-value-large',
										'selling' => '3.00000',
										'retail' => '4.00000'
									)
								),
								array(
									'id' => 'option-size-medium',
									'name' => 'Medium',
									'shop_option_id' => 'option-size',
									'ShopPrice' => array(
										'id' => null,
										'selling' => null,
										'retail' => null
									)
								),
								array(
									'id' => 'option-size-small',
									'name' => 'Small',
									'shop_option_id' => 'option-size',
									'ShopPrice' => array(
										'id' => null,
										'selling' => null,
										'retail' => null
									)
								)
							)
						)
					),
					array(
						'ShopOption' => array(
							'id' => 'option-colour',
							'name' => 'Colour',
							'shop_product_id' => 'multi-option',
							'ShopOptionValue' => array(
								array(
									'id' => 'option-colour-blue',
									'name' => 'Blue',
									'shop_option_id' => 'option-colour',
									'ShopPrice' => array(
										'id' => null,
										'selling' => null,
										'retail' => null
									)
								),
								array(
									'id' => 'option-colour-red',
									'name' => 'Red',
									'shop_option_id' => 'option-colour',
									'ShopPrice' => array(
										'id' => null,
										'selling' => null,
										'retail' => null
									)
								),
							)
						)
					)
				)
			)
		);
	}

/**
 * @brief test finding product options extracted
 *
 * @dataProvider productOptionExtractDataProvider
 */
	public function testFindOptionsExtracted($data, $expected) {
		$results = $this->{$this->modelClass}->find('options', array('shop_product_id' => $data, 'extract' => true));
		$this->assertEquals($expected, $results);
	}

/**
 * @brief extracted options data provider
 * @return type
 */
	public function productOptionExtractDataProvider() {
		return array(
			'made-up' => array(
				'made-up-option',
				array()
			),
			'multi-option' => array(
				'multi-option',
				array(
					array(
						'id' => 'option-size',
						'name' => 'Size',
						'shop_product_id' => 'multi-option',
						'ShopOptionValue' => array(
							array(
								'id' => 'option-size-large',
								'name' => 'Large',
								'shop_option_id' => 'option-size',
									'ShopPrice' => array(
										'id' => 'option-value-large',
										'selling' => '3.00000',
										'retail' => '4.00000'
									)
							),
							array(
								'id' => 'option-size-medium',
								'name' => 'Medium',
								'shop_option_id' => 'option-size',
									'ShopPrice' => array(
										'id' => null,
										'selling' => null,
										'retail' => null
									)
							),
							array(
								'id' => 'option-size-small',
								'name' => 'Small',
								'shop_option_id' => 'option-size',
									'ShopPrice' => array(
										'id' => null,
										'selling' => null,
										'retail' => null
									)
							)
						)
					),
					array(
						'id' => 'option-colour',
						'name' => 'Colour',
						'shop_product_id' => 'multi-option',
						'ShopOptionValue' => array(
							array(
								'id' => 'option-colour-blue',
								'name' => 'Blue',
								'shop_option_id' => 'option-colour',
									'ShopPrice' => array(
										'id' => null,
										'selling' => null,
										'retail' => null
									)
							),
							array(
								'id' => 'option-colour-red',
								'name' => 'Red',
								'shop_option_id' => 'option-colour',
									'ShopPrice' => array(
										'id' => null,
										'selling' => null,
										'retail' => null
									)
							),
						)
					)
				)
			)
		);
	}

}
