<?php die(); ?>          0O:31:"Doctrine\ORM\Query\ParserResult":3:{s:45:" Doctrine\ORM\Query\ParserResult _sqlExecutor";O:44:"Doctrine\ORM\Query\Exec\SingleSelectExecutor":2:{s:17:" * _sqlStatements";s:592:"SELECT x0_.order_id AS order_id0, x0_.shipping_id AS shipping_id1, x0_.shipping_method_name AS shipping_method_name2, x0_.tracking AS tracking3, x0_.date AS date4, x0_.lastRenewDate AS lastRenewDate5, x0_.status AS status6, x0_.notes AS notes7, x0_.adminNotes AS adminNotes8, x0_.orderNumber AS orderNumber9, x0_.total AS total10, x0_.subtotal AS subtotal11, x0_.is_order AS is_order12, x0_.profile_id AS profile_id13, x0_.orig_profile_id AS orig_profile_id14, x0_.currency_id AS currency_id15 FROM xc_orders x0_ WHERE (x0_.status = ? AND x0_.lastRenewDate < ?) AND x0_.is_order IN ('1', '0')";s:20:" * queryCacheProfile";N;}s:50:" Doctrine\ORM\Query\ParserResult _resultSetMapping";O:35:"Doctrine\ORM\Query\ResultSetMapping":14:{s:7:"isMixed";b:0;s:8:"aliasMap";a:1:{s:1:"o";s:17:"XLite\Model\Order";}s:11:"relationMap";a:0:{}s:14:"parentAliasMap";a:0:{}s:13:"fieldMappings";a:12:{s:9:"order_id0";s:8:"order_id";s:12:"shipping_id1";s:11:"shipping_id";s:21:"shipping_method_name2";s:20:"shipping_method_name";s:9:"tracking3";s:8:"tracking";s:5:"date4";s:4:"date";s:14:"lastRenewDate5";s:13:"lastRenewDate";s:7:"status6";s:6:"status";s:6:"notes7";s:5:"notes";s:11:"adminNotes8";s:10:"adminNotes";s:12:"orderNumber9";s:11:"orderNumber";s:7:"total10";s:5:"total";s:10:"subtotal11";s:8:"subtotal";}s:14:"scalarMappings";a:0:{}s:12:"typeMappings";a:0:{}s:14:"entityMappings";a:1:{s:1:"o";N;}s:12:"metaMappings";a:4:{s:10:"is_order12";s:8:"is_order";s:12:"profile_id13";s:10:"profile_id";s:17:"orig_profile_id14";s:15:"orig_profile_id";s:13:"currency_id15";s:11:"currency_id";}s:14:"columnOwnerMap";a:16:{s:9:"order_id0";s:1:"o";s:12:"shipping_id1";s:1:"o";s:21:"shipping_method_name2";s:1:"o";s:9:"tracking3";s:1:"o";s:5:"date4";s:1:"o";s:14:"lastRenewDate5";s:1:"o";s:7:"status6";s:1:"o";s:6:"notes7";s:1:"o";s:11:"adminNotes8";s:1:"o";s:12:"orderNumber9";s:1:"o";s:7:"total10";s:1:"o";s:10:"subtotal11";s:1:"o";s:10:"is_order12";s:1:"o";s:12:"profile_id13";s:1:"o";s:17:"orig_profile_id14";s:1:"o";s:13:"currency_id15";s:1:"o";}s:20:"discriminatorColumns";a:1:{s:1:"o";s:10:"is_order12";}s:10:"indexByMap";a:0:{}s:16:"declaringClasses";a:12:{s:9:"order_id0";s:17:"XLite\Model\Order";s:12:"shipping_id1";s:17:"XLite\Model\Order";s:21:"shipping_method_name2";s:17:"XLite\Model\Order";s:9:"tracking3";s:17:"XLite\Model\Order";s:5:"date4";s:17:"XLite\Model\Order";s:14:"lastRenewDate5";s:17:"XLite\Model\Order";s:7:"status6";s:17:"XLite\Model\Order";s:6:"notes7";s:17:"XLite\Model\Order";s:11:"adminNotes8";s:17:"XLite\Model\Order";s:12:"orderNumber9";s:17:"XLite\Model\Order";s:7:"total10";s:17:"XLite\Model\Order";s:10:"subtotal11";s:17:"XLite\Model\Order";}s:18:"isIdentifierColumn";a:0:{}}s:51:" Doctrine\ORM\Query\ParserResult _parameterMappings";a:2:{s:10:"tempStatus";a:1:{i:0;i:0;}s:4:"time";a:1:{i:0;i:1;}}}