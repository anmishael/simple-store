<?php
/*
 * Created on May 18, 2012
 *
 * @author Mikel Annjuk <anmishael@gmail.com>
 * @comment Designed especially for Kinetoscope Media, Inc.
 * @version 1.0
 */

class Model_Product extends Model_Object {
	var $_data = array();
	var $_model = 'Product';
	var $_table = 'products';
	var $_id = 'id';
	var $_table_desc = 'products_description';
	var $_table_desc_id = 'pdid';
	var $_table_desc_conn_id = 'pid';
	function getFilterByName($name, $language = null) {
		$filter = $this->_core->getModel('Filter/Collection')->newInstance()
			->addTable('products_to_filters', 'p2f')
			->addTable('filter_types', 'ft', array('ft.url as filter_type_url'))
			->addFilter('p2f.product_id', $this->get('id'),'eq')
			->addFilter('p2f.filter_id', 'p2f.filter_id=filters.id','logic')
			->addFilter('ft.id', 'ft.id=filters.type','logic')
			->addFilter('ft.url', $name,'like')
			->getOne(false, true, $language);
		if(!$filter instanceof Model_Filter) {
			$filter = $this->_core->getModel('Filter')->newInstance();
		}
		return $filter;
	}
	function fetchFilters($language = null, $name = null) {
// 		$this->_core->getResource('DB')->getConnection()->debug=1;
		$coll = $this->_core->getModel('Filter/Collection')->newInstance()
			->addTable('products_to_filters', 'p2f')
			->addTable('filter_types', 'ft', array('ft.url as filter_type_url'))
			->addTable('filter_type_description', 'ftd', array('ftd.name as filter_type_name'))
			->addTable('filter_description', 'fd', array('fd.name as filter_name'))
			->addFilter('p2f.product_id', $this->get('id'),'eq')
			->addFilter('p2f.filter_id', 'p2f.filter_id=filters.id','logic')
			->addFilter('ft.id', 'ft.id=filters.type','logic')
			->addFilter('ftd.ftid', 'ftd.ftid=filters.type','logic');
		if($language) {
			if($language instanceof Model_Language) {
				$coll->addFilter('ftd.language', $language->get('id'), 'eq');
				$coll->addFilter('fd.language', $language->get('id'), 'eq');
			} else {
				$coll->addFilter('ftd.language', $this->_core->getModel('Language/Collection')->getCurrentLanguage()->get('id'), 'eq');
				$coll->addFilter('fd.language', $this->_core->getModel('Language/Collection')->getCurrentLanguage()->get('id'), 'eq');
			}
		}
		$coll->setOrder('filter_name');
		$coll->setOrderWay('asc');
//		$this->_core->setDebug(2);
		$this->push(
			'filters',
			$coll->getCollection('id', true, true)
		);
//		$this->_core->setDebug(2);
// 		$this->_core->getResource('DB')->getConnection()->debug=0;
		/*
		 $this->_core->getModel('Filter');
		 if($language) {
			 if($language instanceof Model_Language) {
				 $language = $language->get('id');
			 } elseif(is_bool($language)) {
				 $language = $this->_core->getModel('Language/Collection')->getCurrentLanguage()->get('id');
			 }
			 $sql = 'SELECT f.*, ftd.name as filter_type_name, ft.url as filter_type_url ' .
					 'FROM `filters` f LEFT JOIN (`filter_description` fd) ON (fd.fid=f.id AND fd.language='.(int)$language.'), `products_to_filters` p2f, `filter_types` ft LEFT JOIN(`filter_type_description` ftd) ON (ftd.ftid=ft.id AND ftd.language='.(int)$language.') ' .
					'WHERE ft.status>0 AND f.type=ft.id AND f.`id`=p2f.`filter_id` AND p2f.`product_id`=\'' . $this->get('id') . '\'';
		 } else {
			 $sql = 'SELECT f.*, ft.name as filter_type_name, ft.url as filter_type_url FROM `filters` f, `products_to_filters` p2f, filter_types ft WHERE ft.status>0 AND f.type=ft.id AND f.`id`=p2f.`filter_id` AND p2f.`product_id`=\'' . $this->get('id') . '\'';
		 }
		 $res = $this->_core->getResource('DB')->getConnection()->setQuery($sql)->getResult();
		 $flt = array();
		 foreach($res as $k=>$v) {
			 $flt[$v['id']] = new Model_Filter($v);
		 }
		 $this->set('filters', $flt);
		 //*/
		return $this;
	}
	function fetchBundles() {
		$bundles = $this->_core->getModel('Product/Bundle/Collection')->newInstance()
			->addTable('products_to_bundles', 'p2b')
			->addFilter('p2b', 'p2b.bundle_id=pbid', 'logic')
			->addFilter('p2b.product_id', $this->get($this->_id), 'eq')
			->getCollection();
		if(sizeof($bundles)>0) {
			$this->push('bundles', $bundles);
		}
		return $this;
	}
	function fetchBundle() {
		$bundle = $this->_core->getModel('Product/Bundle/Collection')->newInstance()
			->addTable('products_to_bundles', 'p2b')
			->addFilter('p2b', 'p2b.bundle_id=pbid', 'logic')
			->addFilter('p2b.product_id', $this->get($this->_id), 'eq')
			->addFilter('p2b.bundle_id', $this->get('bundle_id'), 'eq')
			->getOne();
		if($bundle instanceof Model_Product_Bundle) {
			$this->push('bundle', $bundle);
		}
		return $this;
	}
	function appendFilter($filter) {
		if($this->get('id')) {
			$id = false;
			if($filter instanceof Model_Filter) {
				$id = $filter->get($filter->_id);
			} elseif(is_numeric($filter)) {
				$id = $filter;
			}
			if(!$id) {
				$this->_core->raiseError('Could not append filter, missing filter id.');
			} else {
				$data = array('product_id'=>$this->get('id'), 'filter_id'=>$id);
				$this->_core->getResource('DB')->getConnection()->insert('products_to_filters', $data);
			}
		} else {
			$this->_core->raiseError('Could not append filter, missing product id.');
		}
		return $this;
	}
	function fetchPages($key = 'id', $order = false) {
		$pages = $this->_core->getModel('Page/Collection')->newInstance()
			->addTable('products_to_pages', 'p2p')
			->addFilter('`p2p`.`prid`', $this->get('id'), 'eq')
			->addFilter('pages.id', '`pages`.`id`=`p2p`.`pgid`', 'logic');
		if($order) {
			$pages->setOrder($order);
		}
		$pages = $pages->getCollection($key, true, true);
		$this->set('pages', $pages);
		return $this;
	}
	function fetchImages() {
		$images = $this->_core->getModel('Product/Image/Collection')->newInstance()
			->addFilter('pid', $this->get('id'), 'eq')
			->getCollection();
		$itypes = $this->_core->getModel('Product/Image/Type/Collection')->getCollection('id');
		$data = array();
		foreach($images as $k=>$v) {
			if(is_object($v)) {
				if($v->get('type') == 0) $v->push('type', 1)->save();
				if(is_object($itypes[$v->get('type')])) {
					$tname = $itypes[$v->get('type')]->get('name');
					if(!is_array($data[$tname])) {
						$data[$tname] = array();
					}
					$_i = sizeof($data[$tname][100]);
					$data[$tname][60][$_i] = $this->_core->getSingleton('Config')->topFolder . $this->_core->getModel('Image')->getImage($v->get('path'), 54);
					$data[$tname][100][$_i] = $this->_core->getSingleton('Config')->topFolder . $this->_core->getModel('Image')->getImage($v->get('path'), 80);
					$data[$tname][120][$_i] = $this->_core->getSingleton('Config')->topFolder . $this->_core->getModel('Image')->getImage($v->get('path'), 120);
					$data[$tname][200][$_i] = $this->_core->getSingleton('Config')->topFolder . $this->_core->getModel('Image')->getImage($v->get('path'), 180);
					$data[$tname][280][$_i] = $this->_core->getSingleton('Config')->topFolder . $this->_core->getModel('Image')->getImage($v->get('path'), 280);
					$data[$tname][480][$_i] = $this->_core->getSingleton('Config')->topFolder . $this->_core->getModel('Image')->getImage($v->get('path'), 480);
					$data[$tname]['large'][$_i] = $this->_core->getSingleton('Config')->topFolder . $v->get('path');
					$data[$tname]['object'][$_i] = $v;
				}
			}
		}
//		die('<pre>'.print_r($this->_core->getModel('Setting/Collection')->newInstance()->getCollection('key')->get('GOOGLE_API_KEY'),1).'</pre>');
		/*
				if(!isset($data['streetview'])) {
					$dst = 'images/products/' . $this->get('id') . '/';
					$fname = 'streetview-' . date('Y-m-d-h-m-s') . '.jpg';
					$destination = $this->_core->getSingleton('Config')->getPath() . 'images'.$this->_core->getSystemSlash().'products' . $this->_core->getSystemSlash() . $this->get('id') . $this->_core->getSystemSlash();
					if(copy(
							'http://maps.googleapis.com/maps/api/streetview?size=640x480&location='.$this->get('latitude').','. $this->get('longitude') . '&sensor=false&key=' .
							$this->_core->getModel('Setting/Collection')->get('GOOGLE_API_KEY')->get('value'),
							$destination . $fname
							)
						) {
							$img = new Model_Product_Image(array('pid'=>$this->get('id'), 'path'=>$dst . $fname, 'type'=>3));
							$img->save();
							$data['streetview'] = array('large'=>array($this->_core->getSingleton('Config')->topFolder . $dst . $fname), 'object'=>$img);
						}
				}
				//*/
		$this->push('images', $data);
		return $this;
	}
	function fetchReviews($status = null) {
		$reviews = $this->_core->getModel('Product/Review/Collection')->newInstance()
			->addFilter('pid', $this->get($this->_id), 'eq')
			->setOrder('added')
			->setOrderWay('DESC');
		if($status) {
			$reviews->addFilter('status', $status, 'eq');
		}
		$this->push('reviews', $reviews->getCollection());
		return $this;
	}
	function getPrice() {
		$price = $this->get($this->_core->getModel('Customer/Collection')->getCurrentCustomer()->get('pricegroupfield'));
		if(!$price) {
			$price = $this->get('price');
		}
		return $price;
	}
	function fetchVideos() {
		$videos = $this->_core->getModel('Product/Video/Collection')->newInstance()
			->addFilter('pid', $this->get('id'), 'eq')
			->getCollection();
		$this->push('videos', $videos);
		return $this;
	}
	function fetchItems() {
		$this->push('items', $this->_core->getModel('Product/Item/Collection')->newInstance()->addFilter('pid', $this->get('id'), 'eq')->getCollection());
		return $this;
	}
	function fetchPlaces() {
		$places = $this->_core->getModel('Place/Collection')->newInstance()->getCollection();
		$pa = array();
		foreach($places as $k=>$v) {
			$pa[$v->get('code')] = $this->_core->getModel($v->get('model') . '/Collection')->newInstance()
				->addFilter('state', $this->get('state'), 'eq')
				->addFilter('city', $this->get('city'), 'eq')
				->addFilter('type', $v->get('id'), 'eq')
				->getCollection();
		}
		$this->push('places', $pa);
// 		echo '<prE>'.print_r($this->get('places'),1).'</pre>';
		return $this;
	}


