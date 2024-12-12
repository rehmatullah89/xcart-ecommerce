<?php die(1); ?>
[09-Apr-2014 11:42:56 UTC] PHP Fatal error:  Maximum execution time of 30 seconds exceeded in C:\wamp\www\xcart\var\run\classes\XLite\Module\XC\Mobile\View\Button\Link.php on line 37
[09-Apr-2014 11:42:56 UTC] PHP Stack trace:
[09-Apr-2014 11:42:56 UTC] PHP   1. {main}() C:\wamp\www\xcart\cart.php:0
[09-Apr-2014 11:42:56 UTC] PHP   2. XLite->processRequest() C:\wamp\www\xcart\cart.php:32
[09-Apr-2014 11:42:56 UTC] PHP   3. XLite\Controller\AControllerAbstract->processRequest() C:\wamp\www\xcart\var\run\classes\XLite.php:434
[09-Apr-2014 11:42:56 UTC] PHP   4. XLite\View\ControllerAbstract->display() C:\wamp\www\xcart\var\run\classes\XLite\Controller\AControllerAbstract.php:501
[09-Apr-2014 11:42:56 UTC] PHP   5. XLite\View\ControllerAbstract->displayPage() C:\wamp\www\xcart\var\run\classes\XLite\View\ControllerAbstract.php:71
[09-Apr-2014 11:42:56 UTC] PHP   6. XLite\View\ControllerAbstract->prepareContent() C:\wamp\www\xcart\var\run\classes\XLite\View\ControllerAbstract.php:300
[09-Apr-2014 11:42:56 UTC] PHP   7. XLite\View\AViewAbstract->getContent() C:\wamp\www\xcart\var\run\classes\XLite\View\ControllerAbstract.php:271
[09-Apr-2014 11:42:56 UTC] PHP   8. XLite\View\Content->display() C:\wamp\www\xcart\var\run\classes\XLite\View\AViewAbstract.php:313
[09-Apr-2014 11:42:56 UTC] PHP   9. XLite\View\AViewAbstract->display() C:\wamp\www\xcart\var\run\classes\XLite\View\Content.php:73
[09-Apr-2014 11:42:56 UTC] PHP  10. include() C:\wamp\www\xcart\var\run\classes\XLite\View\AViewAbstract.php:292
[09-Apr-2014 11:42:56 UTC] PHP  11. XLite\View\AViewAbstract->displayViewListContent() C:\wamp\www\xcart\var\run\skins\default\en\main.tpl.php:5
[09-Apr-2014 11:42:56 UTC] PHP  12. XLite\View\Content->display() C:\wamp\www\xcart\var\run\classes\XLite\View\AViewAbstract.php:1094
[09-Apr-2014 11:42:56 UTC] PHP  13. XLite\View\AViewAbstract->display() C:\wamp\www\xcart\var\run\classes\XLite\View\Content.php:73
[09-Apr-2014 11:42:56 UTC] PHP  14. include() C:\wamp\www\xcart\var\run\classes\XLite\View\AViewAbstract.php:292
[09-Apr-2014 11:42:56 UTC] PHP  15. XLite\View\AViewAbstract->displayViewListContent() C:\wamp\www\xcart\var\run\skins\default\en\layout\main.header.tpl.php:2
[09-Apr-2014 11:42:56 UTC] PHP  16. XLite\View\Content->display() C:\wamp\www\xcart\var\run\classes\XLite\View\AViewAbstract.php:1094
[09-Apr-2014 11:42:56 UTC] PHP  17. XLite\View\AViewAbstract->display() C:\wamp\www\xcart\var\run\classes\XLite\View\Content.php:73
[09-Apr-2014 11:42:56 UTC] PHP  18. include() C:\wamp\www\xcart\var\run\classes\XLite\View\AViewAbstract.php:292
[09-Apr-2014 11:42:56 UTC] PHP  19. XLite\View\AViewAbstract->displayViewListContent() C:\wamp\www\xcart\var\run\skins\default\en\layout\header.right.tpl.php:2
[09-Apr-2014 11:42:56 UTC] PHP  20. XLite\View\AViewAbstract->display() C:\wamp\www\xcart\var\run\classes\XLite\View\AViewAbstract.php:1094
[09-Apr-2014 11:42:56 UTC] PHP  21. include() C:\wamp\www\xcart\var\run\classes\XLite\View\AViewAbstract.php:292
[09-Apr-2014 11:42:56 UTC] PHP  22. XLite\View\AViewAbstract->display() C:\wamp\www\xcart\var\run\skins\default\en\common\sidebar_box.tpl.php:3
[09-Apr-2014 11:42:56 UTC] PHP  23. include() C:\wamp\www\xcart\var\run\classes\XLite\View\AViewAbstract.php:292
[09-Apr-2014 11:42:56 UTC] PHP  24. XLite\View\AViewAbstract->displayViewListContent() C:\wamp\www\xcart\var\run\skins\default\en\mini_cart\horizontal\body.tpl.php:3
[09-Apr-2014 11:42:56 UTC] PHP  25. XLite\View\AViewAbstract->display() C:\wamp\www\xcart\var\run\classes\XLite\View\AViewAbstract.php:1094
[09-Apr-2014 11:42:56 UTC] PHP  26. include() C:\wamp\www\xcart\var\run\classes\XLite\View\AViewAbstract.php:292
[09-Apr-2014 11:42:56 UTC] PHP  27. XLite\View\AViewAbstract->displayViewListContent() C:\wamp\www\xcart\var\run\skins\default\en\mini_cart\horizontal\parts\items.tpl.php:24
[09-Apr-2014 11:42:56 UTC] PHP  28. XLite\View\AViewAbstract->getViewList() C:\wamp\www\xcart\var\run\classes\XLite\View\AViewAbstract.php:1093
[09-Apr-2014 11:42:56 UTC] PHP  29. XLite\View\AViewAbstract->defineViewList() C:\wamp\www\xcart\var\run\classes\XLite\View\AViewAbstract.php:1713
[09-Apr-2014 11:42:56 UTC] PHP  30. XLite\View\AViewAbstract->getWidget() C:\wamp\www\xcart\var\run\classes\XLite\View\AViewAbstract.php:1822
[09-Apr-2014 11:42:56 UTC] PHP  31. XLite\View\AViewAbstract->getChildWidget() C:\wamp\www\xcart\var\run\classes\XLite\View\AViewAbstract.php:213
[09-Apr-2014 11:42:56 UTC] PHP  32. Includes\Autoloader::__lc_autoload() C:\wamp\www\xcart\var\run\classes\XLite\View\AViewAbstract.php:0
[09-Apr-2014 11:42:56 UTC] PHP  33. include_once() C:\wamp\www\xcart\Includes\Autoloader.php:125
[09-Apr-2014 11:42:56 UTC] PHP  34. Includes\Autoloader::__lc_autoload() C:\wamp\www\xcart\Includes\Autoloader.php:0
[09-Apr-2014 11:42:56 UTC] PHP  35. include_once() C:\wamp\www\xcart\Includes\Autoloader.php:125
[09-Apr-2014 11:42:56 UTC] PHP  36. Includes\Autoloader::__lc_autoload() C:\wamp\www\xcart\Includes\Autoloader.php:0
[09-Apr-2014 11:42:56 UTC] PHP  37. include_once() C:\wamp\www\xcart\Includes\Autoloader.php:125
[09-Apr-2014 11:42:56] Error (code: 1): Maximum execution time of 30 seconds exceeded
Server API: apache2handler;
Request method: GET;
URI: /xcart/cart.php;
Backtrace: 
#0  Includes\ErrorHandler::logInfo(Maximum execution time of 30 seconds exceeded, 1) called at [C:\wamp\www\xcart\Includes\ErrorHandler.php:306]
#1  Includes\ErrorHandler::handleError(Array ([type] => 1,[message] => Maximum execution time of 30 seconds exceeded,[file] => C:\wamp\www\xcart\var\run\classes\XLite\Module\XC\Mobile\View\Button\Link.php,[line] => 37)) called at [C:\wamp\www\xcart\Includes\ErrorHandler.php:291]
#2  Includes\ErrorHandler::shutdown()


