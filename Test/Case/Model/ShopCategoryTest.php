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
		'plugin.shop.shop_image',
		'plugin.shop.shop_product_type'
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
 * test exception with no params
 *
 * @expectedException InvalidArgumentException
 *
 * @dataProvider findRelatedExceptionDataProvider
 */
	public function testFindRelatedException($data) {
		$this->{$this->modelClass}->find('related', $data);
	}

/**
 * find related exception data provider
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
 * test find related
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
 * find related data provider
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
 * test the extract works
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

/**
 * Test get path by slug
 */
	public function testGetPath() {
		$expected = array(
			'inactive',
			'inactive-parent'
		);

		$result = $this->{$this->modelClass}->getPath('inactive-parent');
		$this->assertEquals($expected, Hash::extract($result, '{n}.ShopCategory.id'));

		$this->{$this->modelClass}->id = 'inactive-parent';
		$this->assertTrue($this->{$this->modelClass}->saveField('slug', 'super-awesome-slug'));

		$result = $this->{$this->modelClass}->getPath('super-awesome-slug');
		$this->assertEquals($expected, Hash::extract($result, '{n}.ShopCategory.id'));
	}

/**
 * test after save
 */
	public function testAfterSave() {
		$this->{$this->modelClass}->create();
		$saved = (bool)$this->{$this->modelClass}->save(array(
			'parent_id' => 'inactive-parent',
			'name' => 'new'
		));
		$this->assertTrue($saved);

		$result = $this->{$this->modelClass}->field('path_depth', array(
			'ShopCategory.id' => $this->{$this->modelClass}->id
		));
		$this->assertEquals(2, $result);
	}

/**
 * test find level
 *
 * @dataProvider findLevelDataProvider
 */
	public function testFindLevel($data, $expected) {
		if ($data) {
			$this->{$this->modelClass}->updateAll(array(
				'ShopCategory.active' => 1
			));
		}
		$result = $this->{$this->modelClass}->find('level', $data);
		$this->assertEquals($expected, $result);
	}

/**
 * find level data provider
 */
	public function findLevelDataProvider() {
		return array(
			'top-level' => array(
				null,
				array(
					array(
						'ShopCategory' => array(
							'id' => 'active',
							'name' => 'active',
							'slug' => 'active',
							'parent_id' => NULL,
							'lft' => '1',
							'rght' => '2',
						),
						'ShopImage' => array(
							'id' => NULL,
							'image' => NULL,
							'image_full' => '/filemanager/img/no-image.png',
							'image_large' => '/filemanager/img/no-image.png',
							'image_medium' => '/filemanager/img/no-image.png',
							'image_small' => '/filemanager/img/no-image.png',
							'image_thumb' => '/filemanager/img/no-image.png',
						)
					),
					array(
						'ShopCategory' => array(
							'id' => 'another',
							'name' => 'another',
							'slug' => 'another',
							'parent_id' => NULL,
							'lft' => '7',
							'rght' => '8',
						),
						'ShopImage' => array(
							'id' => NULL,
							'image' => NULL,
							'image_full' => '/filemanager/img/no-image.png',
							'image_large' => '/filemanager/img/no-image.png',
							'image_medium' => '/filemanager/img/no-image.png',
							'image_small' => '/filemanager/img/no-image.png',
							'image_thumb' => '/filemanager/img/no-image.png',
						)
					),
				)
			),
			'inactive' => array(
				'inactive',
				array(
					array(
						'ShopCategory' => array(
							'id' => 'inactive-parent',
							'name' => 'inactive-parent',
							'slug' => 'inactive-parent',
							'parent_id' => 'inactive',
							'lft' => '4',
							'rght' => '5',
						),
						'ShopImage' => array(
							'id' => NULL,
							'image' => NULL,
							'image_full' => '/filemanager/img/no-image.png',
							'image_large' => '/filemanager/img/no-image.png',
							'image_medium' => '/filemanager/img/no-image.png',
							'image_small' => '/filemanager/img/no-image.png',
							'image_thumb' => '/filemanager/img/no-image.png',
						)
					),
				)
			)
		);
	}

/**
 * test find current
 *
 * @dataProvider findCurrentDataProvider
 */
	public function testFindCurrent($data, $expected) {		
		$result = $this->{$this->modelClass}->find('current', $data);
		$this->assertEquals($expected, $result['ShopCategory']);
	}

	public function findCurrentDataProvider() {
		return array(
			'fake' => array(
				'fake',
				null
			),
			'active' => array(
				'active',
				array(
					'id' => 'active',
					'name' => 'active',
					'slug' => 'active',
					'description' => 'Normal active category'
				)
			)
		);
	}

/**
 * test find parent
 *
 * @dataProvider findParentDataProvider
 */
	public function testFindParent($data, $expected) {
		$this->{$this->modelClass}->updateAll(array(
			'ShopCategory.active' => 1
		));

		$result = $this->{$this->modelClass}->find('parent', $data);
		$this->assertEquals($expected, $result['ShopCategory']);
	}

	public function findParentDataProvider() {
		return array(
			'fake' => array(
				'fake',
				null
			),
			'active' => array(
				'active',
				null
			),
			'inactive-parent' => array(
				'inactive-parent',
				array(
					'id' => 'inactive',
					'name' => 'Parent Category',
					'slug' => 'inactive'
				)
			)
		);
	}

/**
 * test find single category exception
 *
 * @expectedException InvalidArgumentException
 */
	public function testFindSingleCategoryException() {
		$this->{$this->modelClass}->find('parent');
	}

}
