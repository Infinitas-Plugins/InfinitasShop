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
));
echo $this->Filter->alphabetFilter('Shop.ShopProduct');
?>
<table class="listing">
	<?php
		$cols = array();
		foreach($shopBranches as $shopBranchId => $shopBranch) {
			$link = $this->Html->link($shopBranch, array(
				'controller' => 'shop_branches',
				'action' => 'edit',
				$shopBranchId
			));

			$cols[$link] = array(
				'style' => 'width: 90px'
			);
		}
		$cols[__d('shop', 'Total')] = array(
			'style' => 'width: 110px'
		);
		echo $this->Infinitas->adminTableHeader(array_merge(
			array(
				$this->Paginator->sort('ShopProduct.name', __d('shop', 'Product')),
			),
			$cols
		));

		foreach ($shopBranchStocks as $shopBranchStock) { ?>
			<tr>
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
					$stock = $value = 0;
					foreach($shopBranches as $shopBranchId => $shopBranch) {
						$shopBranchStock['ShopBranchStock'][$shopBranchId] = !empty($shopBranchStock['ShopBranchStock'][$shopBranchId]) ? $shopBranchStock['ShopBranchStock'][$shopBranchId] : 0;
						echo sprintf('<td>%s&nbsp;</td>', $this->Html->link(
							$this->Shop->stockValue($shopBranchStock['ShopBranchStock'][$shopBranchId], $shopBranchStock['ShopProduct']['selling']),
							array(
								'controller' => 'shop_branch_stock_logs',
								'action' => 'index',
								'ShopBranchStockLog.shop_branch_stock_id' => $shopBranchId
							),
							array('escape' => false)
						));

						$stock += $shopBranchStock['ShopBranchStock'][$shopBranchId];
						$value += $shopBranchStock['ShopProduct']['selling'];
					}
					echo sprintf('<td>%s&nbsp;</td>', $this->Shop->stockValue($stock, $value));
				?>
			</tr><?php
		}
	?>
</table>
<?php
	echo $this->Form->end();
	echo $this->element('pagination/admin/navigation');