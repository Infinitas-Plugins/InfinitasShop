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
		'delete',

		// other methods available
		// 'unlock',
	)
);

echo $this->Infinitas->adminIndexHead($filterOptions, $massActions);
?>
<div class="table">
	<table class="listing" cellpadding="0" cellspacing="0">
		<?php
			echo $this->Infinitas->adminTableHeader(
				array(
					$this->Form->checkbox('all') => array(
						'class' => 'first',
						'style' => 'width:25px;'
					),
					$this->Paginator->sort('manager_id'),
					$this->Paginator->sort('active'),
					$this->Paginator->sort('ordering'),
					$this->Paginator->sort('modified')
				)
			);

			foreach ($shopBranches as $shopBranch) { ?>
				<tr class="<?php echo $this->Infinitas->rowClass(); ?>">
					<td><?php echo $this->Infinitas->massActionCheckBox($shopBranch); ?>&nbsp;</td>
					<td>
						<?php 
							echo $this->Hmtl->link($shopBranch['Manager']['full_name'], array(
								'plugin' => 'users',
								'controller' => 'users',
								'action' => 'edit',
								$shopBranch['Manager']['id']
							)); 
						?>&nbsp;
					</td>
					<td><?php echo $this->Infinitas->ordering($shopBranch['ShopBranch']['ordering']); ?>&nbsp;</td>
					<td><?php echo $this->Infinitas->status($shopBranch['ShopBranch']['active']); ?>&nbsp;</td>
					<td><?php echo $this->Infinitas->date($shopBranch['ShopBranch']); ?>&nbsp;</td>
				</tr><?php
			}
		?>
	</table>
	<?php echo $this->Form->end(); ?>
</div>
<?php echo $this->element('pagination/admin/navigation'); ?>