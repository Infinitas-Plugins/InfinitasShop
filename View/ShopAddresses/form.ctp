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
			<h1><?php echo __('Shop addresses'); ?></h1><?php
				echo $this->Form->input('id');
				echo $this->Form->input('name');
				echo $this->Form->input('address_1');
				echo $this->Form->input('address_2');
				echo $this->element('GeoLocation.region_select', array(
					'model' => 'ShopAddress'
				));
				echo $this->Form->input('post_code');
			?>
		</fieldset><?php
	echo $this->Form->end();
