<?php
	class UnitsController extends ShopAppController {
		public function admin_index() {
			$this->Paginator->settings = array(
				'fields' => array(
					'Unit.id',
					'Unit.name',
					'Unit.slug',
					'Unit.symbol',
					'Unit.description',
					'Unit.product_count',
					'Unit.active',
					'Unit.modified',
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