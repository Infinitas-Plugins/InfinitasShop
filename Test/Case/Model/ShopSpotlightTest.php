<?php
App::uses('ShopSpotlight', 'Shop.Model');

/**
 * ShopSpotlight Test Case
 *
 */
class ShopSpotlightTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.shop.shop_spotlight',
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
		$this->ShopSpotlight = ClassRegistry::init('Shop.ShopSpotlight');
		$this->modelClass = $this->ShopSpotlight->alias;
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->ShopSpotlight);

		parent::tearDown();
	}

/**
 * @brief test find spotlights exception
 *
 * @expectedException InvalidArgumentException
 */
	public function testFindSpotlightsException() {
		$this->{$this->modelClass}->find('spotlights');
	}

/**
 * @brief test find spotlights
 *
 * @dataProvider findSpotlightsDataProvider
 */
	public function testFindSpotlights($data, $expected) {
		$results = $this->{$this->modelClass}->find('spotlights', array('shop_product_id' => $data));
		$this->assertEquals($expected, $results);
	}

/**
 * @brief find specials data provider
 *
 * @return array
 */
	public function findSpotlightsDataProvider() {
		return array(
			'spotlights-not-active' => array(
				'active',
				array()
			),
			'active' => array(
				'multi-option',
				array(
					array(
						'ShopSpotlight' => array(
							'id' => 'spotlight-multi-option',
							'shop_product_id' => 'multi-option',
							'start_date' => '2012-09-06 00:00:00',
							'end_date' => '2050-10-06 23:59:59',
						)
					)
				)
			),
			'many-products' => array(
				array('multi-option', 'active'),
				array(
					array(
						'ShopSpotlight' => array(
							'id' => 'spotlight-multi-option',
							'shop_product_id' => 'multi-option',
							'start_date' => '2012-09-06 00:00:00',
							'end_date' => '2050-10-06 23:59:59',
						)
					)
				)
			)
		);
	}

/**
 * @brief test find spotlights
 *
 * @dataProvider findSpotlightsExtractedDataProvider
 */
	public function testFindSpotlightsExtracted($data, $expected) {
		$results = $this->{$this->modelClass}->find('spotlights', array('shop_product_id' => $data, 'extract' => true));
		$this->assertEquals($expected, $results);
	}

/**
 * @brief find specials data provider
 *
 * @return array
 */
	public function findSpotlightsExtractedDataProvider() {
		return array(
			'spotlights-not-active' => array(
				'active',
				array()
			),
			'active' => array(
				'multi-option',
				array(
					array(
						'id' => 'spotlight-multi-option',
						'shop_product_id' => 'multi-option',
						'start_date' => '2012-09-06 00:00:00',
						'end_date' => '2050-10-06 23:59:59',
					)
				)
			),
			'many-products' => array(
				array('multi-option', 'active'),
				array(
					array(
						'id' => 'spotlight-multi-option',
						'shop_product_id' => 'multi-option',
						'start_date' => '2012-09-06 00:00:00',
						'end_date' => '2050-10-06 23:59:59',
					)
				)
			)
		);
	}

}
