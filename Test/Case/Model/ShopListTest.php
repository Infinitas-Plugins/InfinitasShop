<?php
App::uses('ShopList', 'Shop.Model');
App::uses('CakeSession', 'Model/Datasource');

/**
 * ShopList Test Case
 *
 */
class ShopListTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.shop.shop_list',
		'plugin.shop.core_user',
		'plugin.shop.core_group',
		'plugin.shop.shop_shipping_method',
		'plugin.shop.shop_payment_method',
		'plugin.shop.shop_list_product_option',
		'plugin.shop.shop_list_product',
		'plugin.shop.shop_product',
		'plugin.shop.shop_product_type',
		'plugin.shop.shop_price',
		'plugin.shop.shop_image',

		'plugin.management.ticket',
		'plugin.view_counter.view_counter_view'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->ShopList = ClassRegistry::init('Shop.ShopList');
		$this->modelClass = $this->ShopList->alias;
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->ShopList);
		CakeSession::destroy();

		parent::tearDown();
	}

/**
 * @brief test validate user id
 *
 * @param type $data
 * @param type $expected
 *
 * @dataProvider validateUserIdDataProvider
 */
	public function testValidateUserId($data, $expected) {
		$this->setupSession(array(
			'user_id' => $data['user_id'],
			'guest_id' => $data['guest_id']
		));

		$result = $this->{$this->modelClass}->validateUserId(array('user_id' => $data[$data['the_user']]));
		$this->assertEquals($expected, $result);
	}

/**
 * @brief validate user id data provider
 *
 * @return array
 */
	public function validateUserIdDataProvider() {
		return array(
			'empty_user' => array(
				array(
					'user_id' => null,
					'guest_id' => null,
					'the_user' => 'user_id'
				),
				false
			),
			'empty_guest' => array(
				array(
					'user_id' => null,
					'guest_id' => null,
					'the_user' => 'guest_id'
				),
				false
			),
			'guest' => array(
				array(
					'user_id' => null,
					'guest_id' => 'guest-1',
					'the_user' => 'guest_id'
				),
				true
			),
			'user' => array(
				array(
					'user_id' => 'bob',
					'guest_id' => null,
					'the_user' => 'user_id'
				),
				true
			)
		);
	}

/**
 * @brief set the session data for a test
 *
 * @param array $data data
 */
	public function setupSession(array $data) {
		if(isset($data['list_id'])) {
			CakeSession::write('Shop.current_list', $data['list_id']);
		}
		if(isset($data['user_id'])) {
			CakeSession::write('Auth.User.id', $data['user_id']);
		}
		if(isset($data['guest_id'])) {
			CakeSession::write('Shop.Guest.id', $data['guest_id']);
		}
	}

/**
 * @brief test current list id
 *
 * @dataProvider currentListIdDataProvider
 */
	public function testCurrentListIdList($data, $expected) {
		$this->setupSession($data);

		$results = $this->{$this->modelClass}->currentListId($data['create']);
		if($data['create'] && $data['user_id'] != 'bob') {
			$this->assertTrue(strlen($results) == 36, 'Failed to create the list');
		} else {
			$this->assertEquals($expected, $results);
		}
	}

/**
 * current list data provider
 *
 * @return array
 */
	public function currentListIdDataProvider() {
		return array(
			'nothing' => array(
				array(
					'list_id' => null,
					'user_id' => null,
					'guest_id' => null,
					'create' => false
				),
				false
			),
			'guest-1' => array(
				array(
					'list_id' => null,
					'user_id' => null,
					'guest_id' => 'guest-1',
					'create' => false
				),
				'shop-list-guest-1-cart'
			),
			'bob-cart' => array(
				array(
					'list_id' => null,
					'user_id' => 'bob',
					'guest_id' => null,
					'create' => false
				),
				'shop-list-bob-cart'
			),
			'bob-cart-wont-create' => array(
				array(
					'list_id' => null,
					'user_id' => 'bob',
					'guest_id' => null,
					'create' => true
				),
				'shop-list-bob-cart'
			),
			'bob-cart-changed-current' => array(
				array(
					'list_id' => 'shop-list-bob-wish',
					'user_id' => 'bob',
					'guest_id' => null,
					'create' => false
				),
				'shop-list-bob-wish'
			),
			'bob-cart-changed-current-wont-create' => array(
				array(
					'list_id' => 'shop-list-bob-wish',
					'user_id' => 'bob',
					'guest_id' => null,
					'create' => true
				),
				'shop-list-bob-wish'
			),
			'different-user' => array(
				array(
					'list_id' => null,
					'user_id' => 'sally',
					'guest_id' => null,
					'create' => false
				),
				'shop-list-sally-cart'
			),
			'create' => array(
				array(
					'list_id' => null,
					'user_id' => null,
					'guest_id' => 'guest-2',
					'create' => true
				),
				true
			),
		);
	}

