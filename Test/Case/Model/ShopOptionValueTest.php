<?php
App::uses('ShopOptionValue', 'Shop.Model');

/**
 * ShopOptionValue Test Case
 *
 */
class ShopOptionValueTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.shop.shop_option_value',
		'plugin.shop.shop_option',

		'plugin.shop.shop_price'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->ShopOptionValue = ClassRegistry::init('Shop.ShopOptionValue');
		$this->modelClass = $this->ShopOptionValue->alias;
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->ShopOptionValue);

		parent::tearDown();
	}

/**
 * @brief test values exception
 *
 * @expectedException InvalidArgumentException
 */
	public function testFindValuesException() {
		$this->{$this->modelClass}->find('values');
	}

/**
 * @brief test option values
 *
 * @param type $data
 * @param type $expected
 *
 * @dataProvider findValuesDataProvider
 */
	public function testFindValues($data, $expected) {
		$results = $this->{$this->modelClass}->find('values', array('shop_option_id' => $data));
		$this->assertEquals($expected, $results);
	}

/**
 * @brief find values data provider
 *
 * @return array
 */
	public function findValuesDataProvider() {
		return array(
			'invalid' => array(
				'option-madeup',
				array()
			),
			'size' => array(
				'option-size',
				array(
					array(
						'id' => 'option-size-large',
						'name' => 'option-size-large',
						'shop_option_id' => 'option-size',
						'ShopPrice' => array(
							'id' => 'option-value-large',
							'selling' => '3.00000',
							'retail' => '4.00000',
						)
					),
					array(
						'id' => 'option-size-medium',
						'name' => 'option-size-medium',
						'shop_option_id' => 'option-size',
						'ShopPrice' => array(
							'id' => null,
							'selling' => null,
							'retail' => null,
						)
					),
					array(
						'id' => 'option-size-small',
						'name' => 'option-size-small',
						'shop_option_id' => 'option-size',
						'ShopPrice' => array(
							'id' => null,
							'selling' => null,
							'retail' => null,
						)
					),
				)
			),
			'colour' => array(
				'option-colour',
				array(
					array(
						'id' => 'option-colour-blue',
						'name' => 'option-colour-blue',
						'shop_option_id' => 'option-colour',
						'ShopPrice' => array(
							'id' => null,
							'selling' => null,
							'retail' => null,
						)
					),
					array(
						'id' => 'option-colour-red',
						'name' => 'option-colour-red',
						'shop_option_id' => 'option-colour',
						'ShopPrice' => array(
							'id' => null,
							'selling' => null,
							'retail' => null,
						)
					),
				)
			),
			'multiple' => array(
				array('option-size', 'option-colour'),
				array(
					array(
						'id' => 'option-colour-blue',
						'name' => 'option-colour-blue',
						'shop_option_id' => 'option-colour',
						'ShopPrice' => array(
							'id' => null,
							'selling' => null,
							'retail' => null,
						)
					),
					array(
						'id' => 'option-colour-red',
						'name' => 'option-colour-red',
						'shop_option_id' => 'option-colour',
						'ShopPrice' => array(
							'id' => null,
							'selling' => null,
							'retail' => null,
						)
					),
					array(
						'id' => 'option-size-large',
						'name' => 'option-size-large',
						'shop_option_id' => 'option-size',
						'ShopPrice' => array(
							'id' => 'option-value-large',
							'selling' => '3.00000',
							'retail' => '4.00000',
						)
					),
					array(
						'id' => 'option-size-medium',
						'name' => 'option-size-medium',
						'shop_option_id' => 'option-size',
						'ShopPrice' => array(
							'id' => null,
							'selling' => null,
							'retail' => null,
						)
					),
					array(
						'id' => 'option-size-small',
						'name' => 'option-size-small',
						'shop_option_id' => 'option-size',
						'ShopPrice' => array(
							'id' => null,
							'selling' => null,
							'retail' => null,
						)
					),
				)
			)
		);
	}

}
