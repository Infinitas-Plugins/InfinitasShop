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
echo $this->Form->create(false, array('action' => 'mass'));

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
					$this->Paginator->sort('ShopImage.id', __d('shop', 'Image')),
					$this->Paginator->sort('rating'),
					$this->Paginator->sort('rating_count', __d('shop', 'Ratings')) => array(
						'style' => 'width:50px;'
					),
					$this->Paginator->sort('views'),
					$this->Paginator->sort('sales'),
					$this->Paginator->sort('ShopSupplier.name', __d('shop', 'Supplier')),
					$this->Paginator->sort('ShopProductType.name', __d('shop', 'Type')),
					$this->Paginator->sort('active') => array(
						'style' => 'width:50px;'
					),
					$this->Paginator->sort('created') => array(
						'style' => 'width:75px;'
					),
					$this->Paginator->sort('modified') => array(
						'style' => 'width:75px;'
					),
				)
			);

			foreach ($shopProducts as $shopProduct) { ?>
				<tr class="<?php echo $this->Infinitas->rowClass(); ?>">
					<td><?php echo $this->Infinitas->massActionCheckBox($shopProduct); ?>&nbsp;</td>
					<td title="<?php echo $shopProduct['ShopProduct']['slug']; ?>"><?php echo $this->Html->adminQuickLink($shopProduct['ShopProduct']); ?>&nbsp;</td>
					<td>
						<?php echo $this->Html->link($shopProduct['ShopImage']['id'], array('controller' => 'shop_images', 'action' => 'view', $shopProduct['ShopImage']['id'])); ?>
					</td>
					<td><?php echo $shopProduct['ShopProduct']['rating']; ?>&nbsp;</td>
					<td><?php echo $shopProduct['ShopProduct']['rating_count']; ?>&nbsp;</td>
					<td><?php echo $shopProduct['ShopProduct']['views']; ?>&nbsp;</td>
					<td><?php echo $shopProduct['ShopProduct']['sales']; ?>&nbsp;</td>
					<td>
						<?php echo $this->Html->link($shopProduct['ShopSupplier']['name'], array('controller' => 'shop_suppliers', 'action' => 'view', $shopProduct['ShopSupplier']['id'])); ?>
					</td>
					<td>
						<?php echo $this->Html->link($shopProduct['ShopProductType']['name'], array('controller' => 'shop_product_types', 'action' => 'view', $shopProduct['ShopProductType']['id'])); ?>
					</td>
					<td><?php echo $this->Infinitas->status($shopProduct['ShopProduct']['active']); ?>&nbsp;</td>
					<td><?php echo $this->Infinitas->date($shopProduct['ShopProduct']); ?>&nbsp;</td>
					<td><?php echo $this->Infinitas->date($shopProduct['ShopProduct']); ?>&nbsp;</td>
				</tr><?php
			}
		?>
	</table>
	<?php echo $this->Form->end(); ?>
</div>
<?php echo $this->element('pagination/admin/navigation'); ?>