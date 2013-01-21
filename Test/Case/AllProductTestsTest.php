<?php
App::uses('AllTestsBase', 'Test/Lib');

class AllProductTestsTest extends AllTestsBase {

/**
 * Suite define the tests for this suite
 *
 * @return void
 */
	public static function suite() {
		$suite = new CakeTestSuite('All Shop test');

		$path = CakePlugin::path('Shop') . 'Test' . DS . 'Case' . DS;
		$suite->addTestFile($path . 'Model' . DS . 'ShopProductTest.php');
		$suite->addTestFile($path . 'Model' . DS . 'ShopProductFindTest.php');

		return $suite;
	}
}