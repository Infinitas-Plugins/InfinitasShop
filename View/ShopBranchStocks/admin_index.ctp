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
	)
);

echo $this->Infinitas->adminIndexHead($filterOptions, $massActions);
echo $this->Filter->alphabetFilter('Shop.ShopProduct');
?>
<div class="table">
	<table class="listing" cellpadding="0" cellspacing="0">
		<?php
			$cols = array();
			foreach($shopBranches as $shopBranchId => $shopBranch) {
				$link = $this->Html->link($shopBranch, array(
					'controller' => 'shop_branches',
					'action' => 'edit',
					$shopBranchId
				));

				$cols[$link] = array(
					'style' => 'width: 125px'
				);
			}
			echo $this->Infinitas->adminTableHeader(array_merge(
				array(
					$this->Paginator->sort('ShopProduct.name', __d('shop', 'Product')),
				),
				$cols
			));

			foreach ($shopBranchStocks as $shopBranchStock) { ?>
				<tr class="<?php echo $this->Infinitas->rowClass(); ?>">
					<td>
						<?php 
							echo $this->Html->link($shopBranchStock['ShopProduct']['name'], array(
								'controller' => 'shop_products', 
								'action' => 'edit', 
								$shopBranchStock['ShopProduct']['id']
							)); 
						?>&nbsp;
					</td> 
					<?php
						foreach($shopBranches as $shopBranchId => $shopBranch) {
							$stock = !empty($shopBranchStock['ShopBranchStock'][$shopBranchId]) ? $shopBranchStock['ShopBranchStock'][$shopBranchId] : '-';
							echo sprintf('<td>%s&nbsp;</td>', $this->Html->link(
								$this->Shop->stockValue($shopBranchStock['ShopBranchStock'][$shopBranchId], $shopBranchStock['ShopProduct']['selling']),
								array(
									'controller' => 'shop_branch_stock_logs',
									'action' => 'index',
									'ShopBranchStockLog.shop_branch_stock_id' => $shopBranchId
								),
								array('escape' => false)
							));
						}
					?>
				</tr><?php
			}
		?>
	</table>
	<?php echo $this->Form->end(); ?>
</div>
<?php echo $this->element('pagination/admin/navigation'); ?>