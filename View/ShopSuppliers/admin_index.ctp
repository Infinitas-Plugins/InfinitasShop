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
echo $this->Infinitas->adminIndexHead($filterOptions, array(
	'add',
	'edit',
	'toggle',
	'copy',
	'delete'
));
echo $this->Filter->alphabetFilter();
?>
<table class="listing">
	<?php
		echo $this->Infinitas->adminTableHeader(array(
			$this->Form->checkbox('all') => array(
				'class' => 'first'
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
				'style' => 'width:100px;'
			),
		));

		foreach ($shopSuppliers as $shopSupplier) { ?>
			<tr>
				<td><?php echo $this->Infinitas->massActionCheckBox($shopSupplier); ?>&nbsp;</td>
				<td>
					<?php
						echo sprintf('%s<br/>%s',
							$this->Html->image($shopSupplier['ShopSupplier']['logo_thumb'], array('width' => 75)),
							$this->Html->adminQuickLink($shopSupplier['ShopSupplier'], array('action' => 'edit'))
						);
					?>&nbsp;
				</td>
				<td><?php echo $this->Text->autoLinkEmails($shopSupplier['ShopSupplier']['email']); ?>&nbsp;</td>
				<td><?php echo $shopSupplier['ShopSupplier']['phone']; ?>&nbsp;</td>
				<td><?php echo $this->Design->count($shopSupplier['ShopSupplier']['product_count']); ?>&nbsp;</td>
				<td><?php echo $shopSupplier['ShopSupplier']['terms']; ?>&nbsp;</td>
				<td>
					<?php
						echo $this->Infinitas->status($shopSupplier['ShopSupplier']['active'], array(
							'title_yes' => __d('shop', 'Status :: Supplier is active'),
							'title_no' => __d('shop', 'Status :: Supplier is disabled, products will no longer be displayed'),
						));
					?>&nbsp;
				</td>
				<td><?php echo $this->Infinitas->date($shopSupplier['ShopSupplier']); ?></td>
			</tr><?php
		}
	?>
</table>
<?php
	echo $this->Form->end();
	echo $this->element('pagination/admin/navigation');