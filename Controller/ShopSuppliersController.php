<?php
	class ShopSuppliersController extends ShopAppController {
		public function admin_index() {
			$this->Paginator->settings = array(
				'fields' => array(
					$this->modelClass . '.id',
					$this->modelClass . '.name',
					$this->modelClass . '.slug',
					$this->modelClass . '.phone',
					$this->modelClass . '.fax',
					$this->modelClass . '.logo',
					$this->modelClass . '.product_count',
					$this->modelClass . '.terms',
					$this->modelClass . '.active',
					$this->modelClass . '.modified'
				),
				'contain' => false
			);

			$suppliers = $this->Paginator->paginate(
				null,
				$this->Filter->filter
			);

			$filterOptions = $this->Filter->filterOptions;
			$filterOptions['fields'] = array(
				'name',
				'terms' => (array)Configure::read('Shop.payment_terms'),
				'active' => (array)Configure::read('CORE.active_options')
			);
			$this->set(compact('suppliers', 'filterOptions'));
		}

		public function admin_add() {
			parent::admin_add();

			$addresses = $this->{$this->modelClass}->Address->find('list');
			$this->set(compact('addresses'));
		}

		public function admin_edit($id = null) {
			parent::admin_edit($id);

			$addresses = $this->{$this->modelClass}->Address->find('list');
			$this->set(compact('addresses'));
		}
	}