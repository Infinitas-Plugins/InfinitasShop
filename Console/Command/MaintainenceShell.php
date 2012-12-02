<?php
/**
 * maintainence shell for the shop plugin
 *
 * @property ShopProduct $ShopProduct
 */
class MaintainenceShell extends AppShell {
	public $uses = array(
		'Shop.ShopProduct'
	);

	public function main() {

	}

/**
 * delete all products and relations to the product
 *
 * @throws Exception
 */
	public function clear_products() {
		try {
			$ids = $this->ShopProduct->find('list', array(
				'fields' => array(
					$this->ShopProduct->alias . '.' . $this->ShopProduct->primaryKey,
					$this->ShopProduct->alias . '.shop_image_id'
				),
				'contain' => false
			));
			$this->ShopProduct->unbindModel(array(
				'hasOne' => array('ShopCurrentSpecial')
			), false);

			$Folder = new Folder();
			foreach (array_keys($ids) as $id) {
				$this->ShopProduct->delete($id);
				$this->ShopProduct->ShopImage->delete($ids[$id]);

				$folder = APP . 'webroot' . DS . 'files' . DS . 'shop_image' . DS . 'image' . DS . $ids[$id];
				$Folder->delete($folder);
			}
		} catch(Exception $e) {
			$this->quit($e->getMessage());
			throw $e;
		}

		$this->quit('All products removed');
	}

}
