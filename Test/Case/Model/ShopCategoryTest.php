<?php
App::uses('ShopCategory', 'Shop.Model');

/**
 * ShopCategory Test Case
 *
 */
class ShopCategoryTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.shop.shop_category',
		'plugin.shop.shop_categories_product',
		'plugin.shop.shop_image'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->ShopCategory = ClassRegistry::init('Shop.ShopCategory');
		$this->modelClass = $this->ShopCategory->alias;
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->ShopCategory);

		parent::tearDown();
	}

/**
 * @brief test exception with no params
 *
 * @expectedException InvalidArgumentException
 *
 * @dataProvider findRelatedExceptionDataProvider
 */
	public function testFindRelatedException($data) {
		$this->{$this->modelClass}->find('related', $data);
	}

/**
 * @brief find related exception data provider
 */
	public function findRelatedExceptionDataProvider() {
		return array(
			array(null),
			array(
				array('foo' => 'bar')
			),
			array(
				array('fields' => array('foo', 'bar'), 'conditions' => array())
			)
		);
	}

/**
 * @brief test find related
 *
 * @param type $data
 * @param type $expected
 *
 * @dataProvider findRelatedDataProvider
 */
	public function testFindRelated($data, $expected) {
		$result = $this->{$this->modelClass}->find('related', $data);
		$this->assertEquals($expected, $result);
	}

/**
 * @brief find related data provider
 *
 * @return array
 */
	public function findRelatedDataProvider() {
		return array(
			'normal' => array(
				array('shop_product_id' => 'active'),
				array(array(
					'ShopCategory' => array(
						'id' => 'active',
						'name' => 'active',
						'slug' => 'active',
						'shop_product_id' => 'active'
					)
				))
			),
			'inactive' => array(
				array('shop_product_id' => 'inactive'),
				array(array(
					'ShopCategory' => array(
						'id' => 'active',
						'name' => 'active',
						'slug' => 'active',
						'shop_product_id' => 'inactive'
					)
				))
			),
			'multi-category' => array(
				array('shop_product_id' => 'multi-category'),
				array(array(
					'ShopCategory' => array(
						'id' => 'active',
						'name' => 'active',
						'slug' => 'active',
						'shop_product_id' => 'multi-category'
					)
				), array(
					'ShopCategory' => array(
						'id' => 'another',
						'name' => 'another',
						'slug' => 'another',
						'shop_product_id' => 'multi-category'
					)
				))
			),
			'mixed-state' => array(
				array('shop_product_id' => 'multi-category-parent-inactive'),
				array(array(
					'ShopCategory' => array(
						'id' => 'active',
						'name' => 'active',
						'slug' => 'active',
						'shop_product_id' => 'multi-category-parent-inactive'
					)
				))
			),
			'normal-conditions' => array(
				array('conditions' => array('ShopCategoriesProduct.shop_product_id' => 'active')),
				array(array(
					'ShopCategory' => array(
						'id' => 'active',
						'name' => 'active',
						'slug' => 'active',
						'shop_product_id' => 'active'
					)
				))
			),
		);
	}

/**
 * @brief test the extract works
 */
	public function testFindRelatedExtract() {
		$expected = array(array(
			'id' => 'active',
			'name' => 'active',
			'slug' => 'active',
			'shop_product_id' => 'multi-category'
		), array(
			'id' => 'another',
			'name' => 'another',
			'slug' => 'another',
			'shop_product_id' => 'multi-category'
		));

		$result = $this->{$this->modelClass}->find('related', array(
			'shop_product_id' => 'multi-category',
			'extract' => true
		));
		$this->assertEquals($expected, $result);
	}

}
