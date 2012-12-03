<?php
App::uses('ShopBrand', 'Shop.Model');

/**
 * ShopBrand Test Case
 *
 */
class ShopBrandTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.shop.shop_brand',
		'plugin.shop.shop_product',
		'plugin.shop.shop_price',
		'plugin.shop.shop_image',
		'plugin.shop.shop_supplier',
		'plugin.shop.shop_product_type',

		'plugin.view_counter.view_counter_view'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Model = ClassRegistry::init('Shop.ShopBrand');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Model);

		parent::tearDown();
	}

/**
 * test find brands
 */
	public function testFindBrands() {
		$expeceted = array(
			array('ShopBrand' => array(
				'id' => 'inhouse',
				'name' => 'inhouse',
				'slug' => 'inhouse',
				'image_medium' => '/files/shop_brand/image/inhouse/medium_inhouse.png',
				'image_thumb' => '/files/shop_brand/image/inhouse/thumb_inhouse.png',
			)),
			array('ShopBrand' => array(
				'id' => 'other',
				'name' => 'other',
				'slug' => 'other',
				'image_medium' => '/filemanager/img/no-image.png',
				'image_thumb' => '/filemanager/img/no-image.png',
			))
		);
		$result = $this->Model->find('brands');
		$this->assertEquals($expeceted, $result);
	}

/**
 * test counter cache
 */
	public function testCounterCache() {
		$conditions = array(
			'fields' => array(
				$this->Model->alias . '.' . $this->Model->primaryKey,
				$this->Model->alias . '.shop_product_count'
			)
		);

		$save = $this->Model->ShopProduct->save(array(
			'id' => 'active',
			'name' => 'active',
			'description' => 'active',
			'shop_brand_id' => 'other'
		));

		$expected = array(
			'inhouse' => 9,
			'other' => 1
		);
		$result = $this->Model->find('list', $conditions);
		$this->assertEquals($expected, $result);
	}
}
