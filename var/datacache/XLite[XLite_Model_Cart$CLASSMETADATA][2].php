<?php die(); ?>          0O:34:"Doctrine\ORM\Mapping\ClassMetadata":20:{s:19:"associationMappings";a:8:{s:7:"profile";a:21:{s:9:"fieldName";s:7:"profile";s:12:"targetEntity";s:19:"XLite\Model\Profile";s:11:"joinColumns";a:1:{i:0;a:6:{s:4:"name";s:10:"profile_id";s:20:"referencedColumnName";s:10:"profile_id";s:6:"unique";b:0;s:8:"nullable";b:1;s:8:"onDelete";N;s:16:"columnDefinition";N;}}s:8:"mappedBy";N;s:10:"inversedBy";N;s:7:"cascade";a:5:{i:0;s:6:"remove";i:1;s:7:"persist";i:2;s:7:"refresh";i:3;s:5:"merge";i:4;s:6:"detach";}s:13:"orphanRemoval";b:0;s:5:"fetch";i:2;s:4:"type";i:1;s:12:"isOwningSide";b:1;s:12:"sourceEntity";s:17:"XLite\Model\Order";s:15:"isCascadeRemove";b:1;s:16:"isCascadePersist";b:1;s:16:"isCascadeRefresh";b:1;s:14:"isCascadeMerge";b:1;s:15:"isCascadeDetach";b:1;s:24:"sourceToTargetKeyColumns";a:1:{s:10:"profile_id";s:10:"profile_id";}s:20:"joinColumnFieldNames";a:1:{s:10:"profile_id";s:10:"profile_id";}s:24:"targetToSourceKeyColumns";a:1:{s:10:"profile_id";s:10:"profile_id";}s:9:"inherited";s:17:"XLite\Model\Order";s:8:"declared";s:17:"XLite\Model\Order";}s:12:"orig_profile";a:21:{s:9:"fieldName";s:12:"orig_profile";s:11:"joinColumns";a:1:{i:0;a:6:{s:4:"name";s:15:"orig_profile_id";s:20:"referencedColumnName";s:10:"profile_id";s:6:"unique";b:0;s:8:"nullable";b:1;s:8:"onDelete";N;s:16:"columnDefinition";N;}}s:7:"cascade";a:0:{}s:10:"inversedBy";N;s:12:"targetEntity";s:19:"XLite\Model\Profile";s:5:"fetch";i:2;s:4:"type";i:2;s:8:"mappedBy";N;s:12:"isOwningSide";b:1;s:12:"sourceEntity";s:17:"XLite\Model\Order";s:15:"isCascadeRemove";b:0;s:16:"isCascadePersist";b:0;s:16:"isCascadeRefresh";b:0;s:14:"isCascadeMerge";b:0;s:15:"isCascadeDetach";b:0;s:24:"sourceToTargetKeyColumns";a:1:{s:15:"orig_profile_id";s:10:"profile_id";}s:20:"joinColumnFieldNames";a:1:{s:15:"orig_profile_id";s:15:"orig_profile_id";}s:24:"targetToSourceKeyColumns";a:1:{s:10:"profile_id";s:15:"orig_profile_id";}s:13:"orphanRemoval";b:0;s:9:"inherited";s:17:"XLite\Model\Order";s:8:"declared";s:17:"XLite\Model\Order";}s:7:"details";a:18:{s:9:"fieldName";s:7:"details";s:8:"mappedBy";s:5:"order";s:12:"targetEntity";s:23:"XLite\Model\OrderDetail";s:7:"cascade";a:5:{i:0;s:6:"remove";i:1;s:7:"persist";i:2;s:7:"refresh";i:3;s:5:"merge";i:4;s:6:"detach";}s:13:"orphanRemoval";b:0;s:5:"fetch";i:2;s:7:"orderBy";a:1:{s:4:"name";s:3:"ASC";}s:4:"type";i:4;s:10:"inversedBy";N;s:12:"isOwningSide";b:0;s:12:"sourceEntity";s:17:"XLite\Model\Order";s:15:"isCascadeRemove";b:1;s:16:"isCascadePersist";b:1;s:16:"isCascadeRefresh";b:1;s:14:"isCascadeMerge";b:1;s:15:"isCascadeDetach";b:1;s:9:"inherited";s:17:"XLite\Model\Order";s:8:"declared";s:17:"XLite\Model\Order";}s:6:"events";a:17:{s:9:"fieldName";s:6:"events";s:8:"mappedBy";s:5:"order";s:12:"targetEntity";s:30:"XLite\Model\OrderHistoryEvents";s:7:"cascade";a:5:{i:0;s:6:"remove";i:1;s:7:"persist";i:2;s:7:"refresh";i:3;s:5:"merge";i:4;s:6:"detach";}s:13:"orphanRemoval";b:0;s:5:"fetch";i:2;s:4:"type";i:4;s:10:"inversedBy";N;s:12:"isOwningSide";b:0;s:12:"sourceEntity";s:17:"XLite\Model\Order";s:15:"isCascadeRemove";b:1;s:16:"isCascadePersist";b:1;s:16:"isCascadeRefresh";b:1;s:14:"isCascadeMerge";b:1;s:15:"isCascadeDetach";b:1;s:9:"inherited";s:17:"XLite\Model\Order";s:8:"declared";s:17:"XLite\Model\Order";}s:5:"items";a:17:{s:9:"fieldName";s:5:"items";s:8:"mappedBy";s:5:"order";s:12:"targetEntity";s:21:"XLite\Model\OrderItem";s:7:"cascade";a:5:{i:0;s:6:"remove";i:1;s:7:"persist";i:2;s:7:"refresh";i:3;s:5:"merge";i:4;s:6:"detach";}s:13:"orphanRemoval";b:0;s:5:"fetch";i:2;s:4:"type";i:4;s:10:"inversedBy";N;s:12:"isOwningSide";b:0;s:12:"sourceEntity";s:17:"XLite\Model\Order";s:15:"isCascadeRemove";b:1;s:16:"isCascadePersist";b:1;s:16:"isCascadeRefresh";b:1;s:14:"isCascadeMerge";b:1;s:15:"isCascadeDetach";b:1;s:9:"inherited";s:17:"XLite\Model\Order";s:8:"declared";s:17:"XLite\Model\Order";}s:10:"surcharges";a:18:{s:9:"fieldName";s:10:"surcharges";s:8:"mappedBy";s:5:"owner";s:12:"targetEntity";s:27:"XLite\Model\Order\Surcharge";s:7:"cascade";a:5:{i:0;s:6:"remove";i:1;s:7:"persist";i:2;s:7:"refresh";i:3;s:5:"merge";i:4;s:6:"detach";}s:13:"orphanRemoval";b:0;s:5:"fetch";i:2;s:7:"orderBy";a:1:{s:2:"id";s:3:"ASC";}s:4:"type";i:4;s:10:"inversedBy";N;s:12:"isOwningSide";b:0;s:12:"sourceEntity";s:17:"XLite\Model\Order";s:15:"isCascadeRemove";b:1;s:16:"isCascadePersist";b:1;s:16:"isCascadeRefresh";b:1;s:14:"isCascadeMerge";b:1;s:15:"isCascadeDetach";b:1;s:9:"inherited";s:17:"XLite\Model\Order";s:8:"declared";s:17:"XLite\Model\Order";}s:20:"payment_transactions";a:17:{s:9:"fieldName";s:20:"payment_transactions";s:8:"mappedBy";s:5:"order";s:12:"targetEntity";s:31:"XLite\Model\Payment\Transaction";s:7:"cascade";a:5:{i:0;s:6:"remove";i:1;s:7:"persist";i:2;s:7:"refresh";i:3;s:5:"merge";i:4;s:6:"detach";}s:13:"orphanRemoval";b:0;s:5:"fetch";i:2;s:4:"type";i:4;s:10:"inversedBy";N;s:12:"isOwningSide";b:0;s:12:"sourceEntity";s:17:"XLite\Model\Order";s:15:"isCascadeRemove";b:1;s:16:"isCascadePersist";b:1;s:16:"isCascadeRefresh";b:1;s:14:"isCascadeMerge";b:1;s:15:"isCascadeDetach";b:1;s:9:"inherited";s:17:"XLite\Model\Order";s:8:"declared";s:17:"XLite\Model\Order";}s:8:"currency";a:21:{s:9:"fieldName";s:8:"currency";s:11:"joinColumns";a:1:{i:0;a:6:{s:4:"name";s:11:"currency_id";s:20:"referencedColumnName";s:11:"currency_id";s:6:"unique";b:0;s:8:"nullable";b:1;s:8:"onDelete";N;s:16:"columnDefinition";N;}}s:7:"cascade";a:2:{i:0;s:5:"merge";i:1;s:6:"detach";}s:10:"inversedBy";s:6:"orders";s:12:"targetEntity";s:20:"XLite\Model\Currency";s:5:"fetch";i:2;s:4:"type";i:2;s:8:"mappedBy";N;s:12:"isOwningSide";b:1;s:12:"sourceEntity";s:17:"XLite\Model\Order";s:15:"isCascadeRemove";b:0;s:16:"isCascadePersist";b:0;s:16:"isCascadeRefresh";b:0;s:14:"isCascadeMerge";b:1;s:15:"isCascadeDetach";b:1;s:24:"sourceToTargetKeyColumns";a:1:{s:11:"currency_id";s:11:"currency_id";}s:20:"joinColumnFieldNames";a:1:{s:11:"currency_id";s:11:"currency_id";}s:24:"targetToSourceKeyColumns";a:1:{s:11:"currency_id";s:11:"currency_id";}s:13:"orphanRemoval";b:0;s:9:"inherited";s:17:"XLite\Model\Order";s:8:"declared";s:17:"XLite\Model\Order";}}s:11:"columnNames";a:12:{s:8:"order_id";s:8:"order_id";s:11:"shipping_id";s:11:"shipping_id";s:20:"shipping_method_name";s:20:"shipping_method_name";s:8:"tracking";s:8:"tracking";s:4:"date";s:4:"date";s:13:"lastRenewDate";s:13:"lastRenewDate";s:6:"status";s:6:"status";s:5:"notes";s:5:"notes";s:10:"adminNotes";s:10:"adminNotes";s:11:"orderNumber";s:11:"orderNumber";s:5:"total";s:5:"total";s:8:"subtotal";s:8:"subtotal";}s:13:"fieldMappings";a:12:{s:8:"order_id";a:11:{s:9:"fieldName";s:8:"order_id";s:4:"type";s:7:"integer";s:6:"length";N;s:9:"precision";i:0;s:5:"scale";i:0;s:8:"nullable";b:0;s:6:"unique";b:0;s:2:"id";b:1;s:10:"columnName";s:8:"order_id";s:9:"inherited";s:17:"XLite\Model\Order";s:8:"declared";s:17:"XLite\Model\Order";}s:11:"shipping_id";a:10:{s:9:"fieldName";s:11:"shipping_id";s:4:"type";s:7:"integer";s:6:"length";N;s:9:"precision";i:0;s:5:"scale";i:0;s:8:"nullable";b:0;s:6:"unique";b:0;s:10:"columnName";s:11:"shipping_id";s:9:"inherited";s:17:"XLite\Model\Order";s:8:"declared";s:17:"XLite\Model\Order";}s:20:"shipping_method_name";a:10:{s:9:"fieldName";s:20:"shipping_method_name";s:4:"type";s:6:"string";s:6:"length";N;s:9:"precision";i:0;s:5:"scale";i:0;s:8:"nullable";b:1;s:6:"unique";b:0;s:10:"columnName";s:20:"shipping_method_name";s:9:"inherited";s:17:"XLite\Model\Order";s:8:"declared";s:17:"XLite\Model\Order";}s:8:"tracking";a:10:{s:9:"fieldName";s:8:"tracking";s:4:"type";s:6:"string";s:6:"length";i:32;s:9:"precision";i:0;s:5:"scale";i:0;s:8:"nullable";b:0;s:6:"unique";b:0;s:10:"columnName";s:8:"tracking";s:9:"inherited";s:17:"XLite\Model\Order";s:8:"declared";s:17:"XLite\Model\Order";}s:4:"date";a:10:{s:9:"fieldName";s:4:"date";s:4:"type";s:7:"integer";s:6:"length";N;s:9:"precision";i:0;s:5:"scale";i:0;s:8:"nullable";b:0;s:6:"unique";b:0;s:10:"columnName";s:4:"date";s:9:"inherited";s:17:"XLite\Model\Order";s:8:"declared";s:17:"XLite\Model\Order";}s:13:"lastRenewDate";a:10:{s:9:"fieldName";s:13:"lastRenewDate";s:4:"type";s:7:"integer";s:6:"length";N;s:9:"precision";i:0;s:5:"scale";i:0;s:8:"nullable";b:0;s:6:"unique";b:0;s:10:"columnName";s:13:"lastRenewDate";s:9:"inherited";s:17:"XLite\Model\Order";s:8:"declared";s:17:"XLite\Model\Order";}s:6:"status";a:10:{s:9:"fieldName";s:6:"status";s:4:"type";s:11:"fixedstring";s:6:"length";i:2;s:9:"precision";i:0;s:5:"scale";i:0;s:8:"nullable";b:0;s:6:"unique";b:0;s:10:"columnName";s:6:"status";s:9:"inherited";s:17:"XLite\Model\Order";s:8:"declared";s:17:"XLite\Model\Order";}s:5:"notes";a:10:{s:9:"fieldName";s:5:"notes";s:4:"type";s:4:"text";s:6:"length";N;s:9:"precision";i:0;s:5:"scale";i:0;s:8:"nullable";b:0;s:6:"unique";b:0;s:10:"columnName";s:5:"notes";s:9:"inherited";s:17:"XLite\Model\Order";s:8:"declared";s:17:"XLite\Model\Order";}s:10:"adminNotes";a:10:{s:9:"fieldName";s:10:"adminNotes";s:4:"type";s:4:"text";s:6:"length";N;s:9:"precision";i:0;s:5:"scale";i:0;s:8:"nullable";b:0;s:6:"unique";b:0;s:10:"columnName";s:10:"adminNotes";s:9:"inherited";s:17:"XLite\Model\Order";s:8:"declared";s:17:"XLite\Model\Order";}s:11:"orderNumber";a:10:{s:9:"fieldName";s:11:"orderNumber";s:4:"type";s:4:"text";s:6:"length";N;s:9:"precision";i:0;s:5:"scale";i:0;s:8:"nullable";b:1;s:6:"unique";b:0;s:10:"columnName";s:11:"orderNumber";s:9:"inherited";s:17:"XLite\Model\Order";s:8:"declared";s:17:"XLite\Model\Order";}s:5:"total";a:10:{s:9:"fieldName";s:5:"total";s:4:"type";s:7:"decimal";s:6:"length";N;s:9:"precision";i:14;s:5:"scale";i:4;s:8:"nullable";b:0;s:6:"unique";b:0;s:10:"columnName";s:5:"total";s:9:"inherited";s:17:"XLite\Model\Order";s:8:"declared";s:17:"XLite\Model\Order";}s:8:"subtotal";a:10:{s:9:"fieldName";s:8:"subtotal";s:4:"type";s:7:"decimal";s:6:"length";N;s:9:"precision";i:14;s:5:"scale";i:4;s:8:"nullable";b:0;s:6:"unique";b:0;s:10:"columnName";s:8:"subtotal";s:9:"inherited";s:17:"XLite\Model\Order";s:8:"declared";s:17:"XLite\Model\Order";}}s:10:"fieldNames";a:12:{s:8:"order_id";s:8:"order_id";s:11:"shipping_id";s:11:"shipping_id";s:20:"shipping_method_name";s:20:"shipping_method_name";s:8:"tracking";s:8:"tracking";s:4:"date";s:4:"date";s:13:"lastRenewDate";s:13:"lastRenewDate";s:6:"status";s:6:"status";s:5:"notes";s:5:"notes";s:10:"adminNotes";s:10:"adminNotes";s:11:"orderNumber";s:11:"orderNumber";s:5:"total";s:5:"total";s:8:"subtotal";s:8:"subtotal";}s:10:"identifier";a:1:{i:0;s:8:"order_id";}s:21:"isIdentifierComposite";b:0;s:4:"name";s:16:"XLite\Model\Cart";s:9:"namespace";s:11:"XLite\Model";s:5:"table";a:2:{s:4:"name";s:9:"xc_orders";s:7:"indexes";a:6:{s:4:"date";a:1:{s:7:"columns";a:1:{i:0;s:4:"date";}}s:5:"total";a:1:{s:7:"columns";a:1:{i:0;s:5:"total";}}s:8:"subtotal";a:1:{s:7:"columns";a:1:{i:0;s:8:"subtotal";}}s:8:"tracking";a:1:{s:7:"columns";a:1:{i:0;s:8:"tracking";}}s:6:"status";a:1:{s:7:"columns";a:1:{i:0;s:6:"status";}}s:11:"shipping_id";a:1:{s:7:"columns";a:1:{i:0;s:11:"shipping_id";}}}}s:14:"rootEntityName";s:17:"XLite\Model\Order";s:11:"idGenerator";O:33:"Doctrine\ORM\Id\IdentityGenerator":1:{s:43:" Doctrine\ORM\Id\IdentityGenerator _seqName";N;}s:25:"customRepositoryClassName";s:22:"\XLite\Model\Repo\Cart";s:15:"inheritanceType";i:3;s:19:"discriminatorColumn";a:4:{s:4:"name";s:8:"is_order";s:4:"type";s:7:"integer";s:6:"length";i:1;s:9:"fieldName";s:8:"is_order";}s:18:"discriminatorValue";i:0;s:16:"discriminatorMap";a:2:{i:1;s:17:"XLite\Model\Order";i:0;s:16:"XLite\Model\Cart";}s:13:"parentClasses";a:1:{i:0;s:17:"XLite\Model\Order";}s:10:"subClasses";a:0:{}s:13:"generatorType";i:4;s:18:"lifecycleCallbacks";a:3:{s:10:"prePersist";a:3:{i:0;s:17:"prepareBeforeSave";i:1;s:17:"prepareBeforeSave";i:2;s:19:"prepareBeforeCreate";}s:9:"preUpdate";a:2:{i:0;s:17:"prepareBeforeSave";i:1;s:17:"prepareBeforeSave";}s:9:"preRemove";a:1:{i:0;s:19:"prepareBeforeRemove";}}}