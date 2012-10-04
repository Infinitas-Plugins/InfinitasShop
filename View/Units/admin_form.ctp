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

    echo $this->Form->create('Unit', array('type' => 'file'));
        echo $this->Infinitas->adminEditHead();
        	?>
				<div class="data">
					<?php
						echo $this->Form->input('id');
						echo $this->Form->input('name', array('class' => 'title'));
						echo $this->Shop->wysiwyg('Unit.description');
					?>
				</div>
				<div class="config">
					<?php
        					?><h2><?php echo __d('shop', 'config'); ?></h2><?php
							echo $this->Form->input('symbol');
							echo $this->Form->input('active');
					?>
				</div>
				<div class="clr">&nbsp;</div>
			<?php
    echo $this->Form->end();
?>