/**
 * @brief test set current list exception
 *
 * @param type $data
 * @param type $expected
 *
 * @expectedException InvalidArgumentException
 *
 * @dataProvider setCurrentListException
 */
	public function testSetCurrentListException($data) {
		$this->setupSession($data);

		$this->{$this->modelClass}->setCurrentList($data['list_id']);
	}

/**
 * @brief test set current list exception
 *
 * @return array
 */
	public function setCurrentListException() {
		return array(
			'nothing' => array(array(
				'user_id' => null,
				'guest_id' => null,
				'list_id' => null,
			)),
			'non-user' => array(array(
				'user_id' => 'non-user',
				'guest_id' => null,
				'list_id' => null,
			)),
			'guest-1-no-list' => array(array(
				'user_id' => null,
				'guest_id' => 'guest-1',
				'list_id' => null,
			)),
			'bob-no-list' => array(array(
				'user_id' => 'bob',
				'guest_id' => null,
				'list_id' => null,
			)),
			'cross-contamination-user' => array(array(
				'user_id' => null,
				'guest_id' => 'guest-1',
				'list_id' => 'shop-list-bob-wish',
			)),
			'cross-contamination-guest' => array(array(
				'user_id' => 'bob',
				'guest_id' => null,
				'list_id' => 'shop-list-guest-1-cart',
			))
		);
	}

/**
 * @brief test set current list
 *
 * @param type $data
 * @param type $expected
 *
 * @dataProvider setCurrentListDataProvider
 */
	public function testSetCurrentList($data) {
		$this->setupSession(array(
			'user_id' => $data['user_id'],
			'guest_id' => $data['guest_id'],
		));

		$result = $this->{$this->modelClass}->setCurrentList($data['list_id']);
		$this->assertEquals($data['list_id'], $result);
	}

/**
 * @brief set current list data provider
 *
 * @return array
 */
	public function setCurrentListDataProvider() {
		return array(
			'bob-wish' => array(array(
				'user_id' => 'bob',
				'guest_id' => null,
				'list_id' => 'shop-list-bob-wish'
			)),
			'bob-cart' => array(array(
				'user_id' => 'bob',
				'guest_id' => null,
				'list_id' => 'shop-list-bob-cart'
			)),
			'guest-1-cart' => array(array(
				'user_id' => null,
				'guest_id' => 'guest-1',
				'list_id' => 'shop-list-guest-1-cart'
			))
		);
	}

/**
 * @brief test create list
 *
 * @param type $data
 * @param type $expected
 *
 * @dataProvider createListDataProvider
 */
	public function testCreateList($data, $expected) {
		$this->setupSession(array(
			'user_id' => $data['session']['user_id'],
			'guest_id' => $data['session']['guest_id'],
		));
		$result = $this->{$this->modelClass}->createList($data['data']);

		if(!$expected) {
			$this->assertFalse($result);
		} else {
			$this->assertEquals(array(), $this->{$this->modelClass}->validationErrors);
			$this->assertTrue(strlen($result) === 36);

			if(!empty($data['data']['name'])) {
				$this->assertEquals($data['data']['name'], $this->{$this->modelClass}->field('name', array(
					$this->modelClass . '.' . $this->{$this->modelClass}->primaryKey => $this->{$this->modelClass}->id
				)));
			}
		}
	}

/**
 * @brief create list data provider
 */
	public function createListDataProvider() {
		return array(
			'wont-create' => array(
				array(
					'session' => array(
						'user_id' => null,
						'guest_id' => null
					),
					'data' => array(

					)
				),
				false
			),
			'guest-default' => array(
				array(
					'session' => array(
						'user_id' => null,
						'guest_id' => 'guest-1'
					),
					'data' => array(

					)
				),
				true
			),
			'guest-custom' => array(
				array(
					'session' => array(
						'user_id' => null,
						'guest_id' => 'guest-1'
					),
					'data' => array(
						'name' => 'Guest Custom'
					)
				),
				true
			),
			'user-default' => array(
				array(
					'session' => array(
						'user_id' => 'bob',
						'guest_id' => null
					),
					'data' => array(

					)
				),
				true
			),
			'user-custom' => array(
				array(
					'session' => array(
						'user_id' => 'bob',
						'guest_id' => null
					),
					'data' => array(
						'name' => 'User custom'
					)
				),
				true
			)
		);
	}

