<?php
class ShopAppController extends AppController {
/**
 * @brief before filter callback
 *
 * @return boolean
 */
	public function beforeFilter() {
		parent::beforeFilter();

		if(isset($this->request->params['admin']) && $this->request->params['admin']) {
			return true;
		}
		
		Configure::write('Rating.time_limit', false);

		$this->Event->trigger('shopLoad');
		if(!$this->Session->read('Shop.shipping_method')) {
			$this->Session->write('Shop.shipping_method', Configure::read('Shop.shipping_method'));
		}

		return true;
	}

/**
 * @brief before render callback
 *
 * The cart data is loaded for all pages if in the frontend
 *
 * @return bool
 */
	public function beforeRender() {
		parent::beforeRender();

		if(isset($this->request->params['admin']) && $this->request->params['admin']) {
			return true;
		}

		$this->_loadCartData();
	}

/**
 * @brief load the users cart data
 *
 * @return void
 */
	protected function _loadCartData() {
		if(!isset($this->ShopCart)) {
			$this->ShopCart = ClassRegistry::init('Shop.ShopCart');
		}

		$this->set('usersCart', $this->ShopCart->getCartData($this->Auth->user('id')));
	}
}