<?php
/*
 * Created on 22 ����. 2012
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

 class Controller_Customer extends Controller {
 	function __construct() {
 		parent::__construct();
 		$this->prepareUrls();
 	}
 	function actionIndex() {
// 		$this->_core->redirect($this->getActionUrl('customer-view'));
 	}
 	function actionView() {
 		if($this->_core->doctype) {
 			$this->_core->getBlock('Customer/View/' . ucfirst($this->_core->doctype))->init();
 		} else {
			$this->_core->getBlock('Customer/View')->init();
 		}
 	}
 	function actionSave() {
 		$_customer = $this->_core->getModel('Customer/Collection')->getCurrentCustomer();
 		if($_customer->get('id')) {
 			if($this->_core->getRequestPost('email')) {
 				$_c = $this->_core->getModel('Customer/Collection')->newInstance()
 						->addFilter('email', $this->_core->getRequestPost('email'), 'eq')
 						->getOne();

 				if($_c instanceof Model_Customer && $_c->get('id') && $_c->get('id') != $_customer->get('id')) {
 					$this->_core->raiseError('Customer with "'.$this->_core->getRequestPost('email').'" already exists!');
 					return false;
 				}
 			}
			if($this->_core->getRequestPost('password') && $this->_core->getRequestPost('password_confirm')) {
				$_customer->push('password', $this->_core->getRequestPost('password'))
					->push('password_confirm', $this->_core->getRequestPost('password_confirm'));
			}
 			$_customer->mergeData($this->_core->getRequestPost(), array('email', 'id'));
 			$_customer->push('cardcode', $_POST['cardcode']);
// 			die(print_r($_customer->toArray(),1));
 			if($_customer->save()) {
 				$this->_core->redirect($this->getActionUrl('customer-view'));
 			}
 		}
 	}
 	function actionRegister() {
 		if($this->_core->getRequestPost() && sizeof($this->_core->getRequestPost())>0) {
 			$customer = $this->_core->getModel('Customer')->newInstance($this->_core->getRequestPost());
	 		$cType = 'Registered';
	 		if(strlen(trim($customer->get('email'))) == 0) {
	 			$this->_core->raiseError($this->_core->getModel('Translate/Collection')->get('CUSTOMER_REGISTER_MISSING_EMAIL')->get('value'));
	 			$this->_core->getBlock('Customer/Register')->init();
	 		} else {
//		 		if($this->_core->getRequestPost('customertype')) {
//		 			$cType = $this->_core->getRequestPost('customertype');
//		 		}

		 		$type = $this->_core->getModel('Customer/Type/Collection')->newInstance()->addFilter('name', $cType, 'eq')->getOne();
		 		if($type instanceof Model_Customer_Type) {
		 		
			 		$customer->push('typeid', $type->get('id'));
			 		$customer->push('status', 0);
			 		$customer->push('verification', $this->_core->generateRandom(32));
			 		if(!$this->_core->emailIsValid($customer->get('email'))) {
			 			$this->_core->raiseError(sprintf($this->_core->getModel('Translate/Collection')->get('CUSTOMER_REGISTER_INVALID_EMAIL')->get('value'), $customer->get('email')));
			 			$this->_core->getBlock('Customer/Register')->init();
			 		} elseif(strlen(trim($customer->get('password')))<1) {
			 			$this->_core->raiseError(sprintf($this->_core->getModel('Translate/Collection')->get('CUSTOMER_REGISTER_PASSWORD_MISSING')->get('value'), $customer->get('email')));
			 			$this->_core->getBlock('Customer/Register')->init();
			 		} elseif(strlen(trim($customer->get('password')))<6) {
			 			$this->_core->raiseError(sprintf($this->_core->getModel('Translate/Collection')->get('CUSTOMER_REGISTER_PASSWORD_TOO_SHORT')->get('value'), $customer->get('email')));
			 			$this->_core->getBlock('Customer/Register')->init();
			 		} elseif(trim($customer->get('password'))!=trim($customer->get('password_confirm'))) {
			 			$this->_core->raiseError(sprintf($this->_core->getModel('Translate/Collection')->get('CUSTOMER_REGISTER_PASSWORD_NOT_MATCHED')->get('value'), $customer->get('email')));
			 			$this->_core->getBlock('Customer/Register')->init();
			 		} else {
				 		$existing = $this->_core->getModel('Customer/Collection')->newInstance()->addFilter('email', $customer->get('email'), 'eq')->getCollection();
				 		if(isset($existing[0]) && $existing[0] instanceof Model_Customer) {
				 			$this->_core->raiseError(sprintf($this->_core->getModel('Translate/Collection')->get('CUSTOMER_REGISTER_EMAIL_ALREADY_EXISTS')->get('value'), $existing[0]->get('email')));
				 			$this->_core->getBlock('Customer/Register')->init();
				 		} else {
					 		$existing = $this->_core->getModel('Customer/Collection')->newInstance()->addFilter('username', $customer->get('username'), 'eq')->getCollection();
//					 		if(isset($existing[0]) && $existing[0] instanceof Model_Customer) {
//					 			$this->_core->raiseError('Customer with `'.$existing[0]->get('username').'` username already exists!');
//					 		} else {
						 		if(!$customer->save()) {
									$this->_core->raiseError($this->_core->getModel('Translate/Collection')->get('CUSTOMER_REGISTRATION_ERROR')->get('value'));
						 		} else {
							 		$template = $this->_core->getModel('Template/Collection')->newInstance()
						 					->addFilter('code', 'EMAIL_REGISTRATION', 'eq')
						 					->getOne(false,true,true);
						 			if(is_object($template) && $template instanceof Model_Template) {
						 				$template->push('customer', $customer);
						 				$email = $this->_core->getModel('Email')->newInstance();
						 				$email->push('customer', $customer);
						 				if(!$email->push('template', $template)->send()) {
						 					$this->_core->raiseError('Email sending error.');
						 					$this->_core->getBlock('Customer/Register')->init();
						 				} else {
						 					if(!$this->_core->doctype) {
						 						$this->_core->redirect($this->getActionUrl('customer-register-success'));
						 					} else {
						 						$this->_core->getBlock('Customer/Register/Success/' . ucfirst($this->_core->doctype))->init();
						 					}
						 				}
						 			} else {
						 				$this->_core->raiseError($this->_core->getModel('Translate/Collection')->get('TEMPLATE_NOT_FOUND_EMAIL_REGISTRATION')->get('value'));
						 			}
						 		}
//					 		}
				 		}
			 		}
	 			} else {
		 			$this->_core->raiseError('Customer type `'.ucfirst($cType).'` missing in database. Please ask site administrator to check this issue.');
		 		}
	 		}
 		} else {
 			$this->_core->getBlock('Customer/Register')->init();
 		}
 	}
 	function actionRegisterVerify() {
 		if($this->_core->getRequest('code')) {
 			$customer = $this->_core->getModel('Customer/Collection')->newInstance()
 					->addFilter('verification', $this->_core->getRequest('code'), 'eq')
 					->getOne();
 			if(is_object($customer) && $customer instanceof Model_Customer && $customer->get('id')) {
 				if($customer->push('status', 1)->push('verification', '')->save()) {
 					if($this->_core->doctype) {
 						$this->_core->getBlock('Customer/Register/Verify/Success/' . ucfirst($this->_core->doctype))->init();
 					} else {
 						$this->_core->redirect($this->getActionUrl('customer-register-verify-success'));
 					}
 				}
 			}  else {
 				$this->_core->raiseError($this->_core->getModel('Translate/Collection')->get('CUSTOMER_REGISTER_WRONG_VERIFICATION_CODE')->get('value'));
 			}
 		} else {
 			$this->_core->raiseError($this->_core->getModel('Translate/Collection')->get('CUSTOMER_REGISTER_MISSING_VERIFICATION_CODE')->get('value'));
 		}
 	}
 	function actionRegisterVerifySuccess() {
 		if($this->_core->doctype) {
 			$this->_core->getBlock('Customer/Register/Verify/Success/' . ucfirst($this->_core->doctype))->init();
 		} else {
 			$this->_core->getBlock('Customer/Register/Verify/Success')->init();
 		}
 	}
 	function actionRegisterSuccess() {
 		if($this->_core->doctype) {
 			$this->_core->getBlock('Customer/Register/Success/' . ucfirst($this->_core->doctype))->init();
 		} else {
 			$this->_core->getBlock('Customer/Register/Success')->init();
 		}
 	}
 	function actionSupport() {
 		
 	}
 	function actionSupportMessage() {
 		
 	}
 	function actionMessage() {
 		
 	}
 	function actionMessageList() {
 		
 	}
 	function actionMessageView() {
 		
 	}
 	function actionMessageSend() {
 		$_customer = $this->_core->getModel('Customer/Collection')->getCurrentCustomer();
 		if($_customer->get('id')) {
 			$_subj = '';
 			if($this->_core->getRequest('pid')) {
 				$_product = $this->_core->getModel('Product/Collection')->newInstance()
 					->addFilter('p.id', (int)$this->_core->getRequest('pid'), 'eq')
 					->getOne();
 				if(!$_product instanceof Model_Product || !$_product->get('id')) {
 					$_product = $this->_core->getModel('Product')->newInstance();
 				} else {
 					$_subj .= $_product->get('name') . '. ';
 				}
 			}
 			if($this->_core->getRequest('piid')) {
 				if(is_array($this->_core->getRequest('piid'))) {
 					$_product_items = $this->_core->getModel('Product/Item/Collection')->newInstance()
 					->addFilter('id', $this->_core->getRequest('piid'), 'in')
 					->getCollection();
 				} else {
 					$_product_items = $this->_core->getModel('Product/Item/Collection')->newInstance()
 					->addFilter('id', (int)$this->_core->getRequest('piid'), 'in')
 					->getCollection();
 				}
 			}
 			if($this->_core->getRequest('mgid')) {
 				$_message_group = $this->_core->getModel('Customer/Message/Group/Collection')->newInstance()
 						->addFilter('id', (int)$this->_core->getRequest('mgid'), 'eq')
 						->getOne();
 			}
 			
// 			die(print_r($_product_items,1));
 			if(!$_product->get('id')) {
 				$_rec = $this->_core->getRequest('recipient');
 			} else {
 				$_rec = $_product->get('cid');
 			}
// 			Check if recipient ID is present
 			if($_rec) {
// 				Variables
				$sender_name = strlen(trim($this->_core->getRequest('name')))>0?$this->_core->getRequest('name'):$_customer->get('name_first').' '.$_customer->get('name_last');
				
				if(is_array($_product_items)) {
					foreach($_product_items as $k=>$_pitem) {
						if(!$this->_core->getRequest('mgid')) $_message_group = null;
		// 				Check if message group exists
			 			if(!$_message_group instanceof Model_Customer_Message_Group || !$_message_group->get('id')) {
		//	 				Create new message group
			 				$_message_group = $this->_core->getModel('Customer/Message/Group')->newInstance( array(
			 							'sender' => $_customer->get('id'),
			 							'sender_name' => $sender_name,
			 							'subject' => $_subj . ', ' . $_pitem->get('name'),
			 							'recipient' => $_rec,
			 							'pid' => $this->_core->getRequest('pid'),
			 							'piid' => $_pitem->get('id'),
			 							'expected_move'=>$this->_core->getRequest('year').'-'.$this->_core->getRequest('month').'-'.$this->_core->getRequest('day'),
			 							'expected_term'=>$this->_core->getRequest('term'),
		 								'offer' => $this->_core->getRequest('offer')
			 						)
			 					);
							if(!$_message_group->save()) {
								$this->_core->raiseError('Message saving error. Please contact system administrator to fix this issue.');
							}
			 			}
			 			if($_message_group->get('id')) {
			 				if($this->_core->getRequest('type') == 'availability') {
				 				$_subj = 'Check availability - ' . $_subj;
				 			} elseif($this->_core->getRequest('type') == 'offer') {
				 				$_subj = 'Make an offer - ' . $_subj;
				 			}
				 			if($this->_core->getRequest('subject')) {
				 				$_subj = htmlspecialchars($this->_core->getRequest('subject'));
				 			}
			 				$_message = $this->_core->getModel('Customer/Message')->newInstance()
									->push('mgid', $_message_group->get('id'))
									->push('sender', $_customer->get('id'))
									->push('sender_name', $sender_name)
									->push('subject', $_subj . ', ' . $_pitem->get('name'))
									->push('content', htmlspecialchars($this->_core->getRequest('content')))
									->push('recipient', $_rec);
							if($_message->save()) {
								if($_message_group->get('sender') == $_customer->get('id')) {
									$_message_group->push('unread_recipient', (int)$_message_group->get('unread_recipient')+1)->save();
								} else {
									$_message_group->push('unread_sender', (int)$_message_group->get('unread_sender')+1)->save();
								}
		//						We send an email
								$template = null;
								if($this->_core->getRequest('type') == 'availability') {
									$template = $this->_core->getModel('Template/Collection')->newInstance()
										->addFilter('code', 'EMAIL_CUSTOMER_MESSAGE_CHECK_AVAILABILITY', 'eq')
										->getOne(false,true,true);
								} elseif($this->_core->getRequest('type') == 'offer') {
									$template = $this->_core->getModel('Template/Collection')->newInstance()
										->addFilter('code', 'EMAIL_CUSTOMER_MESSAGE_OFFER', 'eq')
										->getOne(false,true,true);
								}
								if(!$template instanceof Model_Template || !$template->get('id')) {
									$template = $this->_core->getModel('Template/Collection')->newInstance()
										->addFilter('code', 'EMAIL_CUSTOMER_MESSAGE_DEFAULT', 'eq')
										->getOne(false,true,true);
								}
								if($template instanceof Model_Template && $template->get('id')) {
									$template->push('customer', $_customer)
										->push('request', $this->_core->getRequestPost())
										->push('message', $_message)
										->push('message_group', $_message_group);
									$email = $this->_core->getModel('Email')->newInstance();
									$email->push('template', $template);
									$email->push('customer', $_customer);
									if(
										$email->send(
												$from = $this->_core->getModel('Setting/Collection')->get('EMAIL_USERNAME')->get('value'),
												$to = $this->_core->getModel('Setting/Collection')->get('EMAIL_USERNAME')->get('value') . ', ' . $_customer->get('email'),
												$reply = $this->_core->getModel('Setting/Collection')->get('EMAIL_USERNAME')->get('value')//$_customer->get('email')
											)
									) {
										if($this->_core->doctype) {
											$this->_core->getBlock('Customer/Message/Send/Success/' . ucfirst($this->_core->doctype))->init();
										} else {
					 						$this->_core->redirect($_SERVER['HTTP_REFERER']);
										}
									} else {
										$this->_core->raiseError('Send email error.');
									}
								} else {
									$this->_core->raiseError('Missing email template with EMAIL_CUSTOMER_MESSAGE_DEFAULT code!');
								}
							}
			 			}
					}
				} else {
					
	// 				Check if message group exists
		 			if(!$_message_group instanceof Model_Customer_Message_Group || !$_message_group->get('id')) {
	//	 				Create new message group
		 				$_message_group = $this->_core->getModel('Customer/Message/Group')->newInstance( array(
		 							'sender' => $_customer->get('id'),
		 							'sender_name' => $sender_name,
		 							'subject' => $_subj,
		 							'recipient' => $_rec,
		 							'pid' => $this->_core->getRequest('pid'),
		 							'piid' => $this->_core->getRequest('piid'),
		 							'expected_move'=>$this->_core->getRequest('year').'-'.$this->_core->getRequest('month').'-'.$this->_core->getRequest('day'),
		 							'expected_term'=>$this->_core->getRequest('term'),
		 							'offer' => $this->_core->getRequest('offer')
		 						)
		 					);
						if(!$_message_group->save()) {
							$this->_core->raiseError('Message saving error. Please contact system administrator to fix this issue.');
						}
		 			}
		 			if($_message_group->get('id')) {
		 				if($this->_core->getRequest('type') == 'availability') {
			 				$_subj = 'Check availability - ' . $_subj;
			 			} elseif($this->_core->getRequest('type') == 'offer') {
			 				$_subj = 'Make an offer - ' . $_subj;
			 			}
			 			if($this->_core->getRequest('subject')) {
			 				$_subj = htmlspecialchars($this->_core->getRequest('subject'));
			 			}
		 				$_message = $this->_core->getModel('Customer/Message')->newInstance()
								->push('mgid', $_message_group->get('id'))
								->push('sender', $_customer->get('id'))
								->push('sender_name', $sender_name)
								->push('subject', $_subj)
								->push('content', htmlspecialchars($this->_core->getRequest('content')))
								->push('recipient', $_rec);
						if($_message->save()) {
							if($_message_group->get('sender') == $_customer->get('id')) {
								$_message_group->push('unread_recipient', (int)$_message_group->get('unread_recipient')+1)->save();
							} else {
								$_message_group->push('unread_sender', (int)$_message_group->get('unread_sender')+1)->save();
							}
	//						We send an email
							$template = null;
							if($this->_core->getRequest('type') == 'availability') {
								$template = $this->_core->getModel('Template/Collection')->newInstance()
									->addFilter('code', 'EMAIL_CUSTOMER_MESSAGE_CHECK_AVAILABILITY', 'eq')
									->getOne(false,true,true);
							} elseif($this->_core->getRequest('type') == 'offer') {
								$template = $this->_core->getModel('Template/Collection')->newInstance()
									->addFilter('code', 'EMAIL_CUSTOMER_MESSAGE_OFFER', 'eq')
									->getOne(false,true,true);
							}
							if(!$template instanceof Model_Template || !$template->get('id')) {
								$template = $this->_core->getModel('Template/Collection')->newInstance()
									->addFilter('code', 'EMAIL_CUSTOMER_MESSAGE_DEFAULT', 'eq')
									->getOne(false,true,true);
							}
							if($template instanceof Model_Template && $template->get('id')) {
								$template->push('customer', $_customer)
									->push('request', $this->_core->getRequestPost())
									->push('message', $_message)
									->push('message_group', $_message_group);
								$email = $this->_core->getModel('Email')->newInstance();
								$email->push('template', $template);
								$email->push('customer', $_customer);
								if(
									$email->send(
											$from = $this->_core->getModel('Setting/Collection')->get('EMAIL_USERNAME')->get('value'),
											$to = $this->_core->getModel('Setting/Collection')->get('EMAIL_USERNAME')->get('value') . ', ' . $_customer->get('email'),
											$reply = $this->_core->getModel('Setting/Collection')->get('EMAIL_USERNAME')->get('value') //$_customer->get('email')
										)
								) {
									if($this->_core->doctype) {
										$this->_core->getBlock('Customer/Message/Send/Success/' . ucfirst($this->_core->doctype))->init();
									} else {
				 						$this->_core->redirect($_SERVER['HTTP_REFERER']);
									}
								} else {
									$this->_core->raiseError('Send email error.');
								}
							} else {
								$this->_core->raiseError('Missing email template with EMAIL_CUSTOMER_MESSAGE_DEFAULT code!');
							}
						}
		 			}
				}
			} else {
				$this->_core->raiseError('Missing recipient!');
			}
		} else {
			$this->_core->raiseError('You have to register first!');
		}
 	}
 	function actionMessageRemove() {
 		
 	}
 	function actionMessageGroupRemove() {
 		if($this->_core->getRequest('mgid')) {
 			$_message_group = $this->_core->getModel('Customer/Message/Group/Collection')->newInstance()
 					->addFilter('id', $this->_core->getRequest('mgid'), 'eq')
 					->getOne();
 			if($_message_group instanceof Model_Customer_Message_Group && $_message_group->get('id')) {
 				if($_message_group->remove()) {
 					$ref = explode('?', $_SERVER['HTTP_REFERER']);
 					if($this->_core->getGetSize()>1) {
 						$ref = $ref[0] . '?' . $this->_core->getAllGetParams(array('mgid')) . '#private-messages';
 					} else {
 						$ref = $ref[0] . '#private-messages';
 					}
 					$this->_core->redirect($ref);
 				}
 			}
 		}
 	}
 	function actionPasswordForgot() {
 		if($this->_core->doctype) {
 			$this->_core->getBlock('Customer/Password/Forgot/' . ucfirst($this->_core->doctype))->init();
 		} else {
 			$this->_core->getBlock('Customer/Password/Forgot')->init();
 		}
 	}
 	function actionPasswordReset() {
 		if($this->_core->getRequestPost('email')) {
 			$template = $this->_core->getModel('Template/Collection')->newInstance()
					->addFilter('code', 'EMAIL_PASSWORD_RESET', 'eq')
					->getOne(false,true,true);
			if(is_object($template) && $template instanceof Model_Template) {
				$customer = $this->_core->getModel('Customer')->newInstance($this->_core->getRequestPost());
				
				$_customer = $this->_core->getModel('Customer/Collection')->newInstance()
						->addFilter('email', $customer->get('email'), 'eq')
						->getOne();
				if(!is_object($_customer) || !$_customer instanceof Model_Customer || !$_customer->get('id')) {
					$this->_core->raiseError(
								sprintf(
									$this->_core->getModel('Translate/Collection')->get('CUSTOMER_PASSWORD_RESET_NO_EMAIL_CUSTOMER')->get('value'), $customer->get('email')
								),
								true
							)
						->redirect($this->getActionUrl('customer-password-forgot'));
					
				} elseif((int)$_customer->get('status') == 0) {
					$this->_core->raiseError($this->_core->getModel('Translate/Collection')->get('CUSTOMER_PASSWORD_RESET_IS_INACTIVE')->get('value'));
				} else {
					$_customer->push('verification', $this->_core->generateRandom(32));
					$_customer->save();
					$template->push('customer', $_customer);
					$email = $this->_core->getModel('Email')->newInstance();
					$email->push('customer', $_customer);
					if(!$email->push('template', $template)->send()) {
						$this->_core->raiseError('Email sending error.');
					} else {
						if(!$this->_core->doctype) {
							$this->_core->redirect($this->getActionUrl('customer-password-reset'));
						} else {
							$this->_core->getBlock('Customer/Password/Reset/Verify/' . ucfirst($this->_core->doctype))->init();
						}
					}
				}
			} else {
				$this->_core->raiseError('EMAIL_PASSWORD_RESET template not found! Please ask system administrator to fix this issue.');
			}
 		} else {
	 		if($this->_core->doctype) {
	 			$this->_core->setReturnStatus('NOACTION');
	 			$this->_core->getBlock('Customer/Password/Reset/' . ucfirst($this->_core->doctype))->init();
	 		} else {
	 			$this->_core->getBlock('Customer/Password/Reset')->init();
	 		}
 		}
 	}
 	function actionPasswordResetVerify() {
 		if($this->_core->getRequest('code')) {
 			$_customer = $this->_core->getModel('Customer/Collection')->newInstance()
						->addFilter('verification', $this->_core->getRequest('code'), 'eq')
						->getOne();
			if(!is_object($_customer) || !$_customer instanceof Model_Customer || !$_customer->get('id')) {
				$this->_core->raiseError($this->_core->getModel('Translate/Collection')->get('CUSTOMER_PASSWORD_RESET_WRONG_VERIFICATION_CODE')->get('value'));
				if($this->_core->doctype) {
				} else {
					$this->_core->getBlock('Customer/Password/Reset/Verify')->init();
				}
			} elseif($this->_core->getRequest('password') && $this->_core->getRequest('password_confirm')) {
				if(strlen(trim($this->_core->getRequest('password')))<6) {
					$this->_core->raiseError($this->_core->getModel('Translate/Collection')->get('CUSTOMER_PASSWORD_RESET_TOO_SHORT')->get('value'));
					if($this->_core->doctype) {
					} else {
						$this->_core->getBlock('Customer/Password/Reset/Verify')->init();
					}
				} else {
					if($this->_core->getRequest('password') != $this->_core->getRequest('password_confirm')) {
						$this->_core->raiseError($this->_core->getModel('Translate/Collection')->get('CUSTOMER_PASSWORD_RESET_NOT_MATCHED')->get('value'));
						if($this->_core->doctype) {
						} else {
							$this->_core->getBlock('Customer/Password/Reset/Verify')->init();
						}
					} else {
						$_customer->push('password', $this->_core->getRequest('password'));
						$_customer->push('password_confirm', $this->_core->getRequest('password_confirm'));
						$_customer->push('verification', '');
						if($_customer->save()) {
							if($this->_core->doctype) {
								$this->_core->getBlock('Customer/Password/Reset/Success/' . ucfirst($this->_core->doctype))->init();
							} else {
								$this->_core->redirect($this->getActionUrl('customer-password-reset-success'));
							}
						} else {
							$this->_core->raiseError('Data saving error.');
						}
					}
				}
			} else {
				$this->_core->raiseError($this->_core->getModel('Translate/Collection')->get('CUSTOMER_PASSWORD_RESET_PLEASE_TYPE_PASSWORD')->get('value'));
				if($this->_core->doctype) {
					$this->_core->getBlock('Customer/Password/Reset/Verify/' . ucfirst($this->_core->doctype))->init();
				} else {
					$this->_core->getBlock('Customer/Password/Reset/Verify')->init();
				}
			}
 		} else {
 			if($this->_core->doctype) {
 				$this->_core->setReturnStatus('NOACTION');
				$this->_core->getBlock('Customer/Password/Reset/Verify/' . ucfirst($this->_core->doctype))->init();
 			} else {
 				$this->_core->getBlock('Customer/Password/Reset/Verify')->init();
 			}
 		}
 	}
 	function actionPasswordResetSuccess() {
 		if($this->_core->doctype) {
 			$this->_core->getBlock('Customer/Password/Reset/Success/' . ucfirst($this->_core->doctype))->init();
 		} else {
 			$this->_core->getBlock('Customer/Password/Reset/Success')->init();
 		}
 	}
 	function actionSupportMessageSend() {
 		$error = false;
 		if(!$this->_core->getRequestPost('name_first')) {
 			$this->_core->raiseError('Missing firstname.');
 			$error = true;
 		}
 		if(!$this->_core->getRequestPost('name_last')) {
 			$this->_core->raiseError('Missing lastname.');
 			$error = true;
 		}
 		if(!$this->_core->getRequestPost('email')) {
 			$this->_core->raiseError('Missing email.');
 			$error = true;
 		}
 		if(!$error) {
 			$sp = $this->_core->getModel('Customer/Support/Message')->newInstance($this->_core->getRequestPost());
 			if( ($customer = $this->_core->getModel('Customer/Collection')->getCurrentCustomer()) ) {
 				$sp->push('cid', $customer->get('id'));
 			} else {
 				$customer = $this->_core->getModel('Customer')->newInstance($this->_core->getRequestPost());
 			}
 			if($sp->save()) {
 				$template = $this->_core->getModel('Template/Collection')->newInstance()
						 ->addFilter('code', 'EMAIL_CUSTOMER_SUPPORT_MESSAGE', 'eq')
						 ->getOne(false,true,true);
 				$template->push('customer', $customer);
 				$template->push('message', $sp);
				$email = $this->_core->getModel('Email')->newInstance();
				$email->push('template', $template);
				$email->push('customer', $customer);
				if(
					$email->send(
							$from = $this->_core->getModel('Setting/Collection')->get('EMAIL_USERNAME')->get('value'),
							$to = $this->_core->getModel('Setting/Collection')->get('EMAIL_USERNAME')->get('value') . ', ' . $customer->get('email'),
							$reply = $customer->get('email')
						)
				) {
 					$this->_core->redirect($this->getActionUrl('customer-support-message-send-success'));
				} else {
					$this->_core->raiseError('Send email error.');
				}
 			} else {
 				$this->_core->raiseError('Message saving error.');
 			}
 		} else {
 			$this->_core->getModel('Error/Collection')->pushToSession();
 			$this->_core->redirect($_SERVER['HTTP_REFERER']);
 		}
 	}
 	function actionLogin() {
 		if($this->_core->getRequest('email')) {
	 		if($this->_core->getRequest('email') && $this->_core->getRequest('password')) {
	 			$customer = $this->_core->getModel('Customer')->newInstance()->authorize($this->_core->getRequest('email'), $this->_core->getRequest('password'));
	 			if($customer instanceof Model_Customer && $customer->get('id')) {
	 				$_SESSION['customerid'] = $customer->get('id');
					$cart = unserialize($customer->get('shopping_cart'));
//					die(print_r($cart,1));
					foreach($cart as $id=>$item) {
						$this->_core->getModel('Cart')->add(
							$id,
							$item->get('qty')
						);
					}
	 				$this->_core->dispatchEvent('customer-login');
	 				if($this->_core->doctype) {
	 					$this->_core->getModel('Customer/Collection')->clearCurrentCustomer();
	 					$this->_core->getBlock('Customer/View/' . ucfirst($this->_core->doctype))->init();
	 				} else {
	 					if($this->_core->getRequest('redirect')) {
	 						unset($_SESSION['redirect']);
	 						$_fn = array_unique($this->_core->getRequest('functions'));
	 						$this->_core->redirect($this->_core->getRequest('redirect').($_fn?'?fn='.implode(':', $_fn):''));
	 					} else {
	 						$this->_core->redirect('/');//$this->getActionUrl('customer-view'));
	 					}
	 				}
	 			} else {
	 				$this->_core->raiseError($this->_core->getModel('Translate/Collection')->get('CUSTOMER_LOGIN_WRONG_USER')->get('value'));
					$this->_core->redirect($this->getActionUrl('customer-login'));
	 			}
	 		} else {
	 			$this->_core->raiseError($this->_core->getModel('Translate/Collection')->get('CUSTOMER_LOGIN_WRONG_USER')->get('value'));
	 		}
 		} else {
 			if($this->_core->doctype) {
 				$this->_core->raiseError($this->_core->getModel('Translate/Collection')->get('CUSTOMER_LOGIN_WRONG_USER')->get('value'));
 			} else {
 				$this->_core->getBlock('Customer/Login')->init();
 			}
 			
 		}
 	}
 	function actionLogout() {
 		unset($_SESSION['customerid']);
		unset($_SESSION['cart']);
 		$this->_core->redirect($this->_core->getSingleton('Config')->topFolder);
 	}
 	function prepareUrls() {
 		$this->pushUrl('customer-list', $this->_siteUrl . 'customer/list');
 		$this->pushUrl('customer-view', $this->_siteUrl . 'customer/view');
 		$this->pushUrl('customer-save', $this->_siteUrl . 'customer/save');
 		$this->pushUrl('customer-login', $this->_siteUrl . 'customer/login');
 		$this->pushUrl('customer-register', $this->_siteUrl . 'customer/register');
 		$this->pushUrl('customer-register-verify', $this->_siteUrl . 'customer/register/verify');
 		$this->pushUrl('customer-register-success', $this->_siteUrl . 'customer/register/success');
 		$this->pushUrl('customer-register-verify-success', $this->_siteUrl . 'customer/register/verify/success');
 		$this->pushUrl('customer-support', $this->_siteUrl . 'customer/support');
 		$this->pushUrl('customer-support-message', $this->_siteUrl . 'customer/support/message');
 		$this->pushUrl('customer-support-message-send', $this->_siteUrl . 'customer/support/message/send');
 		$this->pushUrl('customer-support-message-send-success', $this->_siteUrl . 'customer/support/message/send/success');
 		$this->pushUrl('customer-message', $this->_siteUrl . 'customer/message');
 		$this->pushUrl('customer-message-send', $this->_siteUrl . 'customer/message/send');
 		$this->pushUrl('customer-message-remove', $this->_siteUrl . 'customer/message/remove');
 		$this->pushUrl('customer-message-group-remove', $this->_siteUrl . 'customer/message/group/remove');
 		$this->pushUrl('customer-password-forgot', $this->_siteUrl . 'customer/password/forgot');
 		$this->pushUrl('customer-password-reset', $this->_siteUrl . 'customer/password/reset');
 		$this->pushUrl('customer-password-reset-verify', $this->_siteUrl . 'customer/password/reset/verify');
 		$this->pushUrl('customer-password-reset-success', $this->_siteUrl . 'customer/password/reset/success');
 		$this->pushUrl('customer-edit', $this->_siteUrl . 'customer/edit');
 		$this->pushUrl('customer-save', $this->_siteUrl . 'customer/save');
 		return $this;
 	}
 }