/**
 * @brief test find has list
 *
 * @dataProvider findHasListDataProvider
 */
	public function testFindHasList($data, $expected) {
		foreach($data as $k => $v) {
			CakeSession::write($k, $v);
			$this->assertEquals($v, CakeSession::read($k));
		}

		$result = $this->{$this->modelClass}->find('hasList');
		$this->assertEquals($expected, $result);
	}

/**
 * @brief find has list data provider
 *
 * @return array
 */
	public function findHasListDataProvider() {
		return array(
			'no-user-available' => array(
				array(),
				false
			),
			'guest-account-non-existant' => array(
				array('Shop.Guest.id' => 'guest-2'),
				false
			),
			'guest-account' => array(
				array('Shop.Guest.id' => 'guest-1'),
				true
			),
			'user-account' => array(
				array('Auth.User.id' => 'sally'),
				true
			),
			'multi-lists' => array(
				array('Auth.User.id' => 'bob'),
				true
			),
			'user-account-with-guest-details' => array(
				array(
					'Shop.Guest.id' => 'guest-1',
					'Auth.User.id' => 'bob'
				),
				true
			),
		);
	}

/**
 * @brief test find list details
 *
 * @param type $data
 * @param type $expected
 *
 * @dataProvider findListDetailsDataProvider
 */
	public function testFindListDetails($data, $expected) {
		$this->setupSession(array(
			'user_id' => $data['user_id'],
			'guest_id' => $data['guest_id']
		));

		if($expected) {
			$expected = array_merge(
				array(
					'ShopPaymentMethod' => array(
						'id' => null,
						'name' => null
					),
					'ShopShippingMethod' => array(
						'id' => null,
						'name' => null
					),
					'ShopListProduct' => array()
				),
				$expected
			);
		}
		$result = $this->{$this->modelClass}->find('listDetails', array(
			'shop_list_id' => $data['shop_list_id']
		));

		$this->assertEquals($expected, $result);
	}

