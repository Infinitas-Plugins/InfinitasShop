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
echo $this->Filter->alphabetFilter();
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
					$this->Paginator->sort('ShopProductType.name', __d('shop', 'Type')),
					$this->Paginator->sort('ShopBrand.name', __d('shop', 'Brand')),
					$this->Paginator->sort('ShopPrice.selling', __d('shop', 'Price')) => array(
						'style' => 'width:60px;'
					),
					__d('shop', 'Markup') => array(
						'style' => 'width:60px;'
					),
					$this->Paginator->sort('total_stock', __d('shop', 'Stock')) => array(
						'style' => 'width:80px;'
					),
					$this->Paginator->sort('modified') => array(
						'style' => 'width:100px;'
					),
					$this->Paginator->sort('active', __d('shop', 'Status')) => array(
						'style' => 'width:50px;'
					),
				)
			);

			foreach ($shopProducts as $shopProduct) {
				$rowClass = $this->Infinitas->rowClass(); ?>
            	<tr class="parent <?php echo $rowClass; ?>">
					<td>
						<?php 
							echo '<span class="toggle"><a href="#">+</a></span>',
							$this->Infinitas->massActionCheckBox($shopProduct); 
						?>&nbsp;
					</td>
					<td>
						<?php 
							echo sprintf('%s<br/>%s', 
								$this->Html->adminQuickLink($shopProduct['ShopProduct']),
								$shopProduct['ShopImage']['id']
							);
						?>&nbsp;
					</td>
					<td>
						<?php 
							echo $this->Html->link($shopProduct['ShopProductType']['name'], array(
								'controller' => 'shop_product_types', 
								'action' => 'edit', 
								$shopProduct['ShopProductType']['id']
							)); 
						?>&nbsp;
					</td>
					<td>
						<?php 
							echo $this->Html->link($shopProduct['ShopBrand']['name'], array(
								'controller' => 'shop_brands', 
								'action' => 'edit', 
								$shopProduct['ShopBrand']['id']
							)); 
						?>&nbsp;
					</td>
					<td><?php echo $this->Shop->adminPrice($shopProduct['ShopPrice']); ?>&nbsp;</td>
					<td><?php echo $this->Shop->adminMarkup($shopProduct['ShopPrice']); ?>&nbsp;</td>
					<td>
						<?php
							echo $this->Html->link(
								$this->Shop->stockValue($shopProduct['ShopProduct']['total_stock'], $shopProduct['ShopPrice']['selling']),
								array(
									'controller' => 'shop_branch_stock_logs',
									'action' => 'index',
									'ShopBranchStockLog.shop_product_id' => $shopProduct['ShopProduct']['id']
								),
								array('escape' => false)
							);
						?>&nbsp;
					</td>
					<td><?php echo $this->Infinitas->date($shopProduct['ShopProduct']); ?>&nbsp;</td>
					<td><?php echo $this->Shop->adminStatus($shopProduct); ?>&nbsp;</td>
				</tr>
				<tr class="details <?php echo $rowClass; ?>">
					<td colspan="2">
						<?php 
							echo $this->Html->link($shopProduct['ShopSupplier']['name'], array(
								'controller' => 'shop_suppliers', 
								'action' => 'edit', 
								$shopProduct['ShopSupplier']['id']
							)); 
						?>&nbsp;
					</td>
					<td><?php echo __d('shop', '%d views', (int)$shopProduct['ShopProduct']['views']); ?>&nbsp;</td>
					<td>
						<?php 
							echo __d('shop', '%s from %d', $shopProduct['ShopProduct']['rating'], $shopProduct['ShopProduct']['rating_count']); 
						?>&nbsp;
					</td>
					<td colspan="100">
						<?php
							echo $this->element('Shop.expanded/sales', array('data' => $shopProduct));
							echo $this->element('Shop.expanded/seo', array('data' => $shopProduct));
							echo $this->element('Shop.expanded/views', array('data' => $shopProduct));
						?>
					</td>
				</tr><?php
			}
		?>
	</table>
	<?php echo $this->Form->end(); ?>
</div>
<?php echo $this->element('pagination/admin/navigation'); ?>