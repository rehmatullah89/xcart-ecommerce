<?php die(); ?>          0O:34:"Doctrine\ORM\Mapping\ClassMetadata":13:{s:19:"associationMappings";a:2:{s:6:"states";a:16:{s:9:"fieldName";s:6:"states";s:8:"mappedBy";s:7:"country";s:12:"targetEntity";s:17:"XLite\Model\State";s:7:"cascade";a:5:{i:0;s:6:"remove";i:1;s:7:"persist";i:2;s:7:"refresh";i:3;s:5:"merge";i:4;s:6:"detach";}s:13:"orphanRemoval";b:0;s:5:"fetch";i:2;s:7:"orderBy";a:1:{s:5:"state";s:3:"ASC";}s:4:"type";i:4;s:10:"inversedBy";N;s:12:"isOwningSide";b:0;s:12:"sourceEntity";s:19:"XLite\Model\Country";s:15:"isCascadeRemove";b:1;s:16:"isCascadePersist";b:1;s:16:"isCascadeRefresh";b:1;s:14:"isCascadeMerge";b:1;s:15:"isCascadeDetach";b:1;}s:8:"currency";a:19:{s:9:"fieldName";s:8:"currency";s:11:"joinColumns";a:1:{i:0;a:6:{s:4:"name";s:11:"currency_id";s:20:"referencedColumnName";s:11:"currency_id";s:6:"unique";b:0;s:8:"nullable";b:1;s:8:"onDelete";N;s:16:"columnDefinition";N;}}s:7:"cascade";a:0:{}s:10:"inversedBy";s:9:"countries";s:12:"targetEntity";s:20:"XLite\Model\Currency";s:5:"fetch";i:2;s:4:"type";i:2;s:8:"mappedBy";N;s:12:"isOwningSide";b:1;s:12:"sourceEntity";s:19:"XLite\Model\Country";s:15:"isCascadeRemove";b:0;s:16:"isCascadePersist";b:0;s:16:"isCascadeRefresh";b:0;s:14:"isCascadeMerge";b:0;s:15:"isCascadeDetach";b:0;s:24:"sourceToTargetKeyColumns";a:1:{s:11:"currency_id";s:11:"currency_id";}s:20:"joinColumnFieldNames";a:1:{s:11:"currency_id";s:11:"currency_id";}s:24:"targetToSourceKeyColumns";a:1:{s:11:"currency_id";s:11:"currency_id";}s:13:"orphanRemoval";b:0;}}s:11:"columnNames";a:5:{s:7:"country";s:7:"country";s:4:"code";s:4:"code";s:2:"id";s:2:"id";s:5:"code3";s:5:"code3";s:7:"enabled";s:7:"enabled";}s:13:"fieldMappings";a:5:{s:7:"country";a:8:{s:9:"fieldName";s:7:"country";s:4:"type";s:6:"string";s:6:"length";i:50;s:9:"precision";i:0;s:5:"scale";i:0;s:8:"nullable";b:0;s:6:"unique";b:0;s:10:"columnName";s:7:"country";}s:4:"code";a:9:{s:9:"fieldName";s:4:"code";s:4:"type";s:11:"fixedstring";s:6:"length";i:2;s:9:"precision";i:0;s:5:"scale";i:0;s:8:"nullable";b:0;s:6:"unique";b:1;s:2:"id";b:1;s:10:"columnName";s:4:"code";}s:2:"id";a:8:{s:9:"fieldName";s:2:"id";s:4:"type";s:7:"integer";s:6:"length";N;s:9:"precision";i:0;s:5:"scale";i:0;s:8:"nullable";b:0;s:6:"unique";b:0;s:10:"columnName";s:2:"id";}s:5:"code3";a:8:{s:9:"fieldName";s:5:"code3";s:4:"type";s:11:"fixedstring";s:6:"length";i:3;s:9:"precision";i:0;s:5:"scale";i:0;s:8:"nullable";b:0;s:6:"unique";b:0;s:10:"columnName";s:5:"code3";}s:7:"enabled";a:8:{s:9:"fieldName";s:7:"enabled";s:4:"type";s:7:"boolean";s:6:"length";N;s:9:"precision";i:0;s:5:"scale";i:0;s:8:"nullable";b:0;s:6:"unique";b:0;s:10:"columnName";s:7:"enabled";}}s:10:"fieldNames";a:5:{s:7:"country";s:7:"country";s:4:"code";s:4:"code";s:2:"id";s:2:"id";s:5:"code3";s:5:"code3";s:7:"enabled";s:7:"enabled";}s:10:"identifier";a:1:{i:0;s:4:"code";}s:21:"isIdentifierComposite";b:0;s:4:"name";s:19:"XLite\Model\Country";s:9:"namespace";s:11:"XLite\Model";s:5:"table";a:2:{s:4:"name";s:12:"xc_countries";s:7:"indexes";a:2:{s:7:"country";a:1:{s:7:"columns";a:1:{i:0;s:7:"country";}}s:7:"enabled";a:1:{s:7:"columns";a:1:{i:0;s:7:"enabled";}}}}s:14:"rootEntityName";s:19:"XLite\Model\Country";s:11:"idGenerator";O:33:"Doctrine\ORM\Id\AssignedGenerator":0:{}s:25:"customRepositoryClassName";s:25:"\XLite\Model\Repo\Country";s:18:"lifecycleCallbacks";a:1:{s:9:"preRemove";a:1:{i:0;s:18:"removeZoneElements";}}}