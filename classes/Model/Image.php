<?php
/**
 * File: Upload.php
 * Created on Dec 5, 2010
 *
 *
 * @category   
 * @package    
 * @author      Mikel Annjuk <support@widesoftware.com>
 */
 
class Model_Image extends Model_Object {
	var $arrExt = array('jpg','png','gif','jpeg', 'JPG', 'JPEG');
	var $arrPath;
	function __construct($data = array()) {
		parent::__construct($data);
		if($this->get('path')) {
			$size = $this->getSize();
			if(is_array($size)) {
				$this->set('width', $size[0])->set('height', $size[1])->set('html', $size[3])->set('mime', $size['mime']);
			}
		}
	}
	function getSize() {
		$imgSize = getimagesize($this->get('path'));
		return $imgSize;
	}
  /**
	* createThumb method creates a resized image
	* @param string $name 		Original filename
	* @param string $filename	Filename of the resized image
	* @param string $new_w		width of resized image
	* @param string $new_h		height of resized image
	*/
	function createThumb($name, $filename, $new_w, $new_h, $watermark=false, $square = false) {
		$system = explode(".", $name);
		$imgSize = getimagesize($name);
//		die($imgSize['mime']);
		switch($imgSize['mime']) {
			case 'image/jpeg':
				$src_img = imagecreatefromjpeg($name);
				break;
			case 'image/png':
				$src_img = imagecreatefrompng($name);
				break;
			case 'image/gif':
				$src_img = imagecreatefromgif($name);
				break;
			default:
				$src_img = imagecreatefromjpeg($name);
				break;
		}
		
		$old_x = $imgSize[0];
		$old_y = $imgSize[1];
		if($square) {
			$b_hw = $b_hh = 0;
			if($old_x > $old_y) {
				$blank_h = $blank_w = $old_y;
				$b_hw = round(($old_x-$old_y)/2);
			} else {
				$blank_h = $blank_w = $old_x;
				$b_hh = round(($old_y-$old_x)/2);
			}
			$width = $new_w;
			if($width<250) {
				$width = 250;
			}
			if($blank_w>$width) {
				$blank_w = $blank_h = $width;
				$b_hw = round(($old_x-$blank_w)/2);
				$b_hh = round(($old_y-$blank_h)/2);
			}
			$blank_img = imagecreatetruecolor($blank_w, $blank_h);
//			imagecopy($blank_img, $src_img, 0, 0, $b_hw, $b_hh, $blank_w, $blank_h);
			imagecopyresampled($blank_img, $src_img, 0, 0, 0, 0, $b_hw, $b_hh, $blank_w, $blank_h);
			$old_x = $old_y = $blank_w;
			$thumb_h = $thumb_w = $width;
			
			imagedestroy($src_img);
			switch($imgSize['mime']) {
				case 'image/jpeg':
					imagejpeg($blank_img, $filename, 100);
					break;
				case 'image/png':
					imagepng($blank_img, $filename, 0);
					break;
				case 'image/gif':
					imagegif($blank_img, $filename);
					break;
				default:
					imagejpeg($blank_img, $filename, 100);
					break;
			}
			
			if($new_w<250) {
				$dst_img = ImageCreateTrueColor($new_w, $new_w);
				imagecopyresized($dst_img, $blank_img, 0, 0, 0, 0, $new_w, $new_w, $blank_w, $blank_h);
				imagecopyresampled($dst_img, $blank_img, 0, 0, 0, 0, $new_w, $new_w, $blank_w, $blank_h);
				switch($imgSize['mime']) {
					case 'image/jpeg':
						imagejpeg($dst_img, $filename, 100);
						break;
					case 'image/png':
						imagepng($dst_img, $filename, 0);
						break;
					case 'image/gif':
						imagegif($dst_img, $filename);
						break;
					default:
						imagejpeg($dst_img, $filename, 100);
						break;
				}
				imagedestroy($dst_img);
			}
			//*/
			imagedestroy($blank_img);
		} else {
			if ($old_x > $old_y) {
				$thumb_w = $new_w;
				$thumb_h = $old_y*($new_h/$old_x);
			}
			if ($old_x < $old_y) {
				$thumb_w = $old_x*($new_w/$old_y);
				$thumb_h = $new_h;
			}
			if ($old_x == $old_y) {
				$thumb_w = $new_w;
				$thumb_h = $new_h;
			}
			$dst_img = ImageCreateTrueColor($thumb_w, $thumb_h);
		
//			imagecopyresized($dst_img, $src_img, 0, 0, 0, 0, $thumb_w, $thumb_h, $old_x, $old_y);
			imagecopyresampled($dst_img, $src_img, 0, 0, 0, 0, $thumb_w, $thumb_h, $old_x, $old_y);
			switch($imgSize['mime']) {
				case 'image/jpeg':
					imagejpeg($dst_img, $filename, 100);
					break;
				case 'image/png':
					imagepng($dst_img, $filename, 0);
					break;
				case 'image/gif':
					imagegif($dst_img, $filename);
					break;
				default:
					imagejpeg($dst_img, $filename, 100);
					break;
			}
			imagedestroy($dst_img);
			imagedestroy($src_img);
		}
	}
	
