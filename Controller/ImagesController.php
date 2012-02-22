<?php
	class ImagesController extends ShopAppController {
		/**
		 * 
		 */
		public function admin_index(){
			$this->Paginator->settings = array(
				'fields' => array(
					'Image.id',
					'Image.image',
					'Image.ext',
					'Image.width',
					'Image.height',
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