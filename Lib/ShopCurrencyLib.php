<?php
/**
 * @brief libs for currency handeling
 *
 * Class for handeling currency conversions thoughout the shop plugin
 */
App::uses('CakeSession', 'Model/Datasource');

class ShopCurrencyLib {
/**
 * @brief session key used for storing the path to the current currency
 * 
 * @param array
 */
	protected static $_sessionKey = 'Shop.currency';

/**
 * @brief get the currently used session
 *
 * @return string
 */
	public function getCurrency($to = null) { 
		if($to) {
			return strtoupper($to);
		}
		$value = CakeSession::read(self::$_sessionKey);
		if(!$value) {
			return self::defaultCurrency();
		}
		return $value;
	}

/**
 * @brief get the default store currency
 * 
 * @return string
 */
	public function defaultCurrency() {
		return strtoupper(Configure::read(self::$_sessionKey));
	}

/**
 * @brief set the currency to be used
 * 
 * @param string $currency the new currency to be used
 * 
 * @return see CakeSession::write()
 */
	public function setSession($currency) {
		if(strlen($currency) !== 3) {
			throw new InvalidArgumentException('Invalid currency code');
		}
		return CakeSession::write(self::$_sessionKey, strtoupper($currency));
	}

/**
 * @brief configure the currency being used
 *
 * @param type $currency
 *
 * @return see self::setSession()
 */
	public static function setCurrency($currency = null) {
		if(!$currency) {
			$currency = self::getCurrency();
		}

		return self::setSession(self::addFormat($currency));
	}

/**
 * @brief add a new format to the available currency conversions
 * 
 * @param string $currency the currency code to be added
 *
 * @return CakeNumber::addFormat()
 */
	public function addFormat($currency) {
		$currency = ClassRegistry::init('Shop.ShopCurrency')->find('currency', array(
			'currency' => $currency
		));
		$currency = current($currency);
		$changeFields = array(
			'whole_symbol',
			'whole_position',
			'fraction_symbol',
			'fraction_position'
		);
		array_walk($changeFields, function($field) use(&$currency) {
			$currency[Inflector::variable($field)] = $currency[$field];
			unset($currency[$field]);
		});
		$currency['code'] = self::getCurrency($currency['code']);

		CakeNumber::addFormat($currency['code'], $currency);
		return $currency['code'];
	}

/**
 * @brief convert from one currency to another
 *
 * The shop default is always used as the base currency
 *
 * @param float $amount the amount being converted
 * @param string $to the currency code being converted to
 *
 * @return float
 */
	public static function convert($amount, $to = null) {
		$factors = ClassRegistry::init('Shop.ShopCurrency')->find('conversions');
		$to = self::getCurrency($to);
		if(isset($factors[$to]) && (float)$factors[$to] == 1) {
			return $amount;
		}
		return round($amount * $factors[$to], 4);
	}
}
