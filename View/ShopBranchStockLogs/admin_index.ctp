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

$massActions = $this->Infinitas->massActionButtons(array('delete'));

echo $this->Infinitas->adminIndexHead(null, $massActions);
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
					$this->Paginator->sort('ShopProduct.name', __d('shop', 'Product')),
					$this->Paginator->sort('ShopBranch.name', __d('shop', 'Branch')),
					$this->Paginator->sort('change') => array(
						'style' => 'width:100px;'
					),
					$this->Paginator->sort('notes'),
					$this->Paginator->sort('created') => array(
						'style' => 'width:75px;'
					),
				)
			);

			foreach ($shopBranchStockLogs as $shopBranchStockLog) { ?>
				<tr class="<?php echo $this->Infinitas->rowClass(); ?>">
					<td><?php echo $this->Infinitas->massActionCheckBox($shopBranchStockLog); ?>&nbsp;</td>
					<td><?php echo $shopBranchStockLog['ShopProduct']['name']; ?>&nbsp;</td>
					<td><?php echo $shopBranchStockLog['ContactBranch']['name']; ?>&nbsp;</td>
					<td><?php echo $shopBranchStockLog['ShopBranchStockLog']['change']; ?>&nbsp;</td>
					<td><?php echo $shopBranchStockLog['ShopBranchStockLog']['notes']; ?>&nbsp;</td>
					<td><?php echo $this->Infinitas->date($shopBranchStockLog['ShopBranchStockLog']); ?>&nbsp;</td>
				</tr><?php
			}
		?>
	</table>
	<?php echo $this->Form->end(); ?>
</div>
<?php echo $this->element('pagination/admin/navigation'); ?>