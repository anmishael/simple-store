<?php
/*
 * Created on 31 лип. 2012
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

 // Add Backend Events
//  Core::getSingleton('Core')->addEvent('admin-language-list', array('controller'=>'Admin/Language', 'method'=>'actionEdit'));
 
 // Add Frontent Events
Core::getSingleton('Core')->addEvent('customer-login', array('controller'=>'Product', 'method'=>'actionFavoriteAdd'));
Core::getSingleton('Core')->addEvent('product-remove-before', array('controller'=>'Admin/Product', 'method'=>'actionFiltersDisconnect'));
Core::getSingleton('Core')->addEvent('product-remove-before', array('controller'=>'Admin/Product', 'method'=>'actionBundleDisconnect'));
Core::getSingleton('Core')->addEvent('product-remove-before', array('controller'=>'Admin/Product', 'method'=>'actionPageDisconnect'));