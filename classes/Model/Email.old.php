<?php
/**
 * Created on 18 ���. 2012
 *
 * @author Mikel Annjuk <anmishael@gmail.com>
 * @comment Designed especially for Kinetoscope Media, Inc.
 * @version 1.0
 */
 
 class Model_Email extends Model_Object {
 	function send($from = false, $to = false, $reply = false) {
 		if(!$this->get('template')) {
 			$this->_core->raiseError('Email template is not selected!');
 		}
 		require_once "Mail.php";
 		require_once "SMTP.php";
 		if($this->_core->getModel('Setting/Collection')->size() == 0) {
			$this->_core->getModel('Setting/Collection')->getCollection('key');
		}
 		$from = $from ? $from : $this->_core->getModel('Setting/Collection')->get('EMAIL_USERNAME')->get('value');
 		
		$to = $to? $to : $this->get('customer')->get('name_first') . ' ' .
				$this->get('customer')->get('name_last') . 
				' <' . $this->get('customer')->get('email') . '>';
		$this->get('template')->applyVars();
		
		$subject = $this->get('template')->get('title');
		$body = $this->get('template')->get('content');
		
		$host = ( $this->_core->getModel('Setting/Collection')->get('EMAIL_USE_SSL')->get('value') == 'true' ? "ssl://" : '' ) .
				$this->_core->getModel('Setting/Collection')->get('EMAIL_HOST')->get('value');
				
		$port = $this->_core->getModel('Setting/Collection')->get('EMAIL_PORT')->get('value');
		$username = $this->_core->getModel('Setting/Collection')->get('EMAIL_USERNAME')->get('value');
		$password = $this->_core->getModel('Setting/Collection')->get('EMAIL_PASSWORD')->get('value');
		$headers = array (
				'From' => $from,
				'To' => $to,
				'Subject' => $subject,
				'Content-Type' => 'text/html;charset=UTF-8'
			);
		if($reply) {
			$headers['Reply-To'] = $reply;
		}
		if($this->_core->getModel('Setting/Collection')->get('EMAIL_SMTP')->get('value') == 'true') {
			$smtp = Mail::factory(
					'smtp',
					array (
						'host' => $host,
						'port' => $port,
						'auth' => true,
						'username' => $username,
						'password' => $password
					)
				);
			
			$mail = $smtp->send($to, $headers, $body);
		} else {
			$sendmail = Mail::factory(
					'sendmail',
					array(
						'sendmail_path'=>$this->_core->getModel('Setting/Collection')->get('EMAIL_SENDMAIL_PATH')->get('value')
					)
				);
			$mail = $sendmail->send($to, $headers, $body);
		}
		$res = true;
		if (PEAR::isError($mail)) {
			if($this->_core->getDebug()) {
				$this->_core->raiseError($mail->getMessage());
			}
			$res = false;
		}
 		return $res;
 	}
 }