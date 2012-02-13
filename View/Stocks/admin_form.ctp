<?php
    /**
     * Blog Comments admin edit posts
     *
     * this is the page for admins to edit blog posts
     *
     * Copyright (c) 2009 Carl Sutton ( dogmatic69 )
     *
     * Licensed under The MIT License
     * Redistributions of files must retain the above copyright notice.
     *
     * @filesource
     * @copyright     Copyright (c) 2009 Carl Sutton ( dogmatic69 )
     * @link          http://infinitas-cms.org
     * @package       blog
     * @subpackage    blog.views.posts.admin_edit
     * @license       http://www.opensource.org/licenses/mit-license.php The MIT License
     */

    echo $this->Form->create('Stock');
        echo $this->Infinitas->adminEditHead();
	        ?>
				<div class="data">
					<?php
				        echo $this->Form->input('id');
				        echo $this->Form->input('branch_id', array('empty' => __(Configure::read('Website.empty_select'))));
				        echo $this->Form->input('product_id', array('empty' => __(Configure::read('Website.empty_select'))));
				    ?>
				</div>
				<div class="config">
					<?php
				        	echo $this->Form->input('stock');
				    ?>
				</div>
			<?php
    echo $this->Form->end();
?>