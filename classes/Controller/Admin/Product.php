<?php
/*
 * Created on 12 ����. 2012
 *
 * @author Mikel Annjuk <mikel@widesoftware.com>
 * @copy WIDE Software Inc. 2011
 * @site http://www.widesoftware.com
 * @license GNU/GPL
 */

class Controller_Admin_Product extends Controller {
	function __construct() {
		parent::__construct();
		$this->prepareUrls();
	}
	function actionIndex() {
		$this->_core->redirect($this->getActionUrl('admin-product-list'));
	}
	function actionList() {
		if($this->_core->doctype) {
			if(is_object($this->_core->getBlock('Admin/Product/List/' . ucfirst($this->_core->doctype)))) {
				$this->_core->getBlock('Admin/Product/List/' . ucfirst($this->_core->doctype))->init();
			}
		} else {
			$this->_core->getBlock('Admin/Product/List')->init();
		}
	}
	function actionEdit() {
		$this->_core->getBlock('Admin/Product/Edit')->init();
	}
	function actionSave() {
		if( ($pids = $this->_core->getRequestPost('pid')) && is_array($pids)) {
			$products = $this->_core->getModel('Product/Collection')->newInstance()
				->addFilter('id', $pids, 'in')
				->getCollection(false, true, true);
			if($this->_core->getRequestPost('pages') && is_array($this->_core->getRequestPost('pages'))) {
				$pages = $this->_core->getModel('Page/Collection')->newInstance()
					->addFilter('id', $this->_core->getRequestPost('pages'), 'in')
					->getCollection();
				foreach($products as $product) {
					$product->push('pages', array_merge($pages, $product->fetchPages()->get('pages')))->save();
				}
			}
			if($this->_core->getRequestPost('filters') && is_array($this->_core->getRequestPost('filters'))) {
				$filters = $this->_core->getModel('Filter/Collection')->newInstance()
					->addFilter('id', $this->_core->getRequestPost('filters'), 'in')
					->getCollection();
				foreach($products as $product) {
					$ar = array();
					$ftls = array_merge($filters, $product->fetchFilters()->get('filters'));
					foreach($ftls as $k=>$f) {
						if(!in_array($f->get($f->_id), $ar)) {
							$ar[] = $f->get($f->_id);
						} else {
							unset($ftls[$k]);
						}
					}
					$product->set('filters', $ftls)->save();
				}
			}
			$this->_core->redirect($this->getActionUrl('admin-product-list').'?'.$this->_core->getAllGetParams());
		} elseif(sizeof($this->_core->getRequestPost())>0) {
			$this->_core->getModel('Product');
			$product = new Model_Product($this->_core->getRequestPost());
			$arf = $this->_core->getModel('Filter/Collection')->newInstance()
				->addFilter('id', $_POST['filters'], 'in')
				->getCollection();
			$product->set('filters', $arf);
			$arf = $this->_core->getModel('Page/Collection')->newInstance()
				->addFilter('id', $_POST['pages'], 'in')
				->getCollection();
			$product->set('pages', $arf);
			if($product->save()) {
//	 			die('<pre>'.print_r($_POST,1));
				if($this->_core->getRequestPost('_save') == $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_APPLY', 'value')->get('value')) {
					$this->_core->redirect($this->getActionUrl('admin-product-edit').'?id='.$product->get($product->_id));
				} else {
					$this->_core->redirect($this->getActionUrl('admin-product-list'));
				}
			} else {
				$this->_core->raiseError('Product saving error!');
			}
		} else {
			$this->_core->redirect($this->getActionUrl('admin-product-list').'?'.$this->_core->getAllGetParams());
		}
	}
	function actionImport() {
		$path = $this->_core->getSingleton('Config')->dbPath . 'product/';
		
		if(!file_exists($path)) {
			$this->_core->mkFolders($path);
		}
		$uploaded = false;
		if(
			$_FILES['import'] &&
			is_uploaded_file($_FILES['import']['tmp_name'])
		) {
			if(move_uploaded_file($_FILES['import']['tmp_name'], $path . $_FILES['import']['name'])) {
				$uploaded = true;
//				echo $path . $_FILES['import']['name'];
//				$this->_core->redirect($this->getActionUrl('admin-product-import').'?path='.$path.$_FILES['import']['name']);
				$this->_core->redirect($this->getActionUrl('admin-product-import'));
			} else {
				$this->_core->raiseError('Could not move uploaded file into "'.$path . $_FILES['import']['name'].'".');
			}
		}
		if(
//			$uploaded
//			||
			$this->_core->getRequest('path')
		) {
			ini_set('memory_limit', '256M');
			set_time_limit(0);
			$pathFolder = $path;
			$path = $_FILES['import']?$path . $_FILES['import']['name']:$this->_core->getRequest('path');

			$mime = $this->_core->getModel('File')->newInstance()->setPath($path)->fetchMime()->get('mime');
			$imageType = $this->_core->getModel('Product/Image/Type/Collection')->newInstance()
				->addFilter('name', 'image', 'eq')
				->getOne();
			switch ($mime) {
				case 'text/csv':
				case 'text/plain':
					$separator = $this->_core->getRequest('sep')?$this->_core->getRequest('sep'):',';
					$linecount = 0;
					$fo = fopen($path, "r");
					while(fgetcsv($fo, 0, $separator)){
						$linecount++;
					}
					fclose($fo);
					if(!$this->_core->getRequest('includefirstline')) {
						$linecount--;
					}

					$fo = fopen($path, 'r');

					$cols = fgetcsv($fo, 0, $separator);
					fclose($fo);
					$fo = fopen($path, 'r');
					if($this->_core->getRequest('_import') && $this->_core->getRequest('record') && is_array($this->_core->getRequest('record'))) {
						$import = $this->_core->getModel('Import')->newInstance();
						$import->push('model', 'Product')
							->push('filename', $this->_core->getRequest('path'))
							->save();
						$record = $this->_core->getRequest('record');
						$cols = array();
						foreach($record as $k=>$v) {
							if(is_numeric($v)) {
								$cols[$k] = $v;
							}
						}
						if(!$this->_core->getRequest('includefirstline')) {
							$data = fgetcsv($fo, 0, $separator);
						}
//						$this->_core->setDebug(2);
						$brand = $this->_core->getModel('Filter/Type/Collection')->newInstance()
							->addFilter('url', 'brand', 'eq')
							->getOne(false, true, true);
						if($brand instanceof Model_Filter_Type) {
							$brand->fetchFilters(null, 'url', true);
						} else {
							$this->_core->raiseError('Please install "brand" filter type before import!');
//							print_r($brand);
							return false;
						}

//						die(print_r($bra));
						$langs = $this->_core->getModel('Language/Collection')->getAllLanguages();
//						$this->_core->raiseError('Startsing import');
						/** @var Model_Product $product */

						$csize = $linecount;
						$timestamp = time();
						$tpath = $this->_core->getSingleton('Config')->adminTmp . 'product-import.txt';
						$i=0;
						while($data = fgetcsv($fo, 0, $separator)) {
							$arrdata = array();
							foreach($cols as $k=>$v) {
								$arrdata[$k] = trim($data[$v]);
							}

							if(strlen(trim($arrdata['code']))>0) {

								$arrdata['code'] = explode('|', $arrdata['code']);
								$arrdata['name'] = explode('|', $arrdata['name']);
								if(sizeof($arrdata['code'])==1) {
									$arrdata['name'] = $arrdata['bundle_name'];
								}
//								if(!is_array($arrdata['sku'])) {
								$arrdata['sku'] = (!is_array($arrdata['sku'])?explode('|', $arrdata['sku']):$arrdata['sku']);
//								}
								$arrdata['packing'] = explode('|', $arrdata['packing']);

								$arrdata['image'] = explode('|', $arrdata['image']);
								$products = array();

								foreach($arrdata['code'] as $k=>$v) {
									$dt = $arrdata;
									$dt['code'] = trim($arrdata['code'][$k]);
									$dt['packing'] = trim($arrdata['packing'][$k]);
									$dt['sku'] = trim($arrdata['sku'][$k]);
									$dt['name'] = trim(is_array($arrdata['name']) && $arrdata['name'][$k]?$arrdata['name'][$k]:$arrdata['name']);
									$product = $this->_core->getModel('Product')->newInstance($arrdata);
									$product->push('code', $dt['code'])->push('sku', $dt['sku'])->push('status', 1);
									$product->push('packing', $dt['packing']);
									//								$this->_core->setDebug(1);
									reset($langs);
									$name = array();
									$sdesc = array();
									$desc = array();
									foreach($langs as $kx=>$vx) {
										$name[$vx->get('id')] = $dt['name'];
										$sdesc[$vx->get('id')] = $arrdata['shortdesc'];
										$desc[$vx->get('id')] = $arrdata['description'];
									}
									$product->push('name', $name)->push('shortdesc', $sdesc)->push('description', $desc);

									$pSave = $product->save();

									/** @var $item Model_Import_Item */
									$item = $this->_core->getModel('Import/Item')->newInstance()
										->push('item_id', $product->get($product->_id))
										->push('import_id', $import->get($import->_id))
										->push('type', 'import')
										->push('code', $product->get('code'));
									if($product->get($product->_id) && $pSave) {
										$item->push('result', 'imported');
									} else {
										$item->push('result', 'fail');
									}
									$item->save();
									if($product->get($product->_id)) {
										/**@var $ft Model_Filter */
										$ft = $this->_core->getModel('Filter')->newInstance(array('url'=>$dt['brand']))->prepareUrl();
										if($brand instanceof Model_Filter_Type && strlen($ft->get('url'))>0) {
											$filters = $brand->get('filters');
											if(!isset($filters[$ft->get('url')])) {
												$filter = $this->_core->getModel('Filter')->newInstance(
													array(
														'url'=>$ft->get('url'),
														'status'=>1,
														'type'=>$brand->get('id')
													)
												);
												reset($langs);
												$name = array();
												foreach($langs as $kx=>$vx) {
													$name[$vx->get('id')] = $dt['brand'];
												}
												$filter->push('name', $name);
												$filter->save();
												$filters = $brand->fetchFilters(null, 'url', true)->get('filters');
											}
											$product->appendFilter($filters[$ft->get('url')]);
										}
										if(sizeof($arrdata['image'])>0) {
											reset($arrdata['image']);
//											foreach($arrdata['image'] as $kx=>$vx) {
											$vx = $arrdata['image'][$k]?trim($arrdata['image'][$k]):trim($arrdata['image'][0]);
											if(file_exists($pathFolder . $vx) && is_file($pathFolder . $vx)) {
												$dst = 'images/products/' . $product->get($product->_id) . '/';
												$this->_core->mkFolders($this->_core->getSingleton('Config')->getUnixPath() . $dst);
												$path = pathinfo($pathFolder . $vx);
												if(copy($pathFolder . $vx, $this->_core->getSingleton('Config')->getUnixPath() . $dst . $path['basename'])) {
													$product->saveImage($dst . $path['basename'], '', 0, $imageType->get($imageType->_id));
												} else {
													$this->_core->raiseError('Could not copy ' . $pathFolder . $vx . ' to ' . $dst . $path['basename']);
												}
											} else {
												$this->_core->raiseError('"'.$pathFolder . $vx.'" do not exists or is not a file.');
											}
//											}
										} else {
											$this->_core->raiseError('Missing image for "'.$arrdata['code'][$k].'"');
										}
										$products[] = $product;
									}
								}
								if(sizeof($products)>1) {
									/** @var $bundle Model_Product_Bundle */
									$bundle = $this->_core->getModel('Product/Bundle')->newInstance();
									$bundle->push('name', $arrdata['bundle_name'])->push('code', $this->_core->generateRandom(45))->push('products', $products)->save();
								}
//							break;
							}
							$i++;
							if($i%200) {
								$ctimestamp = time();
								$this->_core->getModel('Track')->newInstance( array(
									'path'=>$tpath,
									'added'=>$timestamp,
									'updated'=>$ctimestamp,
									'records'=>$csize,
									'current'=>$i
								))->save();
							}
						}
						$ctimestamp = time();
						$this->_core->getModel('Track')->newInstance( array(
							'path'=>$tpath,
							'added'=>$timestamp,
							'updated'=>$ctimestamp,
							'records'=>$csize,
							'current'=>$i
						))->save();
//						if(!$this->_core->getRequest('includefirstline')) {
//							$cols = fgetcsv($fo, 0, $separator);
//						}
						$redirect = true;
					} else {
						if($this->_core->doctype) {

						} else {
							$this->_core->getBlock('Admin/Product/Import/Prepare')->init(array('cols'=>$cols, 'path'=>$path, 'sep'=>$separator));
						}
					}
					fclose($fo);//die(print_r($product));
					if($redirect) {
						if($this->_core->doctype) {

						} else {
							$this->_core->redirect($this->getActionUrl('admin-product-list'));
						}
					}
					break;
					break;
				case 'application/xml':
				case 'text/xml':
					require_once('XML/Unserializer.php');
					$options = array(
						XML_UNSERIALIZER_OPTION_ATTRIBUTES_PARSE=>false,
						XML_UNSERIALIZER_OPTION_ATTRIBUTES_ARRAYKEY=>true
					);
					$obj = new XML_Unserializer($options);

					$res = $obj->unserialize($path, true);
					if(PEAR::isError($res)) {
						die('Error [' . $res->getCode().']'. ':' . $res->getMessage());
					}
					$res = $obj->getUnserializedData();
					$langs = $this->_core->getModel('Language/Collection')->getAllLanguages();
					if(PEAR::isError($res)) {
						die('Error [' . $res->getCode().']'. ':' . $res->getMessage());
					} else {
						$import = $this->_core->getModel('Import')->newInstance()
							->push('model', 'Product')
							->push('filename', $this->_core->getRequest('path'));
						$import->save();
						if(!isset($res['product'][0])) {
							$res['product'] = array($res['product']);
						}
						$iter = 0;
						$saved = 0;
						$import = $this->_core->getModel('Import')->newInstance()
							->push('model', 'Product')
							->push('filename', $this->_core->getRequest('path'));
						$import->save();
						$i=0;
						$csize = sizeof($res['product']);
						$timestamp = time();
						$tpath = $this->_core->getSingleton('Config')->adminTmp . 'product-import.txt';
						foreach($res['product'] as $product) {
//								die('<pre>'.print_r($product,1));
							$pr = $this->_core->getModel('Product/Collection')->newInstance()
								->addFilter('code', $product['code'], 'eq')
								->getOne();
							/** @var $item Model_Import_Item */
							$item = $this->_core->getModel('Import/Item')->newInstance();
//								if($pr instanceof Model_Product && $pr->get($pr->_id)) {
							$item->push('import_id', $import->get($import->_id))
								->push('type', 'update');
							if(!$pr instanceof Model_Product) {
								$pr = $this->_core->getModel('Product')->newInstance();
								$pr->push('code', $product['code']);
								$pr->push('sku', $product['sku']);
								$name = array();
								foreach($langs as $lng) {
									$name[$lng->get('id')] = $product['name'];
								}
								$pr->push('name', $name);
							}
							$updated = false;
							if($pr->get('quantity') != $product['qty']) {
								$pr->push('quantity', $product['qty']);
								$uploaded = true;
							}
							$pr->push('status', $pr->get('quantity')<=0?0:1 );
							$pr->push('price', $product['price']);
							foreach($product['prices']['group'] as $price) {
								if($pr->get($price['key']) != $price['value']) {
									$pr->push($price['key'], $price['value']);
									$uploaded = true;
								}
							}
							if($pr->get('price') == 0) {
								$pr->push('price', $pr->get('price_1'));
								$uploaded = true;
							}
							$item->push('code', $pr->get('code'));
							if($pr->save()) {
								$saved++;
								$item->push('item_id', $pr->get($pr->_id));
								if($uploaded || !$pr->get($pr->_id)) {
									$item->push('result', 'updated');
								} else {
									$item->push('result', 'inserted');
								}
								if(strlen($product['image'])>0) {
//									foreach($arrdata['image'] as $kx=>$vx) {
									$vx = trim($product['image']);
									if(file_exists($pathFolder . $vx) && is_file($pathFolder . $vx)) {
										$dst = 'images/products/' . $pr->get($pr->_id) . '/';
										$this->_core->mkFolders($this->_core->getSingleton('Config')->getUnixPath() . $dst);
										$path = pathinfo($pathFolder . $vx);
										if(copy($pathFolder . $vx, $this->_core->getSingleton('Config')->getUnixPath() . $dst . $path['basename'])) {
											$pr->saveImage($dst . $path['basename'], '', 0, $imageType->get($imageType->_id));
										} else {
											$this->_core->raiseError('Could not copy ' . $pathFolder . $vx . ' to ' . $dst . $path['basename']);
										}
									} else {
										$this->_core->raiseError('"'.$pathFolder . $vx.'" do not exists or is not a file.');
									}
//									}
								}
							} else {
								$item->push('result', 'fail');
							}

							$iter++;
							$item->save();
							$i++;
							if($i%200) {
								$ctimestamp = time();
								$this->_core->getModel('Track')->newInstance( array(
									'path'=>$tpath,
									'added'=>$timestamp,
									'updated'=>$ctimestamp,
									'records'=>$csize,
									'current'=>$i
								))->save();
							}
						}
						$ctimestamp = time();
						$this->_core->getModel('Track')->newInstance( array(
							'path'=>$tpath,
							'added'=>$timestamp,
							'updated'=>$ctimestamp,
							'records'=>$csize,
							'current'=>$i
						))->save();
						unlink($path);
					}
					if($this->_core->doctype) {

					} else {
						$this->_core->redirect($this->getActionUrl('admin-product-list'));
					}
					break;
					break;
				default:
					$this->_core->raiseError('File type "'.$mime.'" is not supported.');
					break;
			}
		} else {
			$this->_core->getBlock('Admin/Product/Import')->init();
		}
	}
	function actionImportFileRemove() {
		if($this->_core->getRequest('filename') && file_exists($this->_core->getRequest('filename')) && is_file($this->_core->getRequest('filename'))) {
			if(!unlink($this->_core->getRequest('filename'))) {
				$this->_core->raiseError('Could not remove file "'.$this->_core->getRequest('filename').'"');
			}
		}
		$this->_core->redirect($this->getActionUrl('admin-product-import'));
	}
	function actionImportItemList() {
		if($this->_core->doctype) {
			if(is_object($this->_core->getBlock('Admin/Product/Import/Item/List/' . ucfirst($this->_core->doctype)))) {
				$this->_core->getBlock('Admin/Product/Import/Item/List/' . ucfirst($this->_core->doctype))->init();
			}
		}
	}
	function actionImportItemRollback() {
		if($this->_core->getRequest('iid')) {
			$import = $this->_core->getModel('Import/Collection')->newInstance()
				->addFilter('id', $this->_core->getRequest('iid'), 'eq')
				->getOne();
			if($import instanceof Model_Import) {
				set_time_limit(0);
				$arrResults = array('imported');
				$items = $this->_core->getModel('Import/Item/Collection')->newInstance()
					->addFilter('import_id', $import->get($import->_id), 'eq')
					->getCollection();
				foreach($items as $item) {
					if(in_array($item->get('result'), $arrResults)) {
						$product = $this->_core->getModel('Product/Collection')->newInstance()
							->addFilter('id', $item->get('item_id'), 'eq')
							->getOne(false, true, true);
						if($product instanceof Model_Product) {
							$this->_core->dispatchEvent('product-remove-before', $product);
							$product->remove();
							$this->_core->dispatchEvent('product-remove-after', $product);
						}
					}
					$item->remove();
				}
				$import->remove();
			}
		}
		$this->_core->redirect($this->getActionUrl('admin-product-import'));
	}
	function actionItemList() {
		$this->_core->getBlock('Admin/Product/Item/List')->init();
	}
	function actionItemEdit() {
		$this->_core->getBlock('Admin/Product/Item/Edit')->init();
	}
	function actionItemSave() {
		$this->_core->getModel('Product/Item');
		$item = new Model_Product_Item($this->_core->getRequestPost());
		if($item->save()) {
			if($this->_core->getRequestPost('_save') == 'Apply') {
				$this->_core->redirect($this->getActionUrl('admin-product-item-edit').'?pid='.$item->get('pid').'&id='.$item->get('id'));
			} else {
				$this->_core->redirect($this->getActionUrl('admin-product-edit').'?id='.$item->get('pid'));
			}
		} else {
			$this->_core->raiseError('Product item saving error!');
		}
	}
	function actionItemImageUpload() {
		$this->_core->getModel('Product/Item');
		$item = $this->_core->getModel('Product/Item/Collection')->newInstance()
			->addFilter('id', $this->_core->getRequest('id'), 'eq')
			->addFilter('pid', $this->_core->getRequest('pid'), 'eq')
			->getOne();
		if(is_object($item) && $item instanceof Model_Product_Item) {
			if(is_uploaded_file($_FILES['image']['tmp_name'])) {
				$dst = 'images/products/' . $item->get('pid') . '/';
				$destination = $this->_core->getSingleton('Config')->getPath() . 'images'.$this->_core->getSystemSlash().'products' . $this->_core->getSystemSlash() . $item->get('pid') . $this->_core->getSystemSlash();
				$this->_core->mkFolders($destination);
				if(move_uploaded_file($_FILES['image']['tmp_name'], $destination . $_FILES['image']['name'])) {
					$item->saveImage($dst . $_FILES['image']['name']);
					$image = $this->_core->getModel('Image')->newInstance(array('path'=>$dst . $_FILES['image']['name']));
//					$image->addWatermark($image->get('path'), $image->get('path'));
					$this->_core->redirect($this->getActionUrl('admin-product-item-edit') . '?pid=' . $item->get('pid').'&id=' . $item->get('id'));
				} else {
					$this->_core->raiseError('Error moving file \''.$_FILES['image']['tmp_name'].'\' to \''.$destination.$_FILES['image']['name'].'\'!');
				}
			}
		} else {
			$this->_core->raiseError('Item not found!');
		}
	}
	function actionItemImageEdit() {
		$this->_core->getBlock('Admin/Product/Item/Image/Edit')->init();
	}
	function actionItemImageSave() {
		if($this->_core->getRequest('id') && $this->_core->getRequest('pid') && $this->_core->getRequest('piid')) {
			$item = $this->_core->getModel('Product/Item/Image')->newInstance($this->_core->getRequestPost());
			if($item->save()) {
				if($this->_core->getRequestPost('_save') == 'Apply') {
					$this->_core->redirect($this->getActionUrl('admin-product-item-image-edit') . '?pid=' . $item->get('pid').'&piid=' . $item->get('piid').'&id='.$item->get('id'));
				} else {
					$this->_core->redirect($this->getActionUrl('admin-product-item-edit') . '?pid=' . $item->get('pid').'&id=' . $item->get('piid'));
				}
			}
		}
	}
	function actionImageUpload() {
		$this->_core->getModel('Product');
		$product = new Model_Product(array_merge(array('id'=>$this->_core->getRequestPost('pid')), $this->_core->getRequestPost()));
		if($product->get('id')) {
			if(is_uploaded_file($_FILES['image']['tmp_name'])) {
				$dst = 'images/products/' . $product->get('id') . '/';
				$destination = $this->_core->getSingleton('Config')->getUnixPath() . 'images/products/' . $product->get('id') . '/';
				$this->_core->mkFolders($destination);

				if(move_uploaded_file($_FILES['image']['tmp_name'], $destination . $_FILES['image']['name'])) {
					$type = $this->_core->getModel('Product/Image/Type/Collection')->newInstance()->addFilter('name', 'image', 'eq')
						->getOne();
					if($type instanceof Model_Product_Image_Type) {
						$product->saveImage($dst . $_FILES['image']['name'], '', 0, $type->get('id'));
					} else {
						$this->_core->raiseError('There is no "image" type record in database. Please ask system admin to fix this out.');
					}

//					$image = $this->_core->getModel('Image')->newInstance(array('path'=>$destination . $_FILES['image']['name']));
//					$image->addWatermark($image->get('path'), $image->get('path'));
//					$this->_core->redirect($this->getActionUrl('admin-product-edit') . '?id=' . $product->get('id'));
				} else {
					$this->_core->raiseError('Error moving file \''.$_FILES['image']['tmp_name'].'\' to \''.$destination.$_FILES['image']['name'].'\'!');
				}
//				$this->_core->redirect($this->getActionUrl('admin-product-edit') . '?id=' . $product->get('id'));
			}
			$this->_core->redirect($this->getActionUrl('admin-product-edit') . '?id=' . $product->get('id'));
		} else {
			$this->_core->raiseError('Missing product id!<pre>'.print_r($_POST,1).'</pre>');
		}
	}
	function actionVideoUpload() {
		$this->_core->getModel('Product');
		$product = new Model_Product(array_merge(array('id'=>$this->_core->getRequestPost('pid')), $this->_core->getRequestPost()));
		if($product->get('id')) {
			if(is_uploaded_file($_FILES['video']['tmp_name'])) {
				$dst = 'videos/products/' . $product->get('id') . '/';
				$destination = $this->_core->getSingleton('Config')->getPath() . 'videos'.$this->_core->getSystemSlash().'products' . $this->_core->getSystemSlash() . $product->get('id') . $this->_core->getSystemSlash();;
				$this->_core->mkFolders($destination);
				if(move_uploaded_file($_FILES['video']['tmp_name'], $destination . $_FILES['video']['name'])) {
//	 				$product->saveVideo($dst . $_FILES['video']['name'], $this->_core->getRequestPost('name'), $this->_core->getRequestPost('description'), $this->_core->getRequestPost('script'));
					$video = $this->_core->getModel('Product/Video')->newInstance($this->_core->getRequestPost());
					$video->push('path', $dst . $_FILES['video']['name']);
					$video->save();
					$this->_core->redirect($this->getActionUrl('admin-product-edit') . '?id=' . $product->get('id'));
				} else {
					$this->_core->raiseError('Error moving file \''.$_FILES['video']['tmp_name'].'\' to \''.$destination.$_FILES['video']['name'].'\'!');
				}
			} else {
				$video = $this->_core->getModel('Product/Video')->newInstance($this->_core->getRequestPost());
				if($video->save()) {

					if($this->_core->getRequestPost('_save') == 'Apply') {
						$this->_core->redirect($this->getActionUrl('admin-product-video-edit') . '?id=' . $video->get('id') . '&pid=' . $video->get('pid'));
					} else {
						$this->_core->redirect($this->getActionUrl('admin-product-edit') . '?id=' . $video->get('pid'));
					}
				}
			}
		} else {
			$this->_core->raiseError('Missing product id!<pre>'.print_r($_POST,1).'</pre>');
		}
	}
	function actionImageClearThumbnail() {
		if($this->_core->getRequest('id')) {
			/** @var $_product Model_Product */
			$_product = $this->_core->getModel('Product/Collection')->newInstance()
				->addFilter('id', $this->_core->getRequest('id'), 'eq')
				->getOne(false, true, true);
			if($_product instanceof Model_Product) {
				$_images = $_product->fetchImages()->get('images');
				foreach($_images as $image_type) {
					foreach($image_type['object'] as $image) {
						if($image instanceof Model_Product_Image) {
							$image->clearThumbnails();
						} else {
							$this->_core->raiseError(print_r($image,1));
						}
					}
				}
				$this->_core->redirect($this->getActionUrl('admin-product-edit') . '?id=' . $this->_core->getRequest('id') . '&' . $this->_core->getAllGetParams(array('id')));
			} else {
				$this->_core->raiseError('Product ID is wrong.');
			}
		} else {
			$this->_core->raiseError('Missing product ID.');
		}
	}
	function actionImageEdit() {
		if($this->_core->getRequest('id')) {
			if($this->_core->doctype == 'ajax') {

			} else {
				$this->_core->getBlock('Admin/Product/Video/Edit')->init();
			}
		}
	}
	function actionImageRemove() {
		if($this->_core->getRequest('imgid')) {
			$image = $this->_core->getModel('Product/Image/Collection')->newInstance()
				->addFilter('id', $this->_core->getRequest('imgid'), 'eq')
				->getOne();
			$image->remove();
			if($this->_core->doctype == 'ajax') {

			} else {
				$this->_core->redirect($this->getActionUrl('admin-product-edit') . '?' . $this->_core->getAllGetParams(array('imgid')));
			}
		}
	}
	function actionVideoEdit() {
		if($this->_core->getRequest('pid') && $this->_core->getRequest('id')) {
			if($this->_core->doctype == 'ajax') {

			} else {
				$this->_core->getBlock('Admin/Product/Video/Edit')->init();
			}
		}
	}
	function actionVideoRemove() {
		if($this->_core->getRequest('pid') && $this->_core->getRequest('id')) {
			$video = $this->_core->getModel('Product/Video/Collection')->newInstance()
				->addFilter('pid', $this->_core->getRequest('pid'), 'eq')
				->addFilter('id', $this->_core->getRequest('id'), 'eq')
				->getCollection();
			if(is_object($video[0])) {
				$video = $video[0];
			} else {
				$video = new Model_Product_Video();
			}
			if($video->get('id')) {
				if($video->remove()) {
					$this->_core->redirect($this->getActionUrl('admin-product-edit') . '?id=' . $video->get('pid'));
				} else {
					$this->_core->raiseError('Video remove error!');
				}
			} else {
				$this->_core->raiseError('Missing video!');
			}
		}
	}
	function actionStatus() {
		if($this->_core->getRequest('id')) {
			$product = $this->_core->getModel('Product/Collection')->newInstance()
				->addFilter('id', $this->_core->getRequest('id'), 'eq')
				->getOne();
			if($product instanceof Model_Product) {
				if((int)$product->get('status') == 1) {
					$product->set('status', 0);
				} else {
					$product->set('status', 1);
				}
				$product->save();
			} else {
				$this->_core->raiseError('Missing product for that ID');
			}
			if($this->_core->doctype) {
				if(is_object($this->_core->getBlock('Admin/Product/Status/' . ucfirst($this->_core->doctype)))) {
					$this->_core->getBlock('Admin/Product/Status/' . ucfirst($this->_core->doctype))->init();
				} else {
					$this->_core->raiseError('Missing object "'.'Block/Admin/Product/Status/' . ucfirst($this->_core->doctype).'"');
				}
			} else {
				$this->_core->redirect($this->getActionUrl('admin-product-list') . '?' . $this->_core->getAllGetParams(array('id')));
			}
		} else {
			$this->_core->raiseError('Missing product ID');
			if(!$this->_core->doctype) {
				$this->_core->redirect($this->getActionUrl('admin-product-list') . '?' . $this->_core->getAllGetParams(array('id')));
			}
		}
	}

