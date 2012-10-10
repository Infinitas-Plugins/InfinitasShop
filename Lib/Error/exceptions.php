<?php
/**
 * @brief exception thrown when no branches exist
 */
class ShopBranchNotConfiguredException extends CakeException {
/**
 * @brief overload the constructor for less code
 *
 * @param array $message
 * @param integer $code
 */
	public function __construct($message = array(), $code = 500) {
		parent::__construct($message, $code);
	}
	
/**
 * Message template
 *
 * @var string
 */
	protected $_messageTemplate = 'No branches have been configured';
}

/**
 * @brief exception thrown when more than one branch exists
 */
class ShopBranchMultipleConfiguredException extends CakeException {
/**
 * @brief overload the constructor for less code
 *
 * @param array $message
 * @param integer $code
 */
	public function __construct($message = array(), $code = 500) {
		parent::__construct($message, $code);
	}

/**
 * Message template
 *
 * @var string
 */
	protected $_messageTemplate = 'More than one branch exists';
}

/**
 * @brief price is below the minium threshold for the selected option
 */
class ShopShippingMethodMinimumException extends CakeException {
	protected $_messageTemplate = '"%s" is below the minimum threshold of "%s"';
}

/**
 * @brief price is above the maximum threshold for the selected option
 */
class ShopShippingMethodMaximumException extends CakeException {
	protected $_messageTemplate = '"%s" is abouve the maximum threshold of "%s"';
}