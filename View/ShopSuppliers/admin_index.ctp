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
					$this->Paginator->sort('name'),
					$this->Paginator->sort('email'),
					$this->Paginator->sort('phone'),
					$this->Paginator->sort('product_count', __d('shop', 'Products')) => array(
						'style' => 'width:75px;'
					),
					$this->Paginator->sort('terms'),
					$this->Paginator->sort('active') => array(
						'style' => 'width:50px;'
					),
					$this->Paginator->sort('modified') => array(
						'style' => 'width:75px;'
					),
				)
			);

			foreach ($shopSuppliers as $shopSupplier) { ?>
				<tr class="<?php echo $this->Infinitas->rowClass(); ?>">
					<td><?php echo $this->Infinitas->massActionCheckBox($shopSupplier); ?>&nbsp;</td>
					<td>
						<?php 
							echo $this->Html->image($shopSupplier['ShopSupplier']['logo_thumb'], array('width' => 75));
							echo $this->Html->adminQuickLink($shopSupplier['ShopSupplier'], array('action' => 'edit')); 
						?>&nbsp;
					</td>
					<td><?php echo $this->Text->autoLinkEmails($shopSupplier['ShopSupplier']['email']); ?>&nbsp;</td>
					<td><?php echo $shopSupplier['ShopSupplier']['phone']; ?>&nbsp;</td>
					<td><?php echo $shopSupplier['ShopSupplier']['product_count']; ?>&nbsp;</td>
					<td><?php echo $shopSupplier['ShopSupplier']['terms']; ?>&nbsp;</td>
					<td>
						<?php 
							echo $this->Infinitas->status($shopSupplier['ShopSupplier']['active'], array(
								'title_yes' => __d('shop', 'Status :: Supplier is active'),
								'title_no' => __d('shop', 'Status :: Supplier is disabled, products will no longer be displayed'),
							)); 
						?>&nbsp;
					</td>
					<td><?php echo $this->Infinitas->date($shopSupplier['ShopSupplier']); ?>&nbsp;</td>
				</tr><?php
			}
		?>
	</table>
	<?php echo $this->Form->end(); ?>
</div>
<?php echo $this->element('pagination/admin/navigation'); ?>