	function actionStatusnew() {
		if($this->_core->getRequest('id')) {
			$product = $this->_core->getModel('Product/Collection')->newInstance()
				->addFilter('id', $this->_core->getRequest('id'), 'eq')
				->getOne();
			if($product instanceof Model_Product) {
				if((int)$product->get('status_new') == 1) {
					$product->set('status_new', 0);
				} else {
					$product->set('status_new', 1);
				}
				$product->save();
			} else {
				$this->_core->raiseError('Missing product for that ID');
			}
			if($this->_core->doctype) {
				if(is_object($this->_core->getBlock('Admin/Product/Status/' . ucfirst($this->_core->doctype)))) {
					$this->_core->getBlock('Admin/Product/Status/' . ucfirst($this->_core->doctype))->init();
				} else {
					$this->_core->raiseError('Missing object "'.'Block/Admin/Product/Status/' . ucfirst($this->_core->doctype).'"');
				}
			} else {
				$this->_core->redirect($this->getActionUrl('admin-product-list') . '?' . $this->_core->getAllGetParams(array('id')));
			}
		} else {
			$this->_core->raiseError('Missing product ID');
			if(!$this->_core->doctype) {
				$this->_core->redirect($this->getActionUrl('admin-product-list') . '?' . $this->_core->getAllGetParams(array('id')));
			}
		}
	}

