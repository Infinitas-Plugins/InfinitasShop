<?php
/**
 * ShopAddress
 *
 * @copyright Copyright (c) 2009 Carl Sutton (dogmatic69)
 *
 * @link http://infinitas-cms.org/Shop
 * @package	Shop.Model
 * @license	http://infinitas-cms.org/mit-license The MIT License
 * @since 0.9b1
 *
 * @author Carl Sutton <dogmatic69@infinitas-cms.org>
 */

class ShopAddress extends ShopAppModel {

/**
 * Custom find methods
 *
 * @var array
 */
	public $findMethods = array(
		'addresses' => true
	);

/**
 * belongsTo relations for this model
 *
 * @var array
 */
	public $belongsTo = array(
		'User' => array(
			'className' => 'Users.User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'counterScope' => array(
				'ShopAddress.active' => 1
			),
		),
		'GeoLocationCountry' => array(
			'className' => 'GeoLocation.GeoLocationCountry',
			'foreignKey' => 'geo_location_country_id'
		),
		'GeoLocationRegion' => array(
			'className' => 'GeoLocation.GeoLocationRegion',
			'foreignKey' => 'geo_location_region_id'
		)
	);

/**
 * Constructor
 *
 * @param string|integer $id string uuid or id
 * @param string $table the table that the model is for
 * @param string $ds the datasource being used
 *
 * @return void
 */
	public function __construct($id = false, $table = null, $ds = null) {
		parent::__construct($id, $table, $ds);

		$this->validate = array(
			'address_1' => array(
				'notEmpty' => array(
					'rule' => 'notEmpty',
					'message' => __d('shop', 'Address required'),
					'required' => true
				)
			)
		);
	}

/**
 * Find addresses for the specified user
 *
 * if no user condition has been supplied the current logged in user id will be used
 *
 * @param string $state before / after
 * @param array $query the find conditions
 * @param array $results the results of the find
 *
 * @return array
 */
	protected function _findAddresses($state, array $query, array $results = array()) {
		if ($state == 'before') {
			if (empty($query['conditions'][$this->alias . '.user_id'])) {
				$query['conditions'][$this->alias . '.user_id'] = $this->currentUserId();
			}

			$this->virtualFields['country'] = $this->GeoLocationCountry->alias . '.' . $this->GeoLocationCountry->displayField;
			$this->virtualFields['region'] = $this->GeoLocationRegion->alias . '.' . $this->GeoLocationRegion->displayField;
			$query['fields'] = array_merge((array)$query['fields'], array(
				$this->alias . '.' . $this->primaryKey,
				$this->alias . '.' . $this->displayField,
				$this->alias . '.address_1',
				$this->alias . '.address_2',
				$this->alias . '.post_code',
				$this->alias . '.billing',
				$this->alias . '.modified',
				'country',
				'region'
			));

			if (empty($query['joins'])) {
				$query['joins'] = array();
			}
			$query['joins'] = (array)$query['joins'];

			$query['joins'][] = $this->autoJoinModel($this->GeoLocationCountry);
			$query['joins'][] = $this->autoJoinModel($this->GeoLocationRegion);
			return $query;
		}

		return $results;
	}

/**
 * Get a list of countries
 */
	public function countries() {
		return ClassRegistry::init('GeoLocation.GeoLocationCountry')->find('countries');
	}

/**
 * Get a list of regions for the specified country
 *
 * @param string|integer $countryId the id of the country
 *
 * @return array
 */
	public function regions($countryId) {
		return ClassRegistry::init('GeoLocation.GeoLocationRegion')->find('regions', $countryId);
	}

}