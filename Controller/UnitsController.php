<?php
	class UnitsController extends ShopAppController{
		var $name = 'Units';

		var $helpers = array(
			'Filter.Filter'
		);

		function admin_index(){
			$this->paginate = array(
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

			$units = $this->paginate(
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