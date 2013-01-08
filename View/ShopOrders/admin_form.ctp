<?php
	/**
	 * @brief Add some documentation for this admin_add form.
	 *
	 * @copyright Copyright (c) 2009 Carl Sutton (dogmatic69)
	 *
	 * @link    http://infinitas-cms.org/Shop
	 * @package	Shop.views.admin_add
	 * @license	http://infinitas-cms.org/mit-license The MIT License
	 * @since   0.9b1
	 *
	 * @author dogmatic69
	 *
	 * Licensed under The MIT License
	 * Redistributions of files must retain the above copyright notice.
	 */
	echo $this->Form->create();
		echo $this->Infinitas->adminEditHead(); ?>
		<fieldset>
			<h1><?php echo __('Shop orders'); ?></h1><?php
				echo $this->Form->input('id');
				echo $this->Form->input('invoice_number');
				echo $this->Form->input('tracking_number');
				echo $this->Form->input('ip_address');
			?>
		</fieldset>

		<fieldset>
			<h1><?php echo __('Configuration'); ?></h1><?php
				echo $this->Form->input('user_id', array('empty' => Configure::read('Website.empty_select')));
				echo $this->Form->input('shop_billing_address_id', array('empty' => Configure::read('Website.empty_select')));
				echo $this->Form->input('shop_shipping_address_id', array('empty' => Configure::read('Website.empty_select')));
				echo $this->Form->input('shop_payment_method_id', array('empty' => Configure::read('Website.empty_select')));
				echo $this->Form->input('shop_shipping_method_id', array('empty' => Configure::read('Website.empty_select')));
				echo $this->Form->input('infinitas_payment_log_id', array('empty' => Configure::read('Website.empty_select')));
				echo $this->Form->input('shop_order_status_id', array('empty' => Configure::read('Website.empty_select')));
		?>
		</fieldset><?php
	echo $this->Form->end();
