<?php
	/**
	 * @brief Add some documentation for this add form.
	 *
	 * @copyright Copyright (c) 2009 Carl Sutton (dogmatic69)
	 *
	 * @link    http://infinitas-cms.org/Shop
	 * @package	Shop.views.add
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
			<h1><?php echo __('Shop lists'); ?></h1><?php
				echo $this->Form->input('id');
				echo $this->Form->input('name');
				echo $this->Form->input('token');
			?>
		</fieldset>

		<fieldset>
			<h1><?php echo __('Configuration'); ?></h1><?php
				echo $this->Form->input('user_id', array('empty' => Configure::read('Website.empty_select')));
				echo $this->Form->input('shop_shipping_method_id', array('empty' => Configure::read('Website.empty_select')));
				echo $this->Form->input('shop_payment_method_id', array('empty' => Configure::read('Website.empty_select')));
		?>
		</fieldset><?php
	echo $this->Form->end();
