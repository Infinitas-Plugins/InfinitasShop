<?php
	class ShopUnitsController extends ShopAppController {
		public function admin_index() {
			$this->Paginator->settings = array(
				'fields' => array(
					$this->modelClass . 'id',
					$this->modelClass . 'name',
					$this->modelClass . 'slug',
					$this->modelClass . 'symbol',
					$this->modelClass . 'description',
					$this->modelClass . 'product_count',
					$this->modelClass . 'active',
					$this->modelClass . 'modified',
				),
				'contain' => false
			);

			$units = $this->Paginator->paginate(
				null,
				$this->Filter->filter
			);

			$filterOptions = $this->Filter->filterOptions;
			$filterOptions['fields'] = array(
				'name'
			);
			$this->set(compact('units','filterOptions'));
		}
	}