	function actionStatusaction() {
		if($this->_core->getRequest('id')) {
			$product = $this->_core->getModel('Product/Collection')->newInstance()
				->addFilter('id', $this->_core->getRequest('id'), 'eq')
				->getOne();
			if($product instanceof Model_Product) {
				if((int)$product->get('status_action') == 1) {
					$product->set('status_action', 0);
				} else {
					$product->set('status_action', 1);
				}
				$product->save();
			} else {
				$this->_core->raiseError('Missing product for that ID');
			}
			if($this->_core->doctype) {
				if(is_object($this->_core->getBlock('Admin/Product/Status/' . ucfirst($this->_core->doctype)))) {
					$this->_core->getBlock('Admin/Product/Status/' . ucfirst($this->_core->doctype))->init();
				} else {
					$this->_core->raiseError('Missing object "'.'Block/Admin/Product/Status/' . ucfirst($this->_core->doctype).'"');
				}
			} else {
				$this->_core->redirect($this->getActionUrl('admin-product-list') . '?' . $this->_core->getAllGetParams(array('id')));
			}
		} else {
			$this->_core->raiseError('Missing product ID');
			if(!$this->_core->doctype) {
				$this->_core->redirect($this->getActionUrl('admin-product-list') . '?' . $this->_core->getAllGetParams(array('id')));
			}
		}
	}

