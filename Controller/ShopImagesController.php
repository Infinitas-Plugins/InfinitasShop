<?php
	class ShopImagesController extends ShopAppController {
		/**
		 *
		 */
		public function admin_index() {
			$this->Paginator->settings = array(
				'fields' => array(
					$this->modelClass . '.id',
					$this->modelClass . '.image',
					$this->modelClass . '.ext',
					$this->modelClass . '.width',
					$this->modelClass . '.height',
				),
				'contain' => false,
				'limit' => 24
			);

			$images = $this->Paginator->paginate(
				null,
				$this->Filter->filter
			);

			$filterOptions = $this->Filter->filterOptions;
			$filterOptions['fields'] = array(
				'image',
				'ext',
				'width',
				'height'
			);
			$this->set(compact('images','filterOptions'));
		}
	}