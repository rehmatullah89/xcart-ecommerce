<?php die(); ?>          0O:31:"Doctrine\ORM\Query\ParserResult":3:{s:45:" Doctrine\ORM\Query\ParserResult _sqlExecutor";O:44:"Doctrine\ORM\Query\Exec\SingleSelectExecutor":2:{s:17:" * _sqlStatements";s:376:"SELECT x0_.state_id AS state_id0, x0_.state AS state1, x0_.code AS code2, x1_.country AS country3, x1_.code AS code4, x1_.id AS id5, x1_.code3 AS code36, x1_.enabled AS enabled7, x0_.country_code AS country_code8, x1_.currency_id AS currency_id9 FROM xc_states x0_ LEFT JOIN xc_countries x1_ ON x0_.country_code = x1_.code WHERE x0_.state_id = ? ORDER BY x0_.state ASC LIMIT 1";s:20:" * queryCacheProfile";N;}s:50:" Doctrine\ORM\Query\ParserResult _resultSetMapping";O:35:"Doctrine\ORM\Query\ResultSetMapping":14:{s:7:"isMixed";b:0;s:8:"aliasMap";a:2:{s:1:"s";s:17:"XLite\Model\State";s:1:"c";s:19:"XLite\Model\Country";}s:11:"relationMap";a:1:{s:1:"c";s:7:"country";}s:14:"parentAliasMap";a:1:{s:1:"c";s:1:"s";}s:13:"fieldMappings";a:8:{s:9:"state_id0";s:8:"state_id";s:6:"state1";s:5:"state";s:5:"code2";s:4:"code";s:8:"country3";s:7:"country";s:5:"code4";s:4:"code";s:3:"id5";s:2:"id";s:6:"code36";s:5:"code3";s:8:"enabled7";s:7:"enabled";}s:14:"scalarMappings";a:0:{}s:12:"typeMappings";a:0:{}s:14:"entityMappings";a:1:{s:1:"s";N;}s:12:"metaMappings";a:2:{s:13:"country_code8";s:12:"country_code";s:12:"currency_id9";s:11:"currency_id";}s:14:"columnOwnerMap";a:10:{s:9:"state_id0";s:1:"s";s:6:"state1";s:1:"s";s:5:"code2";s:1:"s";s:8:"country3";s:1:"c";s:5:"code4";s:1:"c";s:3:"id5";s:1:"c";s:6:"code36";s:1:"c";s:8:"enabled7";s:1:"c";s:13:"country_code8";s:1:"s";s:12:"currency_id9";s:1:"c";}s:20:"discriminatorColumns";a:0:{}s:10:"indexByMap";a:0:{}s:16:"declaringClasses";a:8:{s:9:"state_id0";s:17:"XLite\Model\State";s:6:"state1";s:17:"XLite\Model\State";s:5:"code2";s:17:"XLite\Model\State";s:8:"country3";s:19:"XLite\Model\Country";s:5:"code4";s:19:"XLite\Model\Country";s:3:"id5";s:19:"XLite\Model\Country";s:6:"code36";s:19:"XLite\Model\Country";s:8:"enabled7";s:19:"XLite\Model\Country";}s:18:"isIdentifierColumn";a:0:{}}s:51:" Doctrine\ORM\Query\ParserResult _parameterMappings";a:1:{s:2:"id";a:1:{i:0;i:0;}}}