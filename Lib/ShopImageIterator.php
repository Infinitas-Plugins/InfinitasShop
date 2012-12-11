<?php
/**
 * ShopImageIterator
 *
 * @package Shop.Lib.Iterator
 */

/**
 * ShopImageIterator
 *
 * @package Shop.Lib.Iterator
 */

class ShopImageIterator extends FilterIterator {
	public function accept() {
		if (!$this->current()->isFile()) {
			return false;
		}

		$valid = array('jpg', 'jpeg', 'png', 'gif');
		if (!in_array($this->current()->getExtension(), $valid)) {
			continue;
		}

		return true;
	}

	public function name() {
		return trim($this->current()->getBasename($this->current()->getExtension()), '.');
	}
}