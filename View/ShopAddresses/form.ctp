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
echo $this->Form->create(); ?>
	<fieldset>
		<h1><?php echo __('Shop addresses'); ?></h1><?php
			echo $this->Form->input('id');
			echo $this->element('Shop.profile/address_form');
			echo $this->Form->submit(__d('infinitas', 'Save'));
		?>
	</fieldset><?php
echo $this->Form->end();
