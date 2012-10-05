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
						'name' => 'Large',
						'shop_option_id' => 'option-size',
					),
					array(
						'id' => 'option-size-medium',
						'name' => 'Medium',
						'shop_option_id' => 'option-size',
					),
					array(
						'id' => 'option-size-small',
						'name' => 'Small',
						'shop_option_id' => 'option-size',
					),
				)
			),
			'colour' => array(
				'option-colour',
				array(
					array(
						'id' => 'option-colour-blue',
						'name' => 'Blue',
						'shop_option_id' => 'option-colour',
					),
					array(
						'id' => 'option-colour-red',
						'name' => 'Red',
						'shop_option_id' => 'option-colour',
					),
				)
			),
			'multiple' => array(
				array('option-size', 'option-colour'),
				array(
					array(
						'id' => 'option-colour-blue',
						'name' => 'Blue',
						'shop_option_id' => 'option-colour',
					),
					array(
						'id' => 'option-colour-red',
						'name' => 'Red',
						'shop_option_id' => 'option-colour',
					),
					array(
						'id' => 'option-size-large',
						'name' => 'Large',
						'shop_option_id' => 'option-size',
					),
					array(
						'id' => 'option-size-medium',
						'name' => 'Medium',
						'shop_option_id' => 'option-size',
					),
					array(
						'id' => 'option-size-small',
						'name' => 'Small',
						'shop_option_id' => 'option-size',
					),
				)
			)
		);
	}

}
