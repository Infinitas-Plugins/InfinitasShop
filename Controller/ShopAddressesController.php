<?php
/**
 * ShopAddresses controller
 *
 * @brief Add some documentation for ShopAddresses controller.
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

class ShopAddressesController extends ShopAppController {

/**
 * @brief the index method
 *
 * Show a paginated list of ShopAddress records.
 *
 * @todo update the documentation
 *
 * @return void
 */
	public function index() {
		$this->Paginator->settings = array(
			'contain' => array(
				'User',
				'GeoLocationCountry',
				'GeoLocationRegion'
			)
		);

		$shopAddresses = $this->Paginator->paginate(null, $this->Filter->filter);

		$filterOptions = $this->Filter->filterOptions;
		$filterOptions['fields'] = array(
			'name',
		);

		$this->set(compact('shopAddresses', 'filterOptions'));
	}

/**
 * allow users to add new addresses
 * 
 * @return void
 */
	public function add() {
		if (!empty($this->request->data)) {
			if ($this->{$this->modelClass}->save($this->request->data)) {
				$this->notice(__d('shop', 'Address saved'), array(
					'redirect' => ''
				));
			}
			$this->notice('not_saved', array(
				'redirect' => true
			));
		}

		$this->saveRedirectMarker();
	}

/**
 * allow users to modify their own addresses
 *
 * @param string $id the id of the address record to modify
 * 
 * @return void
 */
	public function edit($id = null) {
		if (!empty($this->request->data)) {
			if ($this->{$this->modelClass}->save($this->request->data)) {
				$this->notice('saved');
			}
			$this->notice('not_saved');
		}

		if (empty($this->request->data) && $id) {
			$this->request->data = $this->{$this->modelClass}->find('first', array(
				'conditions' => array(
					$this->modelClass . '.' . $this->{$this->modelClass}->primaryKey => $id,
					$this->modelClass . '.user_id' => AuthComponent::user('id'),
				)
			));

			if (empty($this->request->data)) {
				$this->notice('not_found', array(
					'redirect' => '/'
				));
			}
		}

		$geoLocationCountries = $this->{$this->modelClass}->countries();
		$geoLocationRegions = $this->{$this->modelClass}->regions($this->request->data[$this->modelClass]['geo_location_country_id']);
		$this->set(compact('geoLocationCountries', 'geoLocationRegions'));
		$this->saveRedirectMarker();
	}

/**
 * allow users to delete their own addresses
 *
 * @param string $id the address id to remove
 * 
 * @return void
 */
	public function delete($id = null) {
		$id = $this->{$this->modelClass}->field('id', array(
			$this->modelClass . '.id' => $id,
			$this->modelClass . '.user_id' => $this->{$this->modelClass}->currentUserId()
		));
		if (!$id) {
			$this->notice('not_found');
		}

		if ($this->{$this->modelClass}->delete($id)) {
			$this->notice('deleted');
		}
		$this->notice('not_deleted');
	}

/**
 * @brief view method for a single row
 *
 * Show detailed information on a single ShopAddress
 *
 * @todo update the documentation 
 * @param mixed $id int or string uuid or the row to find
 *
 * @return void
 */
	public function view($id = null) {
		if (!$id) {
			$this->Infinitas->noticeInvalidRecord();
		}

		$shopAddress = $this->ShopAddress->getViewData(
			array($this->ShopAddress->alias . '.' . $this->ShopAddress->primaryKey => $id)
		);

		$this->set(compact('shopAddress'));
	}

/**
 * @brief the index method
 *
 * Show a paginated list of ShopAddress records.
 *
 * @todo update the documentation
 *
 * @return void
 */
	public function admin_index() {
		$this->Paginator->settings = array(
			'contain' => array(
				'User',
			)
		);

		$shopAddresses = $this->Paginator->paginate(null, $this->Filter->filter);

		$filterOptions = $this->Filter->filterOptions;
		$filterOptions['fields'] = array(
			'name',
		);

		$this->set(compact('shopAddresses', 'filterOptions'));
	}

/**
 * @brief view method for a single row
 *
 * Show detailed information on a single ShopAddress
 *
 * @todo update the documentation 
 * @param mixed $id int or string uuid or the row to find
 *
 * @return void
 */
	public function admin_view($id = null) {
		if (!$id) {
			$this->Infinitas->noticeInvalidRecord();
		}

		$shopAddress = $this->ShopAddress->getViewData(
			array($this->ShopAddress->alias . '.' . $this->ShopAddress->primaryKey => $id)
		);

		$this->set(compact('shopAddress'));
	}

/**
 * @brief admin create action
 *
 * Adding new ShopAddress records.
 *
 * @todo update the documentation
 *
 * @return void
 */
	public function admin_add() {
		parent::admin_add();

		$users = $this->ShopAddress->User->find('list');
		$this->set(compact('users'));
	}

/**
 * @brief admin edit action
 *
 * Edit old ShopAddress records.
 *
 * @todo update the documentation
 * @param mixed $id int or string uuid or the row to edit
 *
 * @return void
 */
	public function admin_edit($id = null) {
		parent::admin_edit($id);

		$users = $this->ShopAddress->User->find('list');
		$this->set(compact('users'));
	}
}