	function saveImage($url, $desc = '', $default = 0, $type = false) {
		if(!$type) {
			$this->_core->getModel('Product/Image/Type/Collection')->getCollection('name');
			$type = $this->_core->getModel('Product/Image/Type/Collection')->get('image')->get('id');
		}
		$data = array(
			'pid'=>$this->get('id'),
			'path'=>$url,
			'description'=>$desc,
			'default'=>$default,
			'type'=>$type
		);
		$pc = $this->_core->getModel('Product/Collection')->newInstance()
			->addFilter('pid', $this->get('id'), 'eq')
			->addFilter('path', $url, 'eq');
		$img = 'SELECT * FROM `images` WHERE `pid`=\''.$this->get('id').'\' AND `path`=\''.addslashes($url).'\'';
		$res = $this->_core->getResource('DB')->getConnection()->setQuery($img)->getResult();
		if($res[0]) {
			$res = $this->_core->getResource('DB')->getConnection()->update('images', $data, $pc);
			$image = $this->_core->getModel('Product/Image')->newInstance($data)->clearThumbnails();
		} else {
			$res = $this->_core->getResource('DB')->getConnection()->insert('images', $data);
		}
		return $res;
	}
	function saveVideo($url = '', $name = '', $desc = '', $script = '') {
		$data = array(
			'pid'=>$this->get('id'),
			'path'=>$url,
			'name'=>$name,
			'description'=>$desc,
			'script'=>$script
		);
		$pc = $this->_core->getModel('Product/Collection')->newInstance()
			->addFilter('pid', $this->get('id'), 'eq')
			->addFilter('path', $url, 'eq');
		$img = 'SELECT * FROM `videos` WHERE `pid`=\''.$this->get('id').'\' AND `path`=\''.addslashes($url).'\'';
		$res = $this->_core->getResource('DB')->getConnection()->setQuery($img)->getResult();
		if($res[0]) {
			$res = $this->_core->getResource('DB')->getConnection()->update('videos', $data, $pc);
		} else {
			$res = $this->_core->getResource('DB')->getConnection()->insert('videos', $data);
		}
		return $res;
	}
	function saveReview($data) {
		$data['pid'] = $this->get('id');
		return $this->_core->getModel('Product/Review')->newInstance($data)->save();
	}
	function save() {
		$res = false;
		$res = parent::save();
		if(is_array($this->get('filters'))) {
			$sql = 'DELETE FROM `products_to_filters` WHERE product_id=\'' . $this->get('id') . '\'';
			$this->_core->getResource('DB')->getConnection()->setQuery($sql)->query();
			foreach($this->get('filters') as $k=>$v) {
				if(is_array($v)) {
					$data = array('product_id'=>$this->get('id'), 'filter_id'=>$v['id']);
					$this->_core->getResource('DB')->getConnection()->insert('products_to_filters', $data);
				} elseif($v instanceof Model_Filter) {
					$data = array('product_id'=>$this->get('id'), 'filter_id'=>$v->get('id'));
					$this->_core->getResource('DB')->getConnection()->insert('products_to_filters', $data);
				}
			}
		}
		if(is_array($this->get('pages'))) {
			$sql = 'DELETE FROM `products_to_pages` WHERE prid=\'' . $this->get('id') . '\'';
// 			$this->_core->getResource('DB')->getConnection()->debug = 1;
			$this->_core->getResource('DB')->getConnection()->setQuery($sql)->query();
			foreach($this->get('pages') as $k=>$v) {
				if(is_array($v)) {
					$data = array('prid'=>$this->get('id'), 'pgid'=>$v['id']);
					$this->_core->getResource('DB')->getConnection()->insert('products_to_pages', $data, true, true);
				} elseif($v instanceof Model_Page) {
					$data = array('prid'=>$this->get('id'), 'pgid'=>$v->get('id'));
					$this->_core->getResource('DB')->getConnection()->insert('products_to_pages', $data, true, true);
				}
			}
// 			$this->_core->getResource('DB')->getConnection()->debug = 0;
		}
		return $res;
	}