	function getImage($path, $width) {
		$pathinfo = pathinfo($path);
// 		die($path);
		if(file_exists($this->_core->getSingleton('Config')->getPath().$path) && in_array($pathinfo['extension'], $this->arrExt)) {
			$thumbpath = $pathinfo['dirname'].'/_thumb/';
// 			echo $this->_core->getSingleton('Config')->getPath().$thumbpath . '<br>';
			$this->_core->mkFolders($this->_core->getSingleton('Config')->getPath().$thumbpath);
			$sml = explode('.', $pathinfo['basename']);
			$ext = array_pop($sml);
			$sml = $thumbpath . implode('.', $sml) . '_' . $width . '_thumb.' . $ext;

			if (!file_exists($this->_core->getSingleton('Config')->getPath().$sml)) {
				$this->createthumb(
						$this->_core->getSingleton('Config')->getPath().$path,
						$this->_core->getSingleton('Config')->getPath().$sml,
						$width,
						$width
					);
			}
		} else{
			$sml = 'images/products/no_image.gif';
		}
		return $sml;
	}
	function getImages($path,$width=0,$arrExclude = array('_thumb')) {
		$arrRes = array();
		$m5 = md5($path);
		if($this->arrPath[$m5]) {
			reset($this->arrPath[$m5]);
			foreach($this->arrPath[$m5] as $k=>$v) {
				if(sizeof($arrExclude)>0) {
					foreach($arrExclude as $kx=>$vx) {
						if(!strstr($v, $vx)) {
							if($width>0) {
								$arrRes[] = $this->getImage($v,$width);
							} else {
								$arrRes[] = $v;
							}
						}
					}
				} else {
					if($width>0) {
						$arrRes[] = $this->getImage($v,$width);
					} else {
						$arrRes[] = $v;
					}
				}
			}
		} else {
			$this->arrPath[$m5] = array();
			if(file_exists($this->_core->getSingleton('Config')->getPath().$path) && is_dir($this->_core->getSingleton('Config')->getPath().$path)) {
				$d = dir($this->_core->getSingleton('Config')->getPath().$path);
				while (false !== ($entry = $d->read())) {
					if(!is_dir($this->_core->getSingleton('Config')->getPath().$path.$entry)) {
						if(sizeof($arrExclude)>0) {
							foreach($arrExclude as $kx=>$vx) {
								if(!strstr($entry, $vx)) {
									$this->arrPath[$m5][] = $path.$entry;
									if($width>0) {
										$arrRes[] = $this->getImage($path.$entry,$width);
									} else {
										$arrRes[] = $path.$entry;
									}
								}
							}
						} else {
							$this->arrPath[$m5][] = $path.$entry;
							if($width>0) {
								$arrRes[] = $this->getImage($path.$entry,$width);
							} else {
								$arrRes[] = $path.$entry;
							}
						}
					}
				}
				$d->close();
			}
		}
		return $arrRes;
	}
	function addWatermark($name, $filename, $watermark = 'watermark.png') {
		if(file_exists($this->_core->getSingleton('Config')->getUnixPath() . 'images/' . $watermark)) {
			$wm = $this->_core->getSingleton('Config')->getUnixPath() . 'images/' . $watermark;
			$imgSize = getimagesize($name);
			switch($imgSize['mime']) {
				case 'image/jpeg':
					$src_img = imagecreatefromjpeg($name);
					break;
				case 'image/png':
					$src_img = imagecreatefrompng($name);
					break;
				case 'image/gif':
					$src_img = imagecreatefromgif($name);
					break;
				default:
					$src_img = imagecreatefromjpeg($name);
					break;
			}
			$wmSize = getimagesize($wm);
			switch($wmSize['mime']) {
				case 'image/jpeg':
					$srcw_img = imagecreatefromjpeg($wm);
					break;
				case 'image/png':
					$srcw_img = imagecreatefrompng($wm);
					break;
				case 'image/gif':
					$srcw_img = imagecreatefromgif($wm);
					break;
				default:
					$srcw_img = imagecreatefromjpeg($wm);
					break;
			}
			$dst_img = ImageCreateTrueColor($imgSize[0], $imgSize[1]);
			imagecopyresampled($dst_img, $src_img, 0, 0, 0, 0, $imgSize[0], $imgSize[1], $imgSize[0], $imgSize[1]);
			imagecopy($dst_img, $srcw_img, round(($imgSize[0]-$wmSize[0])/2), round(($imgSize[1]-$wmSize[1])/2), 0, 0, $wmSize[0], $wmSize[1]);
			switch($imgSize['mime']) {
				case 'image/jpeg':
					imagejpeg($dst_img, $filename, 100);
					break;
				case 'image/png':
					imagepng($dst_img, $filename, 100);
					break;
				case 'image/gif':
					imagegif($dst_img, $filename);
					break;
				default:
					imagejpeg($dst_img, $filename, 100);
					break;
			}
			imagedestroy($dst_img); 
			imagedestroy($src_img); 
			imagedestroy($srcw_img); 
		} else {
			die('Watermark error: ' . $this->_core->getSingleton('Config')->getUnixPath() . 'images/' . $watermark . ' does not exist!<br >');
		}
	}
}
?>
