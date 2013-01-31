<?php
	/**
	 * Infinitas Releas
	 *
	 * Auto generated database update
	 */
	 
	class R510adc8ce20c4a0ea36518fc6318cd70 extends CakeRelease {

	/**
	* Migration description
	*
	* @var string
	* @access public
	*/
		public $description = 'Migration for Shop version 0.9.3';

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
				'shop_addresses' => array(
					'id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'user_id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8', 'after' => 'id'),
					'name' => array('type' => 'string', 'null' => false, 'default' => NULL, 'collate' => 'utf8_general_ci', 'charset' => 'utf8', 'after' => 'user_id'),
					'address_1' => array('type' => 'string', 'null' => false, 'default' => NULL, 'collate' => 'utf8_general_ci', 'charset' => 'utf8', 'after' => 'name'),
					'address_2' => array('type' => 'string', 'null' => false, 'default' => NULL, 'collate' => 'utf8_general_ci', 'charset' => 'utf8', 'after' => 'address_1'),
					'state_id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8', 'after' => 'address_2'),
					'country_id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8', 'after' => 'state_id'),
					'post_code' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 10, 'collate' => 'utf8_general_ci', 'charset' => 'utf8', 'after' => 'country_id'),
					'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL, 'after' => 'post_code'),
					'modified' => array('type' => 'datetime', 'null' => true, 'default' => NULL, 'after' => 'created'),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
				'shop_option_variants' => array(
					'id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'shop_product_variant_id' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 36, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8', 'after' => 'id'),
					'shop_option_value_id' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 36, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8', 'after' => 'shop_product_variant_id'),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
						'fk_shop_option_variants_shop_product_variants1_idx' => array('column' => 'shop_product_variant_id', 'unique' => 0),
						'fk_shop_option_variants_shop_option_values1_idx' => array('column' => 'shop_option_value_id', 'unique' => 0),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
				'shop_order_products' => array(
					'id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'shop_order_id' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 36, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8', 'after' => 'id'),
					'shop_product_variant_id' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 36, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8', 'after' => 'shop_order_id'),
					'shop_product_type_id' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8', 'after' => 'shop_product_variant_id'),
					'quantity' => array('type' => 'float', 'null' => true, 'default' => NULL, 'length' => '10,3', 'after' => 'shop_product_type_id'),
					'name' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 150, 'collate' => 'utf8_general_ci', 'charset' => 'utf8', 'after' => 'quantity'),
					'brand' => array('type' => 'string', 'null' => true, 'default' => NULL, 'collate' => 'utf8_general_ci', 'charset' => 'utf8', 'after' => 'name'),
					'shop_image_id' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8', 'after' => 'brand'),
					'product_code' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 50, 'collate' => 'utf8_general_ci', 'charset' => 'utf8', 'after' => 'shop_image_id'),
					'time_to_purchase' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10, 'after' => 'product_code'),
					'view_to_purchase' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 5, 'after' => 'time_to_purchase'),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
						'fk_shop_order_products_shop_orders1_idx' => array('column' => 'shop_order_id', 'unique' => 0),
						'fk_shop_order_products_shop_products1_idx' => array('column' => 'shop_product_variant_id', 'unique' => 0),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
				'shop_payment_methods' => array(
					'id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'name' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 50, 'collate' => 'utf8_general_ci', 'charset' => 'utf8', 'after' => 'id'),
					'active' => array('type' => 'boolean', 'null' => true, 'default' => '1', 'after' => 'name'),
					'ordering' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'length' => 5, 'after' => 'active'),
					'debug' => array('type' => 'boolean', 'null' => true, 'default' => '0', 'after' => 'ordering'),
					'total_minimum' => array('type' => 'float', 'null' => true, 'default' => NULL, 'length' => '15,5', 'after' => 'debug'),
					'total_maximum' => array('type' => 'float', 'null' => true, 'default' => NULL, 'length' => '15,5', 'after' => 'total_minimum'),
					'require_login' => array('type' => 'boolean', 'null' => true, 'default' => NULL, 'after' => 'total_maximum'),
					'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL, 'after' => 'require_login'),
					'modified' => array('type' => 'datetime', 'null' => true, 'default' => NULL, 'after' => 'created'),
					'processing_fee' => array('type' => 'float', 'null' => true, 'default' => NULL, 'length' => '15,5', 'after' => 'modified'),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
				'shop_product_variants' => array(
					'id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'shop_product_id' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 36, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8', 'after' => 'id'),
					'shop_image_id' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8', 'after' => 'shop_product_id'),
					'master' => array('type' => 'boolean', 'null' => true, 'default' => NULL, 'after' => 'shop_image_id'),
					'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL, 'after' => 'master'),
					'modified' => array('type' => 'datetime', 'null' => true, 'default' => NULL, 'after' => 'created'),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
						'fk_shop_product_variants_shop_products1_idx' => array('column' => 'shop_product_id', 'unique' => 0),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
			),
			'create_field' => array(
				'shop_branch_stocks' => array(
					'shop_product_variant_id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8', 'after' => 'shop_branch_id'),
					'indexes' => array(
						'fk_shop_branch_stocks_shop_product_variants1' => array('column' => 'shop_product_variant_id', 'unique' => 0),
					),
				),
				'shop_images' => array(
					'keywords' => array('type' => 'string', 'null' => true, 'default' => NULL, 'collate' => 'utf8_general_ci', 'charset' => 'utf8', 'after' => 'ext'),
				),
				'shop_list_products' => array(
					'shop_product_variant_id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8', 'after' => 'shop_list_id'),
					'indexes' => array(
						'fk_shop_wishlists_shop_products1_idx' => array('column' => 'shop_product_variant_id', 'unique' => 0),
					),
				),
				'shop_lists' => array(
					'token' => array('type' => 'string', 'null' => false, 'default' => NULL, 'collate' => 'utf8_general_ci', 'charset' => 'utf8', 'after' => 'name'),
					'shop_list_product_count' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 8, 'after' => 'shop_payment_method_id'),
				),
				'shop_option_values' => array(
					'colour' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 6, 'collate' => 'utf8_general_ci', 'charset' => 'utf8', 'after' => 'product_code'),
				),
				'shop_order_notes' => array(
					'internal' => array('type' => 'boolean', 'null' => false, 'default' => NULL, 'after' => 'user_notified'),
				),
				'shop_orders' => array(
					'total' => array('type' => 'float', 'null' => false, 'default' => '0.000000', 'length' => '15,6', 'after' => 'user_id'),
					'tax' => array('type' => 'float', 'null' => false, 'default' => '0.000000', 'length' => '15,6', 'after' => 'total'),
					'shipping' => array('type' => 'float', 'null' => false, 'default' => '0.000000', 'length' => '15,6', 'after' => 'tax'),
					'insurance' => array('type' => 'float', 'null' => false, 'default' => '0.000000', 'length' => '15,6', 'after' => 'shipping'),
					'handling' => array('type' => 'float', 'null' => false, 'default' => '0.000000', 'length' => '15,6', 'after' => 'insurance'),
					'infinitas_payment_log_id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8', 'after' => 'tracking_number'),
					'assigned_user_id' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8', 'after' => 'shop_order_status_id'),
					'shop_order_product_count' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 8, 'after' => 'ip_address'),
					'indexes' => array(
						'invoice_number' => array('column' => 'invoice_number', 'unique' => 1),
					),
				),
				'shop_prices' => array(
					'indexes' => array(
						'asd' => array('column' => 'foreign_key', 'unique' => 1),
					),
				),
				'shop_products' => array(
					'quantity_unit' => array('type' => 'float', 'null' => false, 'default' => '1.0000', 'length' => '5,4', 'after' => 'shop_brand_id'),
					'quantity_min' => array('type' => 'float', 'null' => false, 'default' => '1.00000', 'length' => '10,5', 'after' => 'quantity_unit'),
					'quantity_max' => array('type' => 'float', 'null' => true, 'default' => NULL, 'length' => '10,5', 'after' => 'quantity_min'),
					'call_for_price' => array('type' => 'boolean', 'null' => false, 'default' => '0', 'after' => 'available'),
				),
			),
			'drop_field' => array(
				'shop_branch_stocks' => array('shop_product_id', 'indexes' => array('fk_shop_branch_stocks_shop_products1')),
				'shop_list_products' => array('shop_product_id', 'indexes' => array('fk_shop_wishlists_shop_products1_idx')),
				'shop_prices' => array('', 'indexes' => array('shop_product_id_UNIQUE')),
			),
			'alter_field' => array(
				'shop_orders' => array(
					'invoice_number' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 5, 'collate' => 'utf8_general_ci', 'charset' => 'utf8', 'key' => 'unique'),
				),
			),
			'drop_table' => array(
				'shop_list_product_options', 'shop_payment_method_apis', 'shop_products_option_ignores', 'shop_products_option_value_ignores', 'shop_products_option_value_overrides'
			),
		),
		'down' => array(
			'drop_table' => array(
				'shop_addresses', 'shop_option_variants', 'shop_order_products', 'shop_payment_methods', 'shop_product_variants'
			),
			'drop_field' => array(
				'shop_branch_stocks' => array('shop_product_variant_id', 'indexes' => array('fk_shop_branch_stocks_shop_product_variants1')),
				'shop_images' => array('keywords',),
				'shop_list_products' => array('shop_product_variant_id', 'indexes' => array('fk_shop_wishlists_shop_products1_idx')),
				'shop_lists' => array('token', 'shop_list_product_count',),
				'shop_option_values' => array('colour',),
				'shop_order_notes' => array('internal',),
				'shop_orders' => array('total', 'tax', 'shipping', 'insurance', 'handling', 'infinitas_payment_log_id', 'assigned_user_id', 'shop_order_product_count', 'indexes' => array('invoice_number')),
				'shop_prices' => array('', 'indexes' => array('asd')),
				'shop_products' => array('quantity_unit', 'quantity_min', 'quantity_max', 'call_for_price',),
			),
			'create_field' => array(
				'shop_branch_stocks' => array(
					'shop_product_id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'indexes' => array(
						'fk_shop_branch_stocks_shop_products1' => array('column' => 'shop_product_id', 'unique' => 0),
					),
				),
				'shop_list_products' => array(
					'shop_product_id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'indexes' => array(
						'fk_shop_wishlists_shop_products1_idx' => array(),
					),
				),
				'shop_prices' => array(
					'indexes' => array(
						'shop_product_id_UNIQUE' => array('column' => 'foreign_key', 'unique' => 1),
					),
				),
			),
			'alter_field' => array(
				'shop_orders' => array(
					'invoice_number' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 50, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
				),
			),
			'create_table' => array(
				'shop_list_product_options' => array(
					'id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'shop_list_product_id' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 36, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'shop_option_id' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 36, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'shop_option_value_id' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 36, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
						'fk_shop_list_product_options_shop_lists1_idx' => array('column' => 'shop_list_product_id', 'unique' => 0),
						'fk_shop_list_product_options_shop_options1_idx' => array('column' => 'shop_option_id', 'unique' => 0),
						'fk_shop_list_product_options_shop_option_values1_idx' => array('column' => 'shop_option_value_id', 'unique' => 0),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
				'shop_payment_method_apis' => array(
					'id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'shop_payment_method_id' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 36, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'email' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 150, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'username' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 150, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'api_url' => array('type' => 'string', 'null' => true, 'default' => NULL, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'shop_currency_id' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 36, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'encryption_certificate_id' => array('type' => 'string', 'null' => true, 'default' => NULL, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'encryption_key_file' => array('type' => 'string', 'null' => true, 'default' => NULL, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'encryption_certificate_file' => array('type' => 'string', 'null' => true, 'default' => NULL, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'encryption_provider_certificate_file' => array('type' => 'string', 'null' => true, 'default' => NULL, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'encryption_build_notation' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 100, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
						'fk_payment_method_apis_shop_currencies1_idx' => array('column' => 'shop_currency_id', 'unique' => 0),
						'fk_payment_method_apis_shop_payment_methods1_idx' => array('column' => 'shop_payment_method_id', 'unique' => 0),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
				'shop_products_option_ignores' => array(
					'id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'shop_option_id' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 36, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'model' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 50, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'foreign_key' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 36, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
						'fk_shop_option_ignores_shop_options1' => array('column' => 'shop_option_id', 'unique' => 0),
						'fk_shop_option_ignores_shop_products1' => array('column' => 'foreign_key', 'unique' => 0),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
				'shop_products_option_value_ignores' => array(
					'id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'shop_option_value_id' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 36, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'model' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 50, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'foreign_key' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 36, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
						'fk_shop_products_option_value_ignores_shop_products1' => array('column' => 'foreign_key', 'unique' => 0),
						'fk_shop_products_option_value_ignores_shop_option_values1' => array('column' => 'shop_option_value_id', 'unique' => 0),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
				'shop_products_option_value_overrides' => array(
					'id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'shop_option_value_id' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 36, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'model' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 50, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'foreign_key' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 36, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
						'fk_shop_option_values_products_shop_option_values1' => array('column' => 'shop_option_value_id', 'unique' => 0),
						'fk_shop_product_option_value_overides_shop_products1' => array('column' => 'foreign_key', 'unique' => 0),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
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