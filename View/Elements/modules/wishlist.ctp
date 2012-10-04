<div>
	<?php
		$userId = AuthComponent::user('id');
		if(!isset($usersWishlist)) {
			$usersWishlist = Cache::read(cacheName('wishlist', $userId));

			if($usersWishlist === false) {
				$usersWishlist = ClassRegistry::init('Shop.Wishlist')->getWishlistData($userId);
			}
		}

		if(empty($usersWishlist)) {
			echo __d('shop', 'Your wishlist is empty');
		}
		else{
			?>
				<table>
					<tr>
						<th><?php echo __d('shop', 'Product' ) ?></th>
						<th style="width:50px;"><?php echo __d('shop', 'Price' ) ?></th>
					</tr>
					<?php
						foreach((array)$usersWishlist as $wishlistItem) {
							$wishlistItem['Product']['plugin'] = 'shop';
							$wishlistItem['Product']['controller'] = 'products';
							$wishlistItem['Product']['action'] = 'view';
							$eventData = $this->Event->trigger('Shop.slugUrl', array('type' => 'products', 'data' => $wishlistItem['Product']));

							$productLink = $this->Html->link(
								$wishlistItem['Wishlist']['name'],
								current($eventData['slugUrl'])
							);
							?>
								<tr>
									<td><?php echo $productLink; ?>&nbsp;</td>
									<td><?php echo $this->Shop->currency($wishlistItem['Wishlist']['price']); ?>&nbsp;</td>
								</tr>
							<?php
						}
					?>
					<tr>
						<td colspan="2">
							<?php
								if(AuthComponent::user('id') > 0) {
									echo $this->Html->link(
										__d('shop', 'Manage'),
										array(
											'plugin' => 'shop',
											'controller' => 'wishlists',
											'action' => 'index'
										)
									);
								}
								else{
									echo __d('shop', 'You must be logged in to manage your wishlist');
								}
							?>&nbsp;
						</td>
					</tr>
				</table>
			<?php
		}
	?>
</div>