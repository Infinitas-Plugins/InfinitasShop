<?php
    /**
     * Comment Template.
     *
     * @todo -c Implement .this needs to be sorted out.
     *
     * Copyright (c) 2009 Carl Sutton ( dogmatic69 )
     *
     * Licensed under The MIT License
     * Redistributions of files must retain the above copyright notice.
     *
     * @filesource
     * @copyright     Copyright (c) 2009 Carl Sutton ( dogmatic69 )
     * @link          http://infinitas-cms.org
     * @package       sort
     * @subpackage    sort.comments
     * @license       http://www.opensource.org/licenses/mit-license.php The MIT License
     * @since         0.5a
     */

    echo $this->Form->create('Image', array('url' => array('action' => 'mass')));

    $massActions = $this->Infinitas->massActionButtons(
        array(
            'add',
            'edit',
            'copy', // @todo overwrite and copy file
            'delete' // @todo hard delete should unlink() file.
        )
    );
	echo $this->Infinitas->adminIndexHead($filterOptions, $massActions);
?>
<div class="table">
	<?php
		echo $this->Form->input('all', array('label' => __('Select all'), 'type' => 'checkbox'));
		foreach ($images as $image){
			?>
				<div title="<?php echo __('File'), ' :: ', $image['Image']['image']; ?>"class="image">
					<?php
						echo $this->Html->image(
							'content/shop/global/'.$image['Image']['image'],
							array(
								'height' => '35px',
								'class' => 'img'
							)
						);
					?>
					<div class="name"><?php echo $this->Html->link($this->Text->truncate($image['Image']['image'], 20), array('action' => 'edit', $image['Image']['id'])); ?></div>
					<div class="width"><span><?php echo __('Width'), ':</span>', $image['Image']['width'], 'px'; ?></div>
					<div class="height"><span><?php echo __('Height'), ':</span>', $image['Image']['height'], 'px'; ?></div>
					<div class="ext"><span><?php echo __('Ext'), ':</span>', $image['Image']['ext']; ?></div>
					<div class="check"><?php echo $this->Infinitas->massActionCheckBox($image); ?></div>
				</div>
			<?php
		}
        echo $this->Form->end(); ?>
</div>
<?php echo $this->element('pagination/admin/navigation'); ?>