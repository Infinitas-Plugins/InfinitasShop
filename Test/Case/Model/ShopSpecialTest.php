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
							'discount' => 10,
							'amount' => null,
							'start_date' => '2012-09-06 00:00:00',
							'end_date' => '2050-10-06 23:59:59',
							'ShopImage' => array(
								'id' => 'image-special-multi-option',
								'image' => 'image-special-multi-option.png'
							)
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
							'discount' => 10,
							'amount' => null,
							'start_date' => '2012-09-06 00:00:00',
							'end_date' => '2050-10-06 23:59:59',
							'ShopImage' => array(
								'id' => 'image-special-multi-option',
								'image' => 'image-special-multi-option.png'
							)
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
						'discount' => 10,
						'amount' => null,
						'start_date' => '2012-09-06 00:00:00',
						'end_date' => '2050-10-06 23:59:59',
						'ShopImage' => array(
							'id' => 'image-special-multi-option',
							'image' => 'image-special-multi-option.png'
						)
					)
				)
			),
			'many-products' => array(
				array('multi-option', 'active'),
				array(
					array(
						'id' => 'special-multi-option',
						'shop_product_id' => 'multi-option',
						'discount' => 10,
						'amount' => null,
						'start_date' => '2012-09-06 00:00:00',
						'end_date' => '2050-10-06 23:59:59',
						'ShopImage' => array(
							'id' => 'image-special-multi-option',
							'image' => 'image-special-multi-option.png'
						)
					)
				)
			)
		);
	}

}
