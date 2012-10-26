<?php
/**
 * ShopOptions controller
 *
 * @brief Add some documentation for ShopOptions controller.
 *
 * @copyright Copyright (c) 2009 Carl Sutton (dogmatic69)
 *
 * @link		  http://infinitas-cms.org/Shop
 * @package	   Shop.Controller
 * @license	   http://infinitas-cms.org/mit-license The MIT License
 * @since 0.9b1
 *
 * @author dogmatic69
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 */

class ShopOptionsController extends ShopAppController {
/**
 * The helpers linked to this controller
 *
 * @access public
 * @var array
 */
	public $helpers = array(
		//'Shop.Shop', // uncoment this for a custom plugin controller
		//'Libs.Gravatar',
	);

/**
 * @brief the index method
 *
 * Show a paginated list of ShopOption records.
 *
 * @todo update the documentation
 *
 * @return void
 */
	public function admin_index() {
		$this->Paginator->settings = array(
			'contain' => array(
			)
		);

		$shopOptions = $this->Paginator->paginate(null, $this->Filter->filter);

		$filterOptions = $this->Filter->filterOptions;
		$filterOptions['fields'] = array(
			'name',
		);

		$this->set(compact('shopOptions', 'filterOptions'));
	}

/**
 * @brief view method for a single row
 *
 * Show detailed information on a single ShopOption
 *
 * @todo update the documentation
 * @param mixed $id int or string uuid or the row to find
 *
 * @return void
 */
	public function admin_view($id = null) {
		if(!$id) {
			$this->Infinitas->noticeInvalidRecord();
		}

		$shopOption = $this->ShopOption->getViewData(
			array($this->ShopOption->alias . '.' . $this->ShopOption->primaryKey => $id)
		);

		$this->set(compact('shopOption'));
	}

/**
 * @brief admin create action
 *
 * Adding new ShopOption records.
 *
 * @todo update the documentation
 *
 * @return void
 */
	public function admin_add() {
		parent::admin_add();

	}

/**
 * @brief admin edit action
 *
 * Edit old ShopOption records.
 *
 * @todo update the documentation
 * @param mixed $id int or string uuid or the row to edit
 *
 * @return void
 */
	public function admin_edit($id = null) {
		if(!empty($this->request->data)) {
			foreach($this->request->data['ShopOptionValue'] as $k => $optionValue) {
				if(empty($optionValue['name'])) {
					unset(
						$this->request->data['ShopOptionValue'][$k],
						$this->request->data['ShopPrice'][$k],
						$this->request->data['ShopSize'][$k]
					);
				}
			}
		}
		parent::admin_edit($id, array(
			'contain' => array(
				'ShopOptionValue' => array(
					'ShopPrice',
					'ShopSize',
				),
				'ShopProductTypesOption'
			)
		));

		$shopProductTypes = $this->{$this->modelClass}->ShopProductTypesOption->ShopProductType->find('list');
		$this->set(compact('shopProductTypes'));
	}

}