	function actionStatustopsell() {
		if($this->_core->getRequest('id')) {
			$product = $this->_core->getModel('Product/Collection')->newInstance()
				->addFilter('id', $this->_core->getRequest('id'), 'eq')
				->getOne();
			if($product instanceof Model_Product) {
				if((int)$product->get('status_topsell') == 1) {
					$product->set('status_topsell', 0);
				} else {
					$product->set('status_topsell', 1);
				}
				$product->save();
			} else {
				$this->_core->raiseError('Missing product for that ID');
			}
			if($this->_core->doctype) {
				if(is_object($this->_core->getBlock('Admin/Product/Status/' . ucfirst($this->_core->doctype)))) {
					$this->_core->getBlock('Admin/Product/Status/' . ucfirst($this->_core->doctype))->init();
				} else {
					$this->_core->raiseError('Missing object "'.'Block/Admin/Product/Status/' . ucfirst($this->_core->doctype).'"');
				}
			} else {
				$this->_core->redirect($this->getActionUrl('admin-product-list') . '?' . $this->_core->getAllGetParams(array('id')));
			}
		} else {
			$this->_core->raiseError('Missing product ID');
			if(!$this->_core->doctype) {
				$this->_core->redirect($this->getActionUrl('admin-product-list') . '?' . $this->_core->getAllGetParams(array('id')));
			}
		}
	}
	function actionRemove() {
		if($this->_core->getRequest('id')) {
			$product = $this->_core->getModel('Product/Collection')->newInstance()
				->addFilter('id', $this->_core->getRequest('id'), 'eq')
				->getOne();
			if($product instanceof Model_Product) {
				$this->_core->dispatchEvent('product-remove-before', $product);
				$product->remove();
				$this->_core->dispatchEvent('product-remove-after', $product);
				$this->_core->redirect($this->getActionUrl('admin-product-list') . '?' . $this->_core->getAllGetParams(array('id')));
			}
		} elseif($this->_core->getRequest('pid') && is_array($this->_core->getRequest('pid'))) {
			$products = $this->_core->getModel('Product/Collection')->newInstance()
				->addFilter('id', $this->_core->getRequest('pid'), 'in')
				->getCollection();
			foreach($products as $product) {
				if($product instanceof Model_Product) {
					$this->_core->dispatchEvent('product-remove-before', $product);
					$product->remove();
					$this->_core->dispatchEvent('product-remove-after', $product);
				}
			}
			$this->_core->redirect($this->getActionUrl('admin-product-list') . '?' . $this->_core->getAllGetParams(array('pid')));
		}
		$this->_core->redirect($this->getActionUrl('admin-product-list') . '?' . $this->_core->getAllGetParams(array('pid', 'id')));
	}
	function actionFiltersDisconnect($product = null) {
		if($product instanceof Model_Product) {
			$filters = $product->fetchFilters(true)->get('filters');
			foreach($filters as $filter) {
				$filter->disconnect($product);
			}
		}
	}
	function actionBundleDisconnect($product = null) {
		if($product instanceof Model_Product) {
			$bundles = $product->fetchBundles(true)->get('bundles');
			foreach($bundles as $bundle) {
				$bundle->disconnect($product);
			}
		}
	}
	function actionPageDisconnect($product = null) {
		if($product instanceof Model_Product) {
			$product->fetchPages()->disconnect($product->get('pages'));
		}
	}
	function actionReview() {
		$this->_core->redirect($this->getActionUrl('admin-product-review-list'));
	}
	function actionReviewList() {
		$this->_core->getBlock('Admin/Product/Review/List')->init();
	}
	function actionReviewStatus() {
		if($this->_core->getRequest('id')) {
			$review = $this->_core->getModel('Product/Review/Collection')->newInstance()
				->addFilter('id', $this->_core->getRequest('id'), 'eq')
				->getOne();
			if($review instanceof Model_Product_Review) {
				if((int)$review->get('status') == 1) {
					$review->set('status', 0);
				} else {
					$review->set('status', 1);
				}
				$review->save();
			} else {
				$this->_core->raiseError('Missing review for that ID');
			}
			$this->_core->redirect($this->getActionUrl('admin-product-review-list') . '?' . $this->_core->getAllGetParams(array('id')));
		} else {
			$this->_core->raiseError('Missing review ID');
			$this->_core->redirect($this->getActionUrl('admin-product-review-list') . '?' . $this->_core->getAllGetParams(array('id')));
		}
	}
	function actionBundleList() {
		$this->_core->getBlock('Admin/Product/Bundle/List')->init();
	}
	function actionBundleEdit() {
		$this->_core->getBlock('Admin/Product/Bundle/Edit')->init();
	}
	function actionBundleSave() {
//		$this->_core->setDebug(2);
		$bundle = $this->_core->getModel('Product/Bundle/Collection')->newInstance()
			->addFilter('pbid', $this->_core->getRequest('pbid'), 'eq')
			->getOne();
		if($bundle instanceof Model_Product_Bundle) {
			$bundle->mergeData($this->_core->getRequestPost(), array($bundle->_id))->save();
			if($this->_core->getRequestPost('pid') && is_array($this->_core->getRequestPost('pid'))) {
				$products = $this->_core->getModel('Product/Collection')->newInstance()
					->addFilter('id', $this->_core->getRequestPost('pid'), 'in')
					->getCollection(false, true, true);
				if(sizeof($products)>0) {
					$bundle->appendProducts($products);
				}
			}
		} else {
			$bundle = $this->_core->getModel('Product/Bundle')->newInstance($this->_core->getRequestPost());
			if(!$bundle->get('code')) {
				$bundle->push('code', $this->_core->generateRandom(45));
			}
//			die('<pre>'.print_r($bundle,1));
			if($bundle->save()) {
				if($this->_core->getRequestPost('pid') && is_array($this->_core->getRequestPost('pid'))) {
					$products = $this->_core->getModel('Product/Collection')->newInstance()
						->addFilter('id', $this->_core->getRequestPost('pid'), 'in')
						->getCollection(false, true, true);
					if(sizeof($products)>0) {
						$bundle->appendProducts($products);
					}
				}
			}
		}
		if($this->_core->getRequest('_apply')) {
			$this->_core->redirect($this->getActionUrl('admin-product-bundle-edit').'?id='.$bundle->get('pbid').'&'.$this->_core->getAllGetParams(array('id', 'pbid', 'pid')));
		} else {
			$this->_core->redirect($this->getActionUrl('admin-product-bundle-list').'?'.$this->_core->getAllGetParams(array('id', 'pbid')));
		}
	}
	function actionBundleDetach() {
		if(
			$this->_core->getRequest('id') &&
			$this->_core->getRequest('pid') &&
			(
			$product = $this->_core->getModel('Product/Collection')->newInstance()
				->addFilter('id', $this->_core->getRequest('pid'), 'eq')->getOne()
			) instanceof Model_Product &&
			($bundle = $this->_core->getModel('Product/Bundle/Collection')->newInstance()->addFilter('pbid', $this->_core->getRequest('id'), 'eq')->getOne()) instanceof Model_Product_Bundle
		) {
			$bundle->detachProduct($product);
		} else {
			$this->_core->raiseError(
				'Could not detach "'.$product->get('name').' '.
					$product->get('packing').' from "'.$bundle->get('name').'"');
		}
		$this->_core->redirect($this->getActionUrl('admin-product-bundle-edit').'?'.$this->_core->getAllGetParams(array('pid')));
	}
	function actionBundleRemove() {
		if(($bundle = $this->_core->getModel('Product/Bundle/Collection')->newInstance()->addFilter('pbid', $this->_core->getRequest('id'), 'eq')->getOne()) instanceof Model_Product_Bundle) {
			$bundle->remove();
		}
		$this->_core->redirect($this->getActionUrl('admin-product-bundle-list').'?'.$this->_core->getAllGetParams(array('id')));
	}
	function prepareUrls() {
		$this->pushUrl('admin-product-list', $this->_adminUrl . 'product/list');
		$this->pushUrl('admin-product-edit', $this->_adminUrl . 'product/edit');
		$this->pushUrl('admin-product-save', $this->_adminUrl . 'product/save');
		$this->pushUrl('admin-product-status', $this->_adminUrl . 'product/status');
		$this->pushUrl('admin-product-remove', $this->_adminUrl . 'product/remove');
		$this->pushUrl('admin-product-import', $this->_adminUrl . 'product/import');
		$this->pushUrl('admin-product-import-file-remove', $this->_adminUrl . 'product/import/file/remove');
		$this->pushUrl('admin-product-import-item-list', $this->_adminUrl . 'product/import/item/list');
		$this->pushUrl('admin-product-import-item-rollback', $this->_adminUrl . 'product/import/item/rollback');

		$this->pushUrl('admin-product-review', $this->_adminUrl . 'product/review');
		$this->pushUrl('admin-product-review-list', $this->_adminUrl . 'product/review/list');
		$this->pushUrl('admin-product-review-status', $this->_adminUrl . 'product/review/status');

		$this->pushUrl('admin-product-item-list', $this->_adminUrl . 'product/item/list');
		$this->pushUrl('admin-product-item-edit', $this->_adminUrl . 'product/item/edit');
		$this->pushUrl('admin-product-item-save', $this->_adminUrl . 'product/item/save');
		$this->pushUrl('admin-product-item-remove', $this->_adminUrl . 'product/item/remove');
		$this->pushUrl('admin-product-item-image-edit', $this->_adminUrl . 'product/item/image/edit');
		$this->pushUrl('admin-product-item-image-save', $this->_adminUrl . 'product/item/image/save');
		$this->pushUrl('admin-product-item-image-remove', $this->_adminUrl . 'product/item/image/remove');

		$this->pushUrl('admin-product-item-image-upload', $this->_adminUrl . 'product/item/image/upload');

		$this->pushUrl('admin-product-image-upload', $this->_adminUrl . 'product/image/upload');
		$this->pushUrl('admin-product-image-edit', $this->_adminUrl . 'product/image/edit');
		$this->pushUrl('admin-product-image-remove', $this->_adminUrl . 'product/image/remove');
		$this->pushUrl('admin-product-image-clear-thumbnail', $this->_adminUrl . 'product/image/clear/thumbnail');

		$this->pushUrl('admin-product-video-upload', $this->_adminUrl . 'product/video/upload');
		$this->pushUrl('admin-product-video-edit', $this->_adminUrl . 'product/video/edit');
		$this->pushUrl('admin-product-video-remove', $this->_adminUrl . 'product/video/remove');

		$this->pushUrl('admin-product-bundle-list', $this->_adminUrl . 'product/bundle/list');
		$this->pushUrl('admin-product-bundle-save', $this->_adminUrl . 'product/bundle/save');
		$this->pushUrl('admin-product-bundle-edit', $this->_adminUrl . 'product/bundle/edit');
		$this->pushUrl('admin-product-bundle-remove', $this->_adminUrl . 'product/bundle/remove');
		$this->pushUrl('admin-product-bundle-detach', $this->_adminUrl . 'product/bundle/detach');
		return $this;
	}
}