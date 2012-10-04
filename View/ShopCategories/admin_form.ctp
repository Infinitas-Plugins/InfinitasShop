<?php
    /**
     * Shop suppliers add/edit
     *
     * This page is used to add/edit suppliers for your products.
     *
     * Copyright (c) 2009 Carl Sutton ( dogmatic69 )
     *
     * Licensed under The MIT License
     * Redistributions of files must retain the above copyright notice.
     *
     * @filesource
     * @copyright     Copyright (c) 2009 Carl Sutton ( dogmatic69 )
     * @link          http://infinitas-cms.org
     * @package       shop
     * @subpackage    shop.views.suppliers.form
     * @license       http://www.opensource.org/licenses/mit-license.php The MIT License
     * @since 0.8a
     */

    echo $this->Form->create('ShopCategory', array('type' => 'file'));
        echo $this->Infinitas->adminEditHead();
        	?>
				<div class="data">
					<?php
						echo $this->Form->input('id');
						echo $this->Form->input('name', array('class' => 'title'));
						echo $this->Shop->wysiwyg('ShopCategory.description');
					?>
				</div>
				<div class="config">
					<?php
        					?><h2><?php echo __d('shop', 'Config'); ?></h2><?php
							echo $this->Form->input('keywords');
							echo $this->Form->input('parent_id', array('empty' => __d('shop', 'Root Category')));
							echo $this->Form->input('ShopBranch');
							echo $this->Form->input('active');

        					?><h2><?php echo __d('shop', 'Image'); ?></h2><?php
							echo $this->Form->input('Image.image', array('label' => __d('shop', 'New image'), 'type' => 'file'));
							echo $this->Form->input('image_id', array('label' => __d('shop', 'Exsisting image'), 'empty' => __d('shop', Configure::read('Website.empty_select'))));
        				
					?>
				</div>
			<?php
    echo $this->Form->end();
?>