	/**
	 * @param $item Model_Page|mixed
	 * @return $this
	 */
	function disconnect($item) {
		$ids = array();
		if($item instanceof Model_Page) {
			$ids[] = $item->get($item->_id);
		}
		if(is_array($item)) {
			foreach($item as $k=>$v) {
				if($v instanceof Model_Page) {
					$ids[] = $v->get($v->_id);
				}
			}
		}
		if(sizeof($ids)>0) {
			$sql = 'DELETE FROM `products_to_pages` WHERE prid=\'' . $this->get('id') . '\' AND pgid IN (' . implode(', ', $ids) . ')';
			$this->_core->getResource('DB')->getConnection()->setQuery($sql)->query();
		}
		return $this;
	}
	function remove() {
		$this->fetchImages();
		$images = $this->get('images');
		foreach($images['object'] as $k=>$v) {
			$v->remove();
		}
		if($images['image']['object']) {
			foreach($images['image']['object'] as $k=>$v) {
				$v->remove();
			}
		}
		$this->_core->getSingleton('Config')->getUnixPath() . 'images/products/' . $this->get('id');
		parent::remove();
	}
	function getFormattedPrice() {
		return number_format($this->get('price'), 2, '.', ' ');
	}
	function _fixChars($str) {
		$str = str_replace('�', '&ndash;', $str);
		$str = str_replace('�', '&lsquo;', $str);
		$str = str_replace('�', '&rsquo;', $str);
		$str = str_replace('�', '&sbquo;', $str);
		$str = str_replace('�', '&ldquo;', $str);
		$str = str_replace('�', '&rdquo;', $str);
		$str = str_replace('�', '&bdquo;', $str);
		return $str;
	}
}