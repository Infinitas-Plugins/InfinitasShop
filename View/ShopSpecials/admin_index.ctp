<?php
/**
 * Add some documentation for this index form.
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
?>
<table class="listing">
	<?php
		echo $this->Infinitas->adminTableHeader(array(
			$this->Form->checkbox('all') => array(
				'class' => 'first'
			),
			$this->Paginator->sort('name'),
			$this->Paginator->sort('amount'),
			$this->Paginator->sort('free_shipping'),
			$this->Paginator->sort('start_date') => array(
				'style' => 'width:150px;'
			),
			$this->Paginator->sort('end_date') => array(
				'style' => 'width:150px;'
			),
			$this->Paginator->sort('active') => array(
				'style' => 'width:50px;'
			),
			$this->Paginator->sort('modified') => array(
				'style' => 'width:100px;'
			),
		));

		foreach ($shopSpecials as $shopSpecial) { ?>
			<tr>
				<td><?php echo $this->Infinitas->massActionCheckBox($shopSpecial); ?>&nbsp;</td>
				<td><?php echo $this->Infinitas->adminQuickLink($shopSpecial['ShopSpecial']); ?>&nbsp;</td>
				<td>
					<?php
						if ($shopSpecial['ShopSpecial']['discount']) {
							echo CakeNumber::toPercentage($shopSpecial['ShopSpecial']['amount']);
						} else {
							echo $this->Shop->adminCurrency($shopSpecial['ShopSpecial']['amount']);
						}
					?>&nbsp;
				</td>
				<td>
					<?php
						echo $this->Infinitas->status($shopSpecial['ShopSpecial']['free_shipping'], array(
							'title_yes' => __d('shop', 'Free shipping :: This special gives the customer free shipping'),
							'title_no' => __d('shop', 'Paid shipping :: This does not provide free shipping')
						));
					?>&nbsp;
				</td>
				<td><?php echo $this->Infinitas->date($shopSpecial['ShopSpecial']['start_date'], 'nice'); ?></td>
				<td><?php echo $this->Infinitas->date($shopSpecial['ShopSpecial']['end_date'], 'nice'); ?></td>
				<td><?php echo $this->Infinitas->status($shopSpecial['ShopSpecial']['active']); ?>&nbsp;</td>
				<td><?php echo $this->Infinitas->date($shopSpecial['ShopSpecial']); ?>&nbsp;</td>
			</tr><?php
		}
	?>
</table>
<?php
	echo $this->Form->end();
	echo $this->element('pagination/admin/navigation');