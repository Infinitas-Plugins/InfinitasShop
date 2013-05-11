<?php
App::uses('SpecialsBehavior', 'Shop.Model/Behavior');
App::uses('ShopProduct', 'Shop.Model');

/**
 * SpecialsBehavior Test Case
 *
 */
class SpecialsBehaviorTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.shop.shop_product',
		'plugin.shop.shop_price',
		'plugin.shop.shop_products_special',
		'plugin.view_counter.view_counter_view'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->ShopProduct = ClassRegistry::init('Shop.ShopProduct');
		$this->ShopProduct->Behaviors->attach('Shop.Specials');

		$this->modelClass = $this->ShopProduct->alias;
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->ShopProduct);

		parent::tearDown();
	}

/**
 * test behavior attached
 */
	public function testBeavhiorAttached() {
		$this->assertTrue($this->{$this->modelClass}->findMethods['possibleSpecials']);
	}

/**
 * test find possible specials
 */
	public function testFindPossibleSpecials() {
		$this->markTestIncomplete();

		$expected = array(
			array(
				'ShopProduct' => array(
					'id' => 'multi-category-mixed-state',
					'name' => 'multi-category-mixed-state',
					'markup_percentage' => '9.091',
					'conversion_rate' => '5.00'
				),
				'ShopPrice' => array(
					'cost' => '11.00000',
					'selling' => '12.0000'
				)
			)
		);
		$result = $this->{$this->modelClass}->find('possibleSpecials');
		$this->assertEquals($expected, $result);

		$this->{$this->modelClass}->id = 'multi-category-parent-inactive';
		$this->{$this->modelClass}->saveField('views', 100);

		$expected = array(
			array(
				'ShopProduct' => array(
					'id' => 'multi-category-parent-inactive',
					'name' => 'multi-category-parent-inactive',
					'markup_percentage' => '9.091',
					'conversion_rate' => '1.00'
				),
				'ShopPrice' => array(
					'cost' => '11.00000',
					'selling' => '12.0000'
				)
			),
			array(
				'ShopProduct' => array(
					'id' => 'multi-category-mixed-state',
					'name' => 'multi-category-mixed-state',
					'markup_percentage' => '9.091',
					'conversion_rate' => '5.000'
				),
				'ShopPrice' => array(
					'cost' => '11.00000',
					'selling' => '12.0000'
				)
			)
		);
		$result = $this->{$this->modelClass}->find('possibleSpecials');
		$this->assertEquals($expected, $result);
	}
}