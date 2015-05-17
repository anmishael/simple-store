<?php
/**
 * File.php
 * Created by mikel <anmishael@gmail.com>
 * Support: WIDE Software Team <support@widesoftware.com>
 * Date: 19.11.12
 * Time: 9:49
 */
class Model_File extends Model_Object {
	var $_content;
	var $_type = 'text/html';
	function fetchMime() {
		if ($this->_core->notNull($this->_path) && file_exists($this->_path)) {
			if (class_exists('finfo')) {
				$fi = new finfo(FILEINFO_MIME);
				$type = $fi->file($this->_path);
				$this->push('mime', substr($type, 0, strpos($type, ';')));
			} elseif (function_exists('mime_content_type')) {
				$this->push('mime', mime_content_type($this->_path));
			} else {
				$this->push('mime', $this->get_mime_type());
			}
		}
		return $this;
	}
	function setPath($path) {
		$this->_path = $path;
		return $this;
	}
	function setContent($content) {
		$this->_content = $content;
		return $this;
	}
	function setType($type) {
		$this->_type = $type;
		return $this;
	}
	function moveUploaded($path, $name = false) {
		$res = false;
		if(is_uploaded_file($this->_path)) {
			$fname = (is_array($path) && isset($path['name'])) ?$path['name']:$path;
			if($name) {
				$fname = $name;
			}
			$res = move_uploaded_file($this->_path, $fname);
		}
		return $res;
	}
	function move($path, $name) {
		$res = copy($this->_path, $path . $name);
		unlink($this->_path);
		return $res;
	}
	function display() {
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		header("Cache-Control: no-cache");
		header("Pragma: no-cache");
		header("Content-type: ".$this->_type."");
		echo $this->_content;
		return $this;
	}
	function human_filesize($decimals = 2) {
		$bytes = filesize($this->_path);
		$sz = 'BKMGTP';
		$factor = floor((strlen($bytes) - 1) / 3);
		return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$sz[$factor];
	}
	function get_mime_type() {
		$mimePath = $this->_core->getSingleton('Config')->getUnixPath();
		$fileext = substr(strrchr($this->_path, '.'), 1);
		if (empty($fileext)) return (false);
		$regex = "/^([\w\+\-\.\/]+)\s+(\w+\s)*($fileext\s)/i";
		$lines = file("$mimePath/mime.types");
		foreach ($lines as $line) {
			if (substr($line, 0, 1) == '#') continue; // skip comments
			$line = rtrim($line) . " ";
			if (!preg_match($regex, $line, $matches)) continue; // no match to the extension
			return ($matches[1]);
		}
		return (false); // no match at all
	}
}
