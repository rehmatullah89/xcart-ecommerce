<?php die(); ?>          0O:31:"Doctrine\ORM\Query\ParserResult":3:{s:45:" Doctrine\ORM\Query\ParserResult _sqlExecutor";O:44:"Doctrine\ORM\Query\Exec\SingleSelectExecutor":2:{s:17:" * _sqlStatements";s:713:"SELECT x0_.item_id AS item_id0, x0_.name AS name1, x0_.sku AS sku2, x0_.price AS price3, x0_.itemNetPrice AS itemNetPrice4, x0_.discountedSubtotal AS discountedSubtotal5, x0_.amount AS amount6, x0_.total AS total7, x0_.subtotal AS subtotal8, SUM(x0_.amount) AS sclr9, x1_.date AS date10, x0_.object_type AS object_type11, x0_.object_id AS object_id12, x0_.order_id AS order_id13 FROM xc_order_items x0_ INNER JOIN xc_orders x1_ ON x0_.order_id = x1_.order_id AND x1_.is_order IN ('1', '0') INNER JOIN xc_currencies x2_ ON x1_.currency_id = x2_.currency_id AND (x2_.currency_id = ?) WHERE (x1_.status IN ('C', 'A', 'P')) AND x0_.object_type IN ('product') GROUP BY x0_.sku ORDER BY sclr9 DESC, x0_.name ASC LIMIT 5";s:20:" * queryCacheProfile";N;}s:50:" Doctrine\ORM\Query\ParserResult _resultSetMapping";O:35:"Doctrine\ORM\Query\ResultSetMapping":14:{s:7:"isMixed";b:1;s:8:"aliasMap";a:1:{s:1:"o";s:21:"XLite\Model\OrderItem";}s:11:"relationMap";a:0:{}s:14:"parentAliasMap";a:0:{}s:13:"fieldMappings";a:9:{s:8:"item_id0";s:7:"item_id";s:5:"name1";s:4:"name";s:4:"sku2";s:3:"sku";s:6:"price3";s:5:"price";s:13:"itemNetPrice4";s:12:"itemNetPrice";s:19:"discountedSubtotal5";s:18:"discountedSubtotal";s:7:"amount6";s:6:"amount";s:6:"total7";s:5:"total";s:9:"subtotal8";s:8:"subtotal";}s:14:"scalarMappings";a:2:{s:5:"sclr9";s:3:"cnt";s:6:"date10";s:4:"date";}s:12:"typeMappings";a:2:{s:5:"sclr9";s:6:"string";s:6:"date10";s:7:"integer";}s:14:"entityMappings";a:1:{s:1:"o";N;}s:12:"metaMappings";a:3:{s:13:"object_type11";s:11:"object_type";s:11:"object_id12";s:9:"object_id";s:10:"order_id13";s:8:"order_id";}s:14:"columnOwnerMap";a:12:{s:8:"item_id0";s:1:"o";s:5:"name1";s:1:"o";s:4:"sku2";s:1:"o";s:6:"price3";s:1:"o";s:13:"itemNetPrice4";s:1:"o";s:19:"discountedSubtotal5";s:1:"o";s:7:"amount6";s:1:"o";s:6:"total7";s:1:"o";s:9:"subtotal8";s:1:"o";s:13:"object_type11";s:1:"o";s:11:"object_id12";s:1:"o";s:10:"order_id13";s:1:"o";}s:20:"discriminatorColumns";a:1:{s:1:"o";s:13:"object_type11";}s:10:"indexByMap";a:0:{}s:16:"declaringClasses";a:9:{s:8:"item_id0";s:21:"XLite\Model\OrderItem";s:5:"name1";s:21:"XLite\Model\OrderItem";s:4:"sku2";s:21:"XLite\Model\OrderItem";s:6:"price3";s:21:"XLite\Model\OrderItem";s:13:"itemNetPrice4";s:21:"XLite\Model\OrderItem";s:19:"discountedSubtotal5";s:21:"XLite\Model\OrderItem";s:7:"amount6";s:21:"XLite\Model\OrderItem";s:6:"total7";s:21:"XLite\Model\OrderItem";s:9:"subtotal8";s:21:"XLite\Model\OrderItem";}s:18:"isIdentifierColumn";a:0:{}}s:51:" Doctrine\ORM\Query\ParserResult _parameterMappings";a:1:{s:11:"currency_id";a:1:{i:0;i:0;}}}