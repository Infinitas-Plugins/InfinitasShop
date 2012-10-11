<?php
/**
 * @brief Add some documentation for this index form.
 *
 * @copyright Copyright (c) 2009 Carl Sutton (dogmatic69)
 *
 * @link		  http://infinitas-cms.org/Shop
 * @package	   Shop.View.index
 * @license	   http://infinitas-cms.org/mit-license The MIT License
 * @since 0.9b1
 *
 * @author dogmatic69
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 */
echo $this->Form->create(null, array('action' => 'mass'));

$massActions = $this->Infinitas->massActionButtons(
	array(
		'add',
		'edit',
		'toggle',
		'copy',
		'delete'
	)
);

echo $this->Infinitas->adminIndexHead($filterOptions, $massActions);
?>
<div class="dashboard">
	<?php
		if(!empty($images)) {
			echo $this->Form->input('all', array('label' => __('Select all'), 'type' => 'checkbox'));
		}
		echo '<div class="images">';

			foreach ($shopImages as $shopImage) { ?>
				<div class="image">
					<span><?php echo String::truncate($shopImage['ShopImage']['image'], 25); ?></span>
					<?php
						echo $this->Html->link(
							$this->Html->image(
								$shopImage['ShopImage']['image_small'],
								array(
									'width' => '100px',
									'class' => 'img'
								)
							),
							$shopImage['ShopImage']['image_full'],
							array(
								'class' => 'thickbox',
								'escape' => false,
								'title' => sprintf(' :: %s', $shopImage['ShopImage']['image'])
							)
						);
					?>
					<div class="name">
						<?php 
							echo $this->Infinitas->massActionCheckBox($shopImage) . 
								$this->Html->link($this->Text->truncate($shopImage['ShopImage']['image'], 20), array(
									'action' => 'edit', 
									$shopImage['ShopImage']['id']
								)); 
						?>
					</div>
					<div class="info">
						<?php $shopImage['ShopImage']['active'] = 1; ?>
						<span><?php echo $this->Infinitas->status($shopImage['ShopImage']['active'], $shopImage['ShopImage']['id']); ?></span>
						<span class="help" title="<?php echo __('File'), ' :: ', $shopImage['ShopImage']['image']; ?>"></span>
					</div>
				</div><?php
			}
		echo '</div>';
        echo $this->Form->end(); ?>
</div>
<?php echo $this->element('pagination/admin/navigation'); ?>