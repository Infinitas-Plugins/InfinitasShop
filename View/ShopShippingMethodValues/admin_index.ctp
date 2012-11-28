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

echo $this->Form->create(null, array('url' => array('action' => 'mass') + $this->request->params['named']));
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
			$this->Paginator->sort('delivery_time') => array(
				'class' => 'large'
			),
			$this->Paginator->sort('surcharge') => array(
				'class' => 'large'
			),
			$this->Paginator->sort('total_minimum', __d('shop', 'Order Min')) => array(
				'class' => 'large'
			),
			$this->Paginator->sort('total_maximum', __d('shop', 'Order Max')) => array(
				'class' => 'large'
			),
			$this->Paginator->sort('require_login', __d('shop', 'Guests')) => array(
				'class' => 'small'
			),
			$this->Paginator->sort('modified') => array(
				'class' => 'date'
			),
			$this->Paginator->sort('active') => array(
				'class' => 'small'
			),
		));

		foreach ($shopShippingMethodValues as $value) { ?>
			<tr>
				<td><?php echo $this->Infinitas->massActionCheckBox($value); ?>&nbsp;</td>
				<td><?php echo $this->Html->adminQuickLink($value['ShopShippingMethodValue']); ?>&nbsp;</td>
				<td><?php echo $this->Shop->timeEstimate($value['ShopShippingMethodValue']['delivery_time']); ?>&nbsp;</td>
				<td>
					<?php
						if(!$value['ShopShippingMethodValue']['surcharge']) {
							echo '-';
						} else {
							echo $this->Shop->adminCurrency($value['ShopShippingMethodValue']['surcharge']);
						}
					?>&nbsp;
				</td>
				<td>
					<?php
						if(!$value['ShopShippingMethodValue']['total_minimum']) {
							echo '-';
						} else {
							echo $this->Shop->adminCurrency($value['ShopShippingMethodValue']['total_minimum']);
						}
					?>&nbsp;
				</td>
				<td>
					<?php
						if(!$value['ShopShippingMethodValue']['total_maximum']) {
							echo '-';
						} else {
							echo $this->Shop->adminCurrency($value['ShopShippingMethodValue']['total_maximum']);
						}
					?>&nbsp;
				</td>
				<td>
					<?php
						echo $this->Infinitas->status(!$value['ShopShippingMethodValue']['require_login'], array(
							'title_yes' => __d('infinitas', 'Login :: This shipping option is available for all users'),
							'title_no' => false
						));
					?>&nbsp;
				</td>
				<td><?php echo $this->Infinitas->date($value['ShopShippingMethodValue']); ?></td>
				<td>
					<?php
						$status = array(
							'title_no' => __d('shop', 'Not Active :: This shipping option value is currently disabled')
						);
						if(!$value['ShopShippingMethod']['active']) {
							$status['title_no'] = __d('shop', 'Not Active :: The shipping option "%s" is currently disabled', $value['ShopShippingMethod']['name']);
						}

						echo $this->Infinitas->status($value['ShopShippingMethodValue']['active'] && $value['ShopShippingMethod']['active'], $status);
					?>&nbsp;
				</td>
			</tr><?php
		}
	?>
</table>
<?php
	echo $this->Form->end();
	echo $this->element('pagination/admin/navigation');