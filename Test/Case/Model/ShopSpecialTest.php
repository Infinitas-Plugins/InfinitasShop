<?php
App::uses('ShopSpecial', 'Shop.Model');

/**
 * ShopSpecial Test Case
 *
 */
class ShopSpecialTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.shop.shop_special',
		'plugin.shop.shop_products_special',
		'plugin.shop.shop_product',
		'plugin.shop.shop_image',
		'plugin.view_counter.view_counter_view',
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->ShopSpecial = ClassRegistry::init('Shop.ShopSpecial');
		$this->modelClass = $this->ShopSpecial->alias;
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->ShopSpecial);

		parent::tearDown();
	}

/**
 * @brief test validation pass
 *
 * @dataProvider validationPassDataProvider
 */
	public function testValidationPass($data, $expected) {
		$result = $this->{$this->modelClass}->save($data);
		$this->assertTrue((bool)$result);

		$result = $this->{$this->modelClass}->read(array('name', 'start_date', 'end_date'));
		$this->assertEquals(array($this->modelClass => $expected), $result);
	}

/**
 * @brief validation pass data provider
 * 
 * @return array
 */
	public function validationPassDataProvider() {
		return array(
			'not-empty-name' => array(
				array('name' => 'foo bar'),
				array(
					'name' => 'foo bar',
					'start_date' => '0000-00-00 00:00:00',
					'end_date' => '0000-00-00 00:00:00'
				)
			),
			'start-date' => array(
				array(
					'name' => 'foo bar',
					'start_date' => array(
						'year' => '2025',
						'month' => '01',
						'day' => '01',
						'hour' => '00',
						'min' => '00',
						'meridian' => 'am'
					)
				),
				array(
					'name' => 'foo bar',
					'start_date' => '2025-01-01 00:00:00',
					'end_date' => '0000-00-00 00:00:00'
				)
			),
			'end-date' => array(
				array(
					'end_date' => '2025-01-01 00:00:00',
					'name' => 'foo bar'
				),
				array(
					'name' => 'foo bar',
					'start_date' => '0000-00-00 00:00:00',
					'end_date' => '2025-01-01 00:00:00',
				)
			),
			'end-date' => array(
				array(
					'end_date' => '2025-01-01 00:00:00',
					'name' => 'foo bar'
				),
				array(
					'name' => 'foo bar',
					'start_date' => '0000-00-00 00:00:00',
					'end_date' => '2025-01-01 00:00:00',
				)
			),
			'both-dates' => array(
				array(
					'start_date' => '2025-01-01 00:00:00',
					'end_date' => '2025-01-01 00:00:01',
					'name' => 'foo bar'
				),
				array(
					'name' => 'foo bar',
					'start_date' => '2025-01-01 00:00:00',
					'end_date' => '2025-01-01 00:00:01'
				)
			),
			'start-is-in-the-past-update' => array(
				array(
					'id' => 'special-multi-option',
					'name' => 'foo bar',
					'start_date' => '2012-01-01 00:00:01',
				),
				array(
					'name' => 'foo bar',
					'start_date' => '2012-01-01 00:00:01',
					'end_date' => '2050-10-06 23:59:59'
				)
			)
		);
	}

/**
 * @brief test validation fails
 *
 * @dataProvider validationFailsDataProvider
 */
	public function testValidationFails($data, $expected) {
		$this->assertFalse($this->{$this->modelClass}->save($data));
		$result = $this->{$this->modelClass}->validationErrors[key($data)];
		$this->assertEquals($expected, $result);
	}

/**
 * @brief validation fails data provider
 * 
 * @return array
 */
	public function validationFailsDataProvider() {
		return array(
			'no-name' => array(
				array(
					'name' => null
				),
				array(
					'Please enter a name for this special'
				)
			),
			'already-named' => array(
				array(
					'name' => 'special-active-pending'
				),
				array(
					'The entered name has already been used'
				)
			),
			'start-date-invalid' => array(
				array(
					'start_date' => '2012'
				),
				array(
					'Start date is not valid'
				)
			),
			'start-date-after-end' => array(
				array(
					'end_date' => '2012-01-01 00:00:00',
					'start_date' => '2012-01-01 00:00:01',
				),
				array(
					'The end date should be after the start date'
				)
			),
			'start-is-in-the-past' => array(
				array(
					'start_date' => '2012-01-01 00:00:01',
				),
				array(
					'The start date should be in the future'
				)
			)
		);
	}

/**
 * @brief test find specials exception
 *
 * @expectedException InvalidArgumentException
 */
	public function testFindSpecialsException() {
		$this->{$this->modelClass}->find('specials');
	}

/**
 * @brief test find specials
 *
 * @dataProvider findSpecialsDataProvider
 */
	public function testFindSpecials($data, $expected) {
		$results = $this->{$this->modelClass}->find('specials', array('shop_product_id' => $data));
		$this->assertEquals($expected, $results);
	}

/**
 * @brief find specials data provider
 *
 * @return array
 */
	public function findSpecialsDataProvider() {
		return array(
			'special-not-active' => array(
				'active',
				array()
			),
			'active' => array(
				'multi-option',
				array(
					array(
						'ShopSpecial' => array(
							'id' => 'special-multi-option',
							'shop_product_id' => 'multi-option',
							'discount' => 1,
							'amount' => 10,
							'start_date' => '2012-09-06 00:00:00',
							'end_date' => '2050-10-06 23:59:59',
							'free_shipping' => false
						)
					)
				)
			),
			'many-products' => array(
				array('multi-option', 'active'),
				array(
					array(
						'ShopSpecial' => array(
							'id' => 'special-multi-option',
							'shop_product_id' => 'multi-option',
							'discount' => 1,
							'amount' => 10,
							'start_date' => '2012-09-06 00:00:00',
							'end_date' => '2050-10-06 23:59:59',
							'free_shipping' => false
						)
					)
				)
			)
		);
	}

/**
 * @brief test find specials
 *
 * @dataProvider findSpecialsExtractedDataProvider
 */
	public function testFindSpecialsExtracted($data, $expected) {
		$results = $this->{$this->modelClass}->find('specials', array('shop_product_id' => $data, 'extract' => true));
		$this->assertEquals($expected, $results);
	}

/**
 * @brief find specials data provider
 *
 * @return array
 */
	public function findSpecialsExtractedDataProvider() {
		return array(
			'special-not-active' => array(
				'active',
				array()
			),
			'special-active' => array(
				'multi-option',
				array(
					array(
						'id' => 'special-multi-option',
						'shop_product_id' => 'multi-option',
						'discount' => 1,
						'amount' => 10,
						'start_date' => '2012-09-06 00:00:00',
						'end_date' => '2050-10-06 23:59:59',
						'free_shipping' => false
					)
				)
			),
			'many-products' => array(
				array('multi-option', 'active'),
				array(
					array(
						'id' => 'special-multi-option',
						'shop_product_id' => 'multi-option',
						'discount' => 1,
						'amount' => 10,
						'start_date' => '2012-09-06 00:00:00',
						'end_date' => '2050-10-06 23:59:59',
						'free_shipping' => false
					)
				)
			)
		);
	}

}
