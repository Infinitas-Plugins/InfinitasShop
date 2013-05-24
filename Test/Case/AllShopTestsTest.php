<?php
App::uses('AllTestsBase', 'Test/Lib');

class AllShopTestsTest extends AllTestsBase {

/**
 * Suite define the tests for this suite
 *
 * @return void
 */
	public static function suite() {
		$suite = new CakeTestSuite('All Shop test');

		$path = CakePlugin::path('Shop') . 'Test' . DS . 'Case' . DS;
		$suite->addTestDirectoryRecursive($path);
		
		$path = CakePlugin::path('InfinitasPayments') . 'Test' . DS . 'Case' . DS;
		$suite->addTestDirectoryRecursive($path);

		return $suite;
	}
}
