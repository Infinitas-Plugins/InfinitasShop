<?php
	class ShopStocksController extends ShopAppController {
		public function admin_index() {
			$this->Paginator->settings = array(
				'contain' => array(
					'Product' => array(
						'ShopCategory'
					),
					'ShopBranch' => array(
						'BranchDetail'
					)
				)
			);

			$filterOptions = $this->Filter->filterOptions;
			$filterOptions['fields'] = array(
				'branch_id' => $this->{$this->modelClass}->ShopBranch->branchList()
			);

			$stocks = $this->Paginator->paginate($this->modelClass);
			$this->set(compact('stocks', 'filterOptions'));
		}

		public function admin_add() {
			if (!empty($this->data)) {
				$current = $this->{$this->modelClass}->find(
					'first',
					array(
						'conditions' => array(
							'Stock.branch_id' => $this->data[$this->modelClass]['branch_id'],
							'Stock.product_id' => $this->data[$this->modelClass]['product_id']
						)
					)
				);

				if(isset($current[$this->modelClass]['stock'])) {
					$this->data[$this->modelClass]['id'] = $current[$this->modelClass]['id'];
					$this->data[$this->modelClass]['stock'] += $current[$this->modelClass]['stock'];
				}
				else{
					$this->{$this->modelClass}->create();
				}

				if ($this->{$this->modelClass}->save($this->data)) {
					$this->notice('saved');
				}
			}

			$branches = $this->{$this->modelClass}->ShopBranch->branchList();
			$products = $this->{$this->modelClass}->Product->find('list');
			$this->set(compact('branches', 'products'));
		}

		public function admin_edit() {

		}

		public function admin_valuation($branch_id = null) {

		}
	}