<?php
	/**
	 * Infinitas Releas
	 *
	 * Auto generated database update
	 */
	 
	class R519cfa2e4ad04476a71515b86318cd70 extends CakeRelease {

	/**
	* Migration description
	*
	* @var string
	* @access public
	*/
		public $description = 'Migration for Shop version 0.9.4';

	/**
	* Plugin name
	*
	* @var string
	* @access public
	*/
		public $plugin = 'Shop';

	/**
	* Actions to be performed
	*
	* @var array $migration
	* @access public
	*/
		public $migration = array(
			'up' => array(
			'create_table' => array(
				'shop_attribute_groups' => array(
					'id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'key' => 'primary', 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
					'name' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1', 'after' => 'id'),
					'slug' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1', 'after' => 'name'),
					'shop_attribute_count' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'length' => 5, 'after' => 'slug'),
					'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL, 'after' => 'shop_attribute_count'),
					'modified' => array('type' => 'datetime', 'null' => true, 'default' => NULL, 'after' => 'created'),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
					),
					'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB'),
				),
				'shop_attributes' => array(
					'id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'key' => 'primary', 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
					'name' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1', 'after' => 'id'),
					'slug' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1', 'after' => 'name'),
					'image' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 150, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1', 'after' => 'slug'),
					'shop_attribute_group_id' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 50, 'key' => 'index', 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1', 'after' => 'image'),
					'shop_product_attribute_count' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'after' => 'shop_attribute_group_id'),
					'ordering' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 3, 'after' => 'shop_product_attribute_count'),
					'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL, 'after' => 'ordering'),
					'modified' => array('type' => 'datetime', 'null' => true, 'default' => NULL, 'after' => 'created'),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
						'fk_shop_attributes_shop_attribute_groups2_idx' => array('column' => 'shop_attribute_group_id', 'unique' => 0),
					),
					'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB'),
				),
				'shop_product_attributes' => array(
					'id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'key' => 'primary', 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
					'shop_attribute_id' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 36, 'key' => 'index', 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1', 'after' => 'id'),
					'shop_product_id' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 36, 'key' => 'index', 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1', 'after' => 'shop_attribute_id'),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
						'fk_shop_product_attributes_shop_products1_idx' => array('column' => 'shop_product_id', 'unique' => 0),
						'fk_shop_product_attributes_shop_attributes1_idx' => array('column' => 'shop_attribute_id', 'unique' => 0),
					),
					'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB'),
				),
			),
			'create_field' => array(
				'shop_images' => array(
					'colour_1' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 6, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8', 'after' => 'keywords'),
					'colour_2' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 6, 'collate' => 'utf8_general_ci', 'charset' => 'utf8', 'after' => 'colour_1'),
					'colour_3' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 6, 'collate' => 'utf8_general_ci', 'charset' => 'utf8', 'after' => 'colour_2'),
					'indexes' => array(
						'colour_1' => array('column' => 'colour_1', 'unique' => 0),
					),
				),
				'shop_products' => array(
					'shop_product_attribute_count' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 5, 'after' => 'shop_product_type_id'),
					'indexes' => array(
						'created' => array('column' => 'created', 'unique' => 0),
						'list' => array('column' => array('active', 'available'), 'unique' => 0),
					),
				),
			),
			'alter_field' => array(
				'shop_products' => array(
					'active' => array('type' => 'boolean', 'null' => false, 'default' => '0', 'key' => 'index'),
					'created' => array('type' => 'datetime', 'null' => false, 'default' => NULL, 'key' => 'index'),
				),
			),
		),
		'down' => array(
			'drop_table' => array(
				'shop_attribute_groups', 'shop_attributes', 'shop_product_attributes'
			),
			'drop_field' => array(
				'shop_images' => array('colour_1', 'colour_2', 'colour_3', 'indexes' => array('colour_1')),
				'shop_products' => array('shop_product_attribute_count', 'indexes' => array('created', 'list')),
			),
			'alter_field' => array(
				'shop_products' => array(
					'active' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
					'created' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
				),
			),
		),
		);

	
	/**
	* Before migration callback
	*
	* @param string $direction, up or down direction of migration process
	* @return boolean Should process continue
	* @access public
	*/
		public function before($direction) {
			return true;
		}

	/**
	* After migration callback
	*
	* @param string $direction, up or down direction of migration process
	* @return boolean Should process continue
	* @access public
	*/
		public function after($direction) {
			return true;
		}
	}