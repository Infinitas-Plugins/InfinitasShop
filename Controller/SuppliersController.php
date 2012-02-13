<?php
	class SuppliersController extends ShopAppController{
		var $name = 'Suppliers';

		var $helpers = array(
			'Filter.Filter'
		);

		function admin_index(){
			$this->paginate = array(
				'fields' => array(
					'Supplier.id',
					'Supplier.name',
					'Supplier.slug',
					'Supplier.phone',
					'Supplier.fax',
					'Supplier.logo',
					'Supplier.product_count',
					'Supplier.terms',
					'Supplier.active',
					'Supplier.modified'
				),
				'contain' => false
			);

			$suppliers = $this->paginate(
				null,
				$this->Filter->filter
			);

			$filterOptions = $this->Filter->filterOptions;
			$filterOptions['fields'] = array(
				'name',
				'terms' => (array)Configure::read('Shop.payment_terms'),
				'active' => (array)Configure::read('CORE.active_options')
			);
			$this->set(compact('suppliers','filterOptions'));
		}

		function admin_add(){
			parent::admin_add();

			$addresses = $this->Supplier->Address->find('list');
			$this->set(compact('addresses'));
		}

		function admin_edit($id = null){
			parent::admin_edit($id);

			$addresses = $this->Supplier->Address->find('list');
			$this->set(compact('addresses'));
		}
	}