/**
 * @brief find list details data provider
 *
 * @return array
 */
	public function findListDetailsDataProvider() {
		return array(
			'empty' => array(
				array(
					'user_id' => null,
					'guest_id' => null,
					'shop_list_id' => null
				),
				array()
			),
			'guest-1' => array(
				array(
					'user_id' => null,
					'guest_id' => 'guest-1',
					'shop_list_id' => null
				),
				array(
					'ShopList' => array(
						'id' => 'shop-list-guest-1-cart',
						'name' => 'shop-list-guest-1-cart',
						'user_id' => 'guest-1'
					),
					'User' => array(
						'id' => 'guest-1',
						'username' => 'Guest'
					),
					'ShopListProduct' => array(
						array(
							'id' => 'shop-list-guest-1',
							'shop_list_id' => 'shop-list-guest-1-cart',
							'shop_product_id' => 'multi-category',
							'quantity' => '3.00000',
							'base_price' => '6.00000',
							'created' => '2012-10-09 01:32:27',
							'modified' => '2012-10-09 01:32:27',
							'ShopProduct' => array(
								'id' => 'multi-category',
								'name' => 'multi-category',
								'slug' => 'multi-category',
								'ShopImage' => array(
									'id' => null,
									'image' => null,
								),
								'ShopProductType' => array(
									'id' => null,
									'name' => null,
								)
							)
						)
					)
				)
			),
			'bob-default' => array(
				array(
					'user_id' => 'bob',
					'guest_id' => null,
					'shop_list_id' => null
				),
				array(
					'ShopList' => array(
						'id' => 'shop-list-bob-cart',
						'name' => 'shop-list-bob-cart',
						'user_id' => 'bob'
					),
					'User' => array(
						'id' => 'bob',
						'username' => 'bob'
					),
					'ShopPaymentMethod' => array(
						'id' => 'paypal',
						'name' => 'paypal'
					),
					'ShopShippingMethod' => array(
						'id' => 'royal-mail-1st',
						'name' => 'royal-mail-1st'
					),
					'ShopListProduct' => array(
						array(
							'id' => 'shop-list-bob-cart-active',
							'shop_list_id' => 'shop-list-bob-cart',
							'shop_product_id' => 'active',
							'quantity' => '1.00000',
							'base_price' => '12.00000',
							'created' => '2012-10-09 01:32:27',
							'modified' => '2012-10-09 01:32:27',
							'ShopProduct' => array(
								'id' => 'active',
								'name' => 'active',
								'slug' => 'active',
								'ShopImage' => array(
									'id' => 'image-product-active',
									'image' => 'image-product-active.png',
								),
								'ShopProductType' => array(
									'id' => 'shirts',
									'name' => 'shirts',
								)
							)
						),
						array(
							'id' => 'shop-list-bob-cart-multi-option',
							'shop_list_id' => 'shop-list-bob-cart',
							'shop_product_id' => 'multi-option',
							'quantity' => '1.00000',
							'base_price' => '25.00000',
							'created' => '2012-10-09 01:32:27',
							'modified' => '2012-10-09 01:32:27',
							'ShopProduct' => array(
								'id' => 'multi-option',
								'name' => 'multi-option',
								'slug' => 'multi-option',
								'ShopImage' => array(
									'id' => 'image-product-multi-option',
									'image' => 'image-product-multi-option.png',
								),
								'ShopProductType' => array(
									'id' => 'complex-options',
									'name' => 'complex-options',
								)
							)
						)
					)
				)
			),
			'bob-wish' => array(
				array(
					'user_id' => 'bob',
					'guest_id' => null,
					'shop_list_id' => 'shop-list-bob-wish'
				),
				array(
					'ShopList' => array(
						'id' => 'shop-list-bob-wish',
						'name' => 'shop-list-bob-wish',
						'user_id' => 'bob'
					),
					'User' => array(
						'id' => 'bob',
						'username' => 'bob'
					)
				)
			),
			'sally' => array(
				array(
					'user_id' => 'sally',
					'guest_id' => null,
					'shop_list_id' => 'shop-list-sally-cart'
				),
				array(
					'ShopList' => array(
						'id' => 'shop-list-sally-cart',
						'name' => 'shop-list-sally-cart',
						'user_id' => 'sally'
					),
					'User' => array(
						'id' => 'sally',
						'username' => 'sally'
					),
					'ShopPaymentMethod' => array(
						'id' => 'cc',
						'name' => 'cc'
					),
					'ShopShippingMethod' => array(
						'id' => 'royal-mail-2nd',
						'name' => 'royal-mail-2nd'
					),
					'ShopListProduct' => array(
						array(
							'id' => 'shop-list-sally',
							'shop_list_id' => 'shop-list-sally-cart',
							'shop_product_id' => 'multi-option',
							'quantity' => '10.00000',
							'base_price' => '25.00000',
							'created' => '2012-10-09 01:32:27',
							'modified' => '2012-10-09 01:32:27',
							'ShopProduct' => array(
								'id' => 'multi-option',
								'name' => 'multi-option',
								'slug' => 'multi-option',
								'ShopImage' => array(
									'id' => 'image-product-multi-option',
									'image' => 'image-product-multi-option.png',
								),
								'ShopProductType' => array(
									'id' => 'complex-options',
									'name' => 'complex-options',
								)
							)
						)
					)
				)
			),
			'mixed' => array(
				array(
					'user_id' => 'sally',
					'guest_id' => 'guest-1',
					'shop_list_id' => 'shop-list-sally-cart'
				),
				array(
					'ShopList' => array(
						'id' => 'shop-list-sally-cart',
						'name' => 'shop-list-sally-cart',
						'user_id' => 'sally'
					),
					'User' => array(
						'id' => 'sally',
						'username' => 'sally'
					),
					'ShopPaymentMethod' => array(
						'id' => 'cc',
						'name' => 'cc'
					),
					'ShopShippingMethod' => array(
						'id' => 'royal-mail-2nd',
						'name' => 'royal-mail-2nd'
					),
					'ShopListProduct' => array(
						array(
							'id' => 'shop-list-sally',
							'shop_list_id' => 'shop-list-sally-cart',
							'shop_product_id' => 'multi-option',
							'quantity' => '10.00000',
							'base_price' => '25.00000',
							'created' => '2012-10-09 01:32:27',
							'modified' => '2012-10-09 01:32:27',
							'ShopProduct' => array(
								'id' => 'multi-option',
								'name' => 'multi-option',
								'slug' => 'multi-option',
								'ShopImage' => array(
									'id' => 'image-product-multi-option',
									'image' => 'image-product-multi-option.png',
								),
								'ShopProductType' => array(
									'id' => 'complex-options',
									'name' => 'complex-options',
								)
							)
						)
					)
				)
			)
		);
	}

}
