<?php die(1); ?>
[10-Apr-2014 07:23:04] Error (code: -7777): 
Server API: apache2handler;
Request method: GET;
URI: /xcart/;
Backtrace: 
#0 C:\wamp\www\xcart\Includes\ErrorHandler.php(334): Includes\ErrorHandler::throwException('', -7777)
#1 C:\wamp\www\xcart\var\run\classes\XLite\Controller\Customer\ACustomerAbstract.php(320): Includes\ErrorHandler::fireError('', -7777)
#2 C:\wamp\www\xcart\var\run\classes\XLite\Controller\Customer\ACustomerAbstract.php(249): XLite\Controller\Customer\ACustomerAbstract->closeStorefront()
#3 C:\wamp\www\xcart\var\run\classes\XLite.php(407): XLite\Controller\Customer\ACustomerAbstract->handleRequest()
#4 C:\wamp\www\xcart\var\run\classes\XLite.php(432): XLite->runController()
#5 C:\wamp\www\xcart\cart.php(32): XLite->processRequest()
#6 {main}

