<?php
class ShopAppController extends AppController {

/**
 * BeforeFilter callback
 * 
 * Global shop pagination limit
 * 
 * @return void
 */
	public function beforeFilter() {
		parent::beforeFilter();

		if (!array_key_exists('admin', $this->request->params) || !$this->request->params['admin']) {
			$this->request->params['named'] = array_merge(array(
				'limit' => Configure::read('Shop.pagination.default')
			), $this->request->params['named']);
		}
	}	
}