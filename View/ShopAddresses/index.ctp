<?php
/**
 * Index view for addresses
 *
 * @copyright Copyright (c) 2009 Carl Sutton (dogmatic69)
 *
 * @link http://infinitas-cms.org/Shop
 * @package Shop.View.index
 * @license http://infinitas-cms.org/mit-license The MIT License
 * @since 0.9b1
 *
 * @author Carl Sutton <dogmatic69@infinitas-cms.org>
 */

echo $this->element('Shop.profile/header');
?>
<table class="listing">
	<?php
		echo $this->Infinitas->adminTableHeader(array(
			$this->Paginator->sort('name'),
			$this->Paginator->sort('address_1', __d('shop', 'Address')),
			$this->Paginator->sort('GeoLocationRegion.name', __d('geo_location', 'Region')),
			$this->Paginator->sort('GeoLocationCountry.name', __d('geo_location', 'Country')),
			__d('infinitas', 'Actions'),
		), false);

		foreach ($shopAddresses as $shopAddress) { ?>
			<tr>
				<td><?php echo $this->Html->adminQuickLink($shopAddress['ShopAddress']); ?>&nbsp;</td>
				<td><?php echo h(implode(', ', array($shopAddress['ShopAddress']['address_1'], $shopAddress['ShopAddress']['address_2'], $shopAddress['ShopAddress']['post_code']))); ?></td>
				<td><?php echo $shopAddress['GeoLocationRegion']['name']; ?></td>
				<td><?php echo $shopAddress['GeoLocationCountry']['name']; ?></td>
				<td>
					<?php
						echo $this->Html->link(__d('infinitas', 'Delete'), array(
							'action' => 'delete',
							$shopAddress['ShopAddress']['id']
						));
					?>
				</td>
			</tr><?php
		}
	?>
</table>
<?php
	echo $this->element('pagination/navigation');