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