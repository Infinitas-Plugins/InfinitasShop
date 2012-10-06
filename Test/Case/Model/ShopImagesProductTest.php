<?php
App::uses('ShopImagesProduct', 'Shop.Model');

/**
 * ShopImagesProduct Test Case
 *
 */
class ShopImagesProductTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.shop.shop_images_product',
		'plugin.shop.shop_image',
		'plugin.shop.shop_product',
		'plugin.view_counter.view_counter_view'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->ShopImagesProduct = ClassRegistry::init('Shop.ShopImagesProduct');
		$this->modelClass = $this->ShopImagesProduct->alias;
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->ShopImagesProduct);

		parent::tearDown();
	}

/**
 * @brief test find images exceptions
 *
 * @expectedException InvalidArgumentException
 */
	public function testFindImagesException() {
		$this->{$this->modelClass}->find('images');
	}

/**
 * @brief test find images
 *
 * @param type $data
 * @param type $exception
 *
 * @dataProvider findImagesDataProvider
 */
	public function testFindImages($data, $expected) {
		$results = $this->{$this->modelClass}->find('images', array('shop_product_id' => $data));
		$this->assertEquals($expected, $results);
	}

/**
 * @brief find images data provider
 *
 * @return array
 */
	public function findImagesDataProvider() {
		return array(
			'made-up' => array(
				'made-up',
				array()
			),
			'active' => array(
				'active',
				array(
					array(
						'ShopImage' => array(
							'id' => 'shared-image-1',
							'image' => 'shared-image-1.png',
							'shop_product_id' => 'active'
						)
					),
					array(
						'ShopImage' => array(
							'id' => 'shared-image-2',
							'image' => 'shared-image-2.png',
							'shop_product_id' => 'active'
						)
					)
				)
			),
			'multi-category' => array(
				'multi-category',
				array(
					array(
						'ShopImage' => array(
							'id' => 'shared-image-2',
							'image' => 'shared-image-2.png',
							'shop_product_id' => 'multi-category'
						)
					)
				)
			),
			'many-products' => array(
				array('multi-category', 'active'),
				array(
					array(
						'ShopImage' => array(
							'id' => 'shared-image-1',
							'image' => 'shared-image-1.png',
							'shop_product_id' => 'active'
						)
					),
					array(
						'ShopImage' => array(
							'id' => 'shared-image-2',
							'image' => 'shared-image-2.png',
							'shop_product_id' => 'active'
						)
					),
					array(
						'ShopImage' => array(
							'id' => 'shared-image-2',
							'image' => 'shared-image-2.png',
							'shop_product_id' => 'multi-category'
						)
					)
				)
			)
		);
	}

/**
 * @brief test find images extracted
 *
 * @param type $data
 * @param type $exception
 *
 * @dataProvider findImagesExtractedDataProvider
 */
	public function testFindImagesExtracted($data, $expected) {
		$results = $this->{$this->modelClass}->find('images', array('shop_product_id' => $data, 'extract' => true));
		$this->assertEquals($expected, $results);
	}

/**
 * @brief find images extracted data provider
 *
 * @return array
 */
	public function findImagesExtractedDataProvider() {
		return array(
			'made-up' => array(
				'made-up',
				array()
			),
			'active' => array(
				'active',
				array(
					array(
						'id' => 'shared-image-1',
						'image' => 'shared-image-1.png',
						'shop_product_id' => 'active'
					),
					array(
						'id' => 'shared-image-2',
						'image' => 'shared-image-2.png',
						'shop_product_id' => 'active'
					)
				)
			),
			'multi-category' => array(
				'multi-category',
				array(
					array(
						'id' => 'shared-image-2',
						'image' => 'shared-image-2.png',
						'shop_product_id' => 'multi-category'
					)
				)
			),
			'many-products' => array(
				array('multi-category', 'active'),
				array(
					array(
						'id' => 'shared-image-1',
						'image' => 'shared-image-1.png',
						'shop_product_id' => 'active'
					),
					array(
						'id' => 'shared-image-2',
						'image' => 'shared-image-2.png',
						'shop_product_id' => 'active'
					),
					array(
						'id' => 'shared-image-2',
						'image' => 'shared-image-2.png',
						'shop_product_id' => 'multi-category'
					)
				)
			)
		);
	}

}
