<?php
/**
 * Created on 16 ����. 2012
 *
 * @author Mikel Annjuk <anmishael@gmail.com>
 * @comment Designed especially for Kinetoscope Media, Inc.
 * @version 1.0
 */
 
class Model_Currency_Collection extends Model_Collection_Abstract {
	var $_table = 'currencies';
	var $_id = 'id';
	var $_model = 'Currency';
	var $_currency;
	function fetch() {
		if(is_object($this->_currency)) {
			return $this->_currency;
		}
		if(!$this->_core->getRequestSess('currency')) {
			if($this->_core->getRequest('curr')) {
				$this->_currency = $this->newInstance()
						->addFilter('code', strtoupper(substr(trim($this->_core->getRequest('curr'))), 0, 3), 'eq')
						->getOne();
			}
			if(!$this->_currency) {
				$this->_currency = $this->newInstance()
//						->setOrder('`default`')
						->addFilter('`default`',0,'more')
						->setOrderWay('ASC')
						->getOne();
			}
			if(!$this->_currency) {
				$this->_core->raiseError('Missing default currency record!');
				$this->_currency = $this->_core->getModel('Currency')->newInstance();
			}
			$_SESSION['currency'] = $this->_currency->toArray();
		} else {
			$c = $this->_core->getRequestSess('currency');
			$this->_currency = $this->newInstance()
					->addFilter('id', strtoupper($c['id']), 'eq')
					->getOne();
			if(!$this->_currency) {
				$this->_core->raiseError('Missing currency records!');
				$this->_currency = $this->_core->getModel('Currency')->newInstance();
			}
		}
		return $this->_currency;
	}
}