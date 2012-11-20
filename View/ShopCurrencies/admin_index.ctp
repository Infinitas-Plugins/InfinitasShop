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
	'update',
	'delete',
));
echo $this->Filter->alphabetFilter();
?>
<table class="listing">
	<?php
		echo $this->Infinitas->adminTableHeader(
			array(
				$this->Form->checkbox('all') => array(
					'class' => 'first'
				),
				$this->Paginator->sort('name'),
				$this->Paginator->sort('code'),
				$this->Paginator->sort('factor', __d('shop', 'Exchange Rate')),
				__d('shop', 'Positive'),
				__d('shop', 'Negative'),
				__d('shop', 'Zero'),
				__d('shop', 'HTML'),
				__d('shop', 'Default'),
				$this->Paginator->sort('modified') => array(
					'style' => 'width:75px;'
				),
			)
		);

		App::uses('ShopCurrencyLib', 'Shop.Lib');
		$currentCurrency = ShopCurrencyLib::getCurrency();
		foreach ($shopCurrencies as $shopCurrency) { ?>
			<tr>
				<td><?php echo $this->Infinitas->massActionCheckBox($shopCurrency); ?>&nbsp;</td>
				<td><?php echo $this->Html->adminQuickLink($shopCurrency['ShopCurrency']); ?>&nbsp;</td>
				<td><?php echo $shopCurrency['ShopCurrency']['code']; ?>&nbsp;</td>
				<td><?php echo $shopCurrency['ShopCurrency']['factor']; ?>&nbsp;</td>
				<td><?php echo $this->Shop->currency(5000, $shopCurrency['ShopCurrency']['code']); ?>&nbsp;</td>
				<td><?php echo $this->Shop->currency(-5000, $shopCurrency['ShopCurrency']['code']); ?>&nbsp;</td>
				<td><?php echo $this->Shop->currency(0, $shopCurrency['ShopCurrency']['code']); ?>&nbsp;</td>
				<td><?php echo h($this->Shop->currency(5000, $shopCurrency['ShopCurrency']['code'])); ?>&nbsp;</td>
				<td>
					<?php
						echo $this->Infinitas->status((float)$shopCurrency['ShopCurrency']['factor'] == 1, array(
							'title_yes' => __d('shop', 'Default :: This is configured as the store default'),
							'title_no' => __d('shop', 'Default :: This is not the default currency'),
						));
					?>&nbsp;
				</td>
				<td><?php echo $this->Infinitas->date($shopCurrency['ShopCurrency']); ?></td>
			</tr><?php
		}
	?>
</table>
<?php
	echo $this->Form->end();
	echo $this->element('pagination/admin/navigation');