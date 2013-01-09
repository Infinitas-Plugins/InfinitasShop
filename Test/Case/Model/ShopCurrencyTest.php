<?php
App::uses('ShopCurrency', 'Shop.Model');

/**
 * ShopCurrency Test Case
 *
 */
class ShopCurrencyTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.shop.shop_currency',
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Model = ClassRegistry::init('Shop.ShopCurrency');
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
 * check there are exceptions thrown when there is no currencies available
 *
 * @expectedException CakeException
 */
	public function testFindCurrencyNoneAvailable() {
		$this->assertTrue((bool)$this->Model->deleteAll(array('ShopCurrency.id != ' => null)));
		$this->Model->find('currency');
	}

/**
 * Check that you can set a currency to near 1 without it becoming default
 *
 * @expectedException CakeException
 *
 * @dataProvider nearOneIsNotOneDataProvider
 */
	public function testNearOneIsNotOne($data) {
		$this->Model->id = 'gbp';
		$this->assertTrue((bool)$this->Model->saveField('factor', $data));
		$this->Model->find('currency');
	}

/**
 * near one is not one data provider
 * @return type
 */
	public function nearOneIsNotOneDataProvider() {
		return array(
			array('1.0000001'),
			array('0.9999999')
		);
	}

/**
 * test finding the default + when it changes
 */
	public function testFindCurrencyDefault() {
		$expected = array(
			'ShopCurrency' => array(
				'name' => 'gbp',
				'code' => 'GBP',
				'factor' => 1,
				'whole_symbol' => '£',
				'whole_position' => 0,
				'fraction_symbol' => 'p',
				'fraction_position' => 1,
				'zero' => '0',
				'places' => 2,
				'thousands' => ',',
				'decimals' => '.',
				'negative' => '-',
				'escape' => 1,
			)
		);
		$results = $this->Model->find('currency');
		$this->assertEquals($expected, $results);

		$this->Model->id = 'gbp';
		$this->assertTrue((bool)$this->Model->saveField('factor', '1.2'));

		$this->Model->id = 'usd';
		$this->assertTrue((bool)$this->Model->saveField('factor', '1'));
		$expected = array(
			'ShopCurrency' => array(
				'name' => 'usd',
				'code' => 'USD',
				'factor' => '1.00000000',
				'whole_symbol' => '$',
				'whole_position' => false,
				'fraction_symbol' => 'c',
				'fraction_position' => true,
				'zero' => '-',
				'places' => 2,
				'thousands' => ',',
				'decimals' => '.',
				'negative' => '-',
				'escape' => 1,
			)
		);
		$results = $this->Model->find('currency');
		$this->assertEquals($expected, $results);
	}

/**
 * test find currency specific
 *
 * @dataProvider findCurrencySpecificDataProvider
 */
	public function testFindCurrencySpecific($data, $expected) {
		if (!empty($expected)) {
			$expected = array($this->Model->alias => $expected);
		}

		$result = $this->Model->find('currency', array('currency' => $data));

		if ($result) {
			$res = round($result[$this->Model->alias]['factor'], 4);
			$exp = round($expected[$this->Model->alias]['factor'], 4);
			$this->assertEquals($exp, $res);
			unset($result[$this->Model->alias]['factor'], $expected[$this->Model->alias]['factor']);
		}
		$this->assertEquals($expected, $result);
	}

/**
 * find currency specific data provider
 *
 * @return array
 */
	public function findCurrencySpecificDataProvider() {
		return array(
			array(
				false,
				array(
					'name' => 'gbp',
					'code' => 'GBP',
					'factor' => 1,
					'whole_symbol' => '£',
					'whole_position' => 0,
					'fraction_symbol' => 'p',
					'fraction_position' => 1,
					'zero' => '0',
					'places' => 2,
					'thousands' => ',',
					'decimals' => '.',
					'negative' => '-',
					'escape' => 1,
				)
			),
			array(
				'gbp',
				array(
					'name' => 'gbp',
					'code' => 'GBP',
					'factor' => 1,
					'whole_symbol' => '£',
					'whole_position' => 0,
					'fraction_symbol' => 'p',
					'fraction_position' => 1,
					'zero' => '0',
					'places' => 2,
					'thousands' => ',',
					'decimals' => '.',
					'negative' => '-',
					'escape' => 1,
				)
			),
			array(
				'usd',
				array(
					'name' => 'usd',
					'code' => 'USD',
					'factor' => '1.5999',
					'whole_symbol' => '$',
					'whole_position' => 0,
					'fraction_symbol' => 'c',
					'fraction_position' => 1,
					'zero' => '-',
					'places' => 2,
					'thousands' => ',',
					'decimals' => '.',
					'negative' => '-',
					'escape' => 1,
				)
			)
		);
	}

/**
 * test find conversion data
 */
	public function testFindConversionsData() {
		$round = function($data) {
			array_walk($data, function(&$res) {
				$res = round($res, 4);
			});

			return $data;
		};

		$expected = array(
			'GBP' => '1.0000',
			'USD' => '1.5999',
			'EUR' => '1.2425'
		);
		$result = $round($this->Model->find('conversions'));

		$this->assertEquals($expected, $result);

		$this->assertTrue($this->Model->deleteAll(array($this->Model->alias . '.id' => 'eur')));
		$expected = array(
			'GBP' => '1.0000',
			'USD' => '1.5999'
		);
		$result = $round($this->Model->find('conversions'));
		$this->assertEquals($expected, $result);
	}

/**
 * test currencies get updated
 */
	public function testUpdate() {
		$now = date('Y-m-d H:i:s');
		App::uses('CakeSession', 'Model/Datasource');
		$before = $this->Model->find('conversions');
		$this->assertTrue($this->Model->updateCurrencies());
		$after = $this->Model->find('conversions');

		$this->assertNotEquals($before, $after);

		$results = $this->Model->find('list', array(
			'fields' => array(
				$this->Model->alias . '.' . $this->Model->primaryKey,
				$this->Model->alias . '.modified',
			),
			'conditions' => array('not' => array(
				$this->Model->alias . '.code' => 'GBP'
			))
		));

		foreach ($results as $id => $modified) {
			$this->assertTrue($modified >= $now);
		}
	}

/**
 * test find switch
 */
	public function testFindSwitch() {
		$expected = array(
			array(
				$this->Model->alias => array(
					'id' => 'eur',
					'name' => 'eur',
					'code' => 'eur',
					'whole_symbol' => '€'
				)
			),
			array(
				$this->Model->alias => array(
					'id' => 'gbp',
					'name' => 'gbp',
					'code' => 'gbp',
					'whole_symbol' => '£'
				)
			),
			array(
				$this->Model->alias => array(
					'id' => 'usd',
					'name' => 'usd',
					'code' => 'usd',
					'whole_symbol' => '$'
				)
			)
		);
		$result = $this->Model->find('switch');
		$this->assertEquals($expected, $result);
	}

}
