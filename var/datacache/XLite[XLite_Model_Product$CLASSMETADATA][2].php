<?php die(); ?>          0O:34:"Doctrine\ORM\Mapping\ClassMetadata":14:{s:19:"associationMappings";a:14:{s:16:"featuredProducts";a:15:{s:9:"fieldName";s:16:"featuredProducts";s:8:"mappedBy";s:7:"product";s:12:"targetEntity";s:56:"XLite\Module\CDev\FeaturedProducts\Model\FeaturedProduct";s:7:"cascade";a:5:{i:0;s:6:"remove";i:1;s:7:"persist";i:2;s:7:"refresh";i:3;s:5:"merge";i:4;s:6:"detach";}s:13:"orphanRemoval";b:0;s:5:"fetch";i:2;s:4:"type";i:4;s:10:"inversedBy";N;s:12:"isOwningSide";b:0;s:12:"sourceEntity";s:19:"XLite\Model\Product";s:15:"isCascadeRemove";b:1;s:16:"isCascadePersist";b:1;s:16:"isCascadeRefresh";b:1;s:14:"isCascadeMerge";b:1;s:15:"isCascadeDetach";b:1;}s:16:"categoryProducts";a:16:{s:9:"fieldName";s:16:"categoryProducts";s:8:"mappedBy";s:7:"product";s:12:"targetEntity";s:28:"XLite\Model\CategoryProducts";s:7:"cascade";a:5:{i:0;s:6:"remove";i:1;s:7:"persist";i:2;s:7:"refresh";i:3;s:5:"merge";i:4;s:6:"detach";}s:13:"orphanRemoval";b:0;s:5:"fetch";i:2;s:7:"orderBy";a:1:{s:7:"orderby";s:3:"ASC";}s:4:"type";i:4;s:10:"inversedBy";N;s:12:"isOwningSide";b:0;s:12:"sourceEntity";s:19:"XLite\Model\Product";s:15:"isCascadeRemove";b:1;s:16:"isCascadePersist";b:1;s:16:"isCascadeRefresh";b:1;s:14:"isCascadeMerge";b:1;s:15:"isCascadeDetach";b:1;}s:11:"order_items";a:15:{s:9:"fieldName";s:11:"order_items";s:8:"mappedBy";s:6:"object";s:12:"targetEntity";s:21:"XLite\Model\OrderItem";s:7:"cascade";a:0:{}s:13:"orphanRemoval";b:0;s:5:"fetch";i:2;s:4:"type";i:4;s:10:"inversedBy";N;s:12:"isOwningSide";b:0;s:12:"sourceEntity";s:19:"XLite\Model\Product";s:15:"isCascadeRemove";b:0;s:16:"isCascadePersist";b:0;s:16:"isCascadeRefresh";b:0;s:14:"isCascadeMerge";b:0;s:15:"isCascadeDetach";b:0;}s:6:"images";a:16:{s:9:"fieldName";s:6:"images";s:8:"mappedBy";s:7:"product";s:12:"targetEntity";s:31:"XLite\Model\Image\Product\Image";s:7:"cascade";a:5:{i:0;s:6:"remove";i:1;s:7:"persist";i:2;s:7:"refresh";i:3;s:5:"merge";i:4;s:6:"detach";}s:13:"orphanRemoval";b:0;s:5:"fetch";i:2;s:7:"orderBy";a:1:{s:7:"orderby";s:3:"ASC";}s:4:"type";i:4;s:10:"inversedBy";N;s:12:"isOwningSide";b:0;s:12:"sourceEntity";s:19:"XLite\Model\Product";s:15:"isCascadeRemove";b:1;s:16:"isCascadePersist";b:1;s:16:"isCascadeRefresh";b:1;s:14:"isCascadeMerge";b:1;s:15:"isCascadeDetach";b:1;}s:9:"inventory";a:16:{s:9:"fieldName";s:9:"inventory";s:12:"targetEntity";s:21:"XLite\Model\Inventory";s:11:"joinColumns";a:0:{}s:8:"mappedBy";s:7:"product";s:10:"inversedBy";N;s:7:"cascade";a:5:{i:0;s:6:"remove";i:1;s:7:"persist";i:2;s:7:"refresh";i:3;s:5:"merge";i:4;s:6:"detach";}s:13:"orphanRemoval";b:0;s:5:"fetch";i:2;s:4:"type";i:1;s:12:"isOwningSide";b:0;s:12:"sourceEntity";s:19:"XLite\Model\Product";s:15:"isCascadeRemove";b:1;s:16:"isCascadePersist";b:1;s:16:"isCascadeRefresh";b:1;s:14:"isCascadeMerge";b:1;s:15:"isCascadeDetach";b:1;}s:12:"productClass";a:19:{s:9:"fieldName";s:12:"productClass";s:11:"joinColumns";a:1:{i:0;a:6:{s:4:"name";s:16:"product_class_id";s:20:"referencedColumnName";s:2:"id";s:6:"unique";b:0;s:8:"nullable";b:1;s:8:"onDelete";s:8:"SET NULL";s:16:"columnDefinition";N;}}s:7:"cascade";a:0:{}s:10:"inversedBy";N;s:12:"targetEntity";s:24:"XLite\Model\ProductClass";s:5:"fetch";i:2;s:4:"type";i:2;s:8:"mappedBy";N;s:12:"isOwningSide";b:1;s:12:"sourceEntity";s:19:"XLite\Model\Product";s:15:"isCascadeRemove";b:0;s:16:"isCascadePersist";b:0;s:16:"isCascadeRefresh";b:0;s:14:"isCascadeMerge";b:0;s:15:"isCascadeDetach";b:0;s:24:"sourceToTargetKeyColumns";a:1:{s:16:"product_class_id";s:2:"id";}s:20:"joinColumnFieldNames";a:1:{s:16:"product_class_id";s:16:"product_class_id";}s:24:"targetToSourceKeyColumns";a:1:{s:2:"id";s:16:"product_class_id";}s:13:"orphanRemoval";b:0;}s:8:"taxClass";a:19:{s:9:"fieldName";s:8:"taxClass";s:11:"joinColumns";a:1:{i:0;a:6:{s:4:"name";s:12:"tax_class_id";s:20:"referencedColumnName";s:2:"id";s:6:"unique";b:0;s:8:"nullable";b:1;s:8:"onDelete";s:8:"SET NULL";s:16:"columnDefinition";N;}}s:7:"cascade";a:0:{}s:10:"inversedBy";N;s:12:"targetEntity";s:20:"XLite\Model\TaxClass";s:5:"fetch";i:2;s:4:"type";i:2;s:8:"mappedBy";N;s:12:"isOwningSide";b:1;s:12:"sourceEntity";s:19:"XLite\Model\Product";s:15:"isCascadeRemove";b:0;s:16:"isCascadePersist";b:0;s:16:"isCascadeRefresh";b:0;s:14:"isCascadeMerge";b:0;s:15:"isCascadeDetach";b:0;s:24:"sourceToTargetKeyColumns";a:1:{s:12:"tax_class_id";s:2:"id";}s:20:"joinColumnFieldNames";a:1:{s:12:"tax_class_id";s:12:"tax_class_id";}s:24:"targetToSourceKeyColumns";a:1:{s:2:"id";s:12:"tax_class_id";}s:13:"orphanRemoval";b:0;}s:10:"attributes";a:16:{s:9:"fieldName";s:10:"attributes";s:8:"mappedBy";s:7:"product";s:12:"targetEntity";s:21:"XLite\Model\Attribute";s:7:"cascade";a:5:{i:0;s:6:"remove";i:1;s:7:"persist";i:2;s:7:"refresh";i:3;s:5:"merge";i:4;s:6:"detach";}s:13:"orphanRemoval";b:0;s:5:"fetch";i:2;s:7:"orderBy";a:1:{s:8:"position";s:3:"ASC";}s:4:"type";i:4;s:10:"inversedBy";N;s:12:"isOwningSide";b:0;s:12:"sourceEntity";s:19:"XLite\Model\Product";s:15:"isCascadeRemove";b:1;s:16:"isCascadePersist";b:1;s:16:"isCascadeRefresh";b:1;s:14:"isCascadeMerge";b:1;s:15:"isCascadeDetach";b:1;}s:15:"attributeValueC";a:15:{s:9:"fieldName";s:15:"attributeValueC";s:8:"mappedBy";s:7:"product";s:12:"targetEntity";s:49:"XLite\Model\AttributeValue\AttributeValueCheckbox";s:7:"cascade";a:5:{i:0;s:6:"remove";i:1;s:7:"persist";i:2;s:7:"refresh";i:3;s:5:"merge";i:4;s:6:"detach";}s:13:"orphanRemoval";b:0;s:5:"fetch";i:2;s:4:"type";i:4;s:10:"inversedBy";N;s:12:"isOwningSide";b:0;s:12:"sourceEntity";s:19:"XLite\Model\Product";s:15:"isCascadeRemove";b:1;s:16:"isCascadePersist";b:1;s:16:"isCascadeRefresh";b:1;s:14:"isCascadeMerge";b:1;s:15:"isCascadeDetach";b:1;}s:15:"attributeValueT";a:15:{s:9:"fieldName";s:15:"attributeValueT";s:8:"mappedBy";s:7:"product";s:12:"targetEntity";s:45:"XLite\Model\AttributeValue\AttributeValueText";s:7:"cascade";a:5:{i:0;s:6:"remove";i:1;s:7:"persist";i:2;s:7:"refresh";i:3;s:5:"merge";i:4;s:6:"detach";}s:13:"orphanRemoval";b:0;s:5:"fetch";i:2;s:4:"type";i:4;s:10:"inversedBy";N;s:12:"isOwningSide";b:0;s:12:"sourceEntity";s:19:"XLite\Model\Product";s:15:"isCascadeRemove";b:1;s:16:"isCascadePersist";b:1;s:16:"isCascadeRefresh";b:1;s:14:"isCascadeMerge";b:1;s:15:"isCascadeDetach";b:1;}s:15:"attributeValueS";a:15:{s:9:"fieldName";s:15:"attributeValueS";s:8:"mappedBy";s:7:"product";s:12:"targetEntity";s:47:"XLite\Model\AttributeValue\AttributeValueSelect";s:7:"cascade";a:5:{i:0;s:6:"remove";i:1;s:7:"persist";i:2;s:7:"refresh";i:3;s:5:"merge";i:4;s:6:"detach";}s:13:"orphanRemoval";b:0;s:5:"fetch";i:2;s:4:"type";i:4;s:10:"inversedBy";N;s:12:"isOwningSide";b:0;s:12:"sourceEntity";s:19:"XLite\Model\Product";s:15:"isCascadeRemove";b:1;s:16:"isCascadePersist";b:1;s:16:"isCascadeRefresh";b:1;s:14:"isCascadeMerge";b:1;s:15:"isCascadeDetach";b:1;}s:9:"quickData";a:15:{s:9:"fieldName";s:9:"quickData";s:8:"mappedBy";s:7:"product";s:12:"targetEntity";s:21:"XLite\Model\QuickData";s:7:"cascade";a:5:{i:0;s:6:"remove";i:1;s:7:"persist";i:2;s:7:"refresh";i:3;s:5:"merge";i:4;s:6:"detach";}s:13:"orphanRemoval";b:0;s:5:"fetch";i:2;s:4:"type";i:4;s:10:"inversedBy";N;s:12:"isOwningSide";b:0;s:12:"sourceEntity";s:19:"XLite\Model\Product";s:15:"isCascadeRemove";b:1;s:16:"isCascadePersist";b:1;s:16:"isCascadeRefresh";b:1;s:14:"isCascadeMerge";b:1;s:15:"isCascadeDetach";b:1;}s:11:"memberships";a:19:{s:9:"fieldName";s:11:"memberships";s:9:"joinTable";a:4:{s:4:"name";s:27:"xc_product_membership_links";s:6:"schema";N;s:11:"joinColumns";a:1:{i:0;a:6:{s:4:"name";s:10:"product_id";s:20:"referencedColumnName";s:10:"product_id";s:6:"unique";b:0;s:8:"nullable";b:1;s:8:"onDelete";N;s:16:"columnDefinition";N;}}s:18:"inverseJoinColumns";a:1:{i:0;a:6:{s:4:"name";s:13:"membership_id";s:20:"referencedColumnName";s:13:"membership_id";s:6:"unique";b:0;s:8:"nullable";b:1;s:8:"onDelete";N;s:16:"columnDefinition";N;}}}s:12:"targetEntity";s:22:"XLite\Model\Membership";s:8:"mappedBy";N;s:10:"inversedBy";s:8:"products";s:7:"cascade";a:0:{}s:13:"orphanRemoval";b:0;s:5:"fetch";i:2;s:4:"type";i:8;s:12:"isOwningSide";b:1;s:12:"sourceEntity";s:19:"XLite\Model\Product";s:15:"isCascadeRemove";b:0;s:16:"isCascadePersist";b:0;s:16:"isCascadeRefresh";b:0;s:14:"isCascadeMerge";b:0;s:15:"isCascadeDetach";b:0;s:26:"relationToSourceKeyColumns";a:1:{s:10:"product_id";s:10:"product_id";}s:16:"joinTableColumns";a:2:{i:0;s:10:"product_id";i:1;s:13:"membership_id";}s:26:"relationToTargetKeyColumns";a:1:{s:13:"membership_id";s:13:"membership_id";}}s:12:"translations";a:15:{s:9:"fieldName";s:12:"translations";s:8:"mappedBy";s:5:"owner";s:12:"targetEntity";s:30:"XLite\Model\ProductTranslation";s:7:"cascade";a:5:{i:0;s:6:"remove";i:1;s:7:"persist";i:2;s:7:"refresh";i:3;s:5:"merge";i:4;s:6:"detach";}s:13:"orphanRemoval";b:0;s:5:"fetch";i:2;s:4:"type";i:4;s:10:"inversedBy";N;s:12:"isOwningSide";b:0;s:12:"sourceEntity";s:19:"XLite\Model\Product";s:15:"isCascadeRemove";b:1;s:16:"isCascadePersist";b:1;s:16:"isCascadeRefresh";b:1;s:14:"isCascadeMerge";b:1;s:15:"isCascadeDetach";b:1;}}s:11:"columnNames";a:21:{s:11:"marketPrice";s:11:"marketPrice";s:6:"ogMeta";s:6:"ogMeta";s:11:"useCustomOG";s:11:"useCustomOG";s:10:"product_id";s:10:"product_id";s:5:"price";s:5:"price";s:3:"sku";s:3:"sku";s:7:"enabled";s:7:"enabled";s:6:"weight";s:6:"weight";s:14:"useSeparateBox";s:14:"useSeparateBox";s:8:"boxWidth";s:8:"boxWidth";s:9:"boxLength";s:9:"boxLength";s:9:"boxHeight";s:9:"boxHeight";s:11:"itemsPerBox";s:11:"itemsPerBox";s:13:"free_shipping";s:13:"free_shipping";s:7:"taxable";s:7:"taxable";s:10:"javascript";s:10:"javascript";s:11:"arrivalDate";s:11:"arrivalDate";s:4:"date";s:4:"date";s:10:"updateDate";s:10:"updateDate";s:10:"attrSepTab";s:10:"attrSepTab";s:8:"cleanURL";s:8:"cleanURL";}s:13:"fieldMappings";a:21:{s:11:"marketPrice";a:8:{s:9:"fieldName";s:11:"marketPrice";s:4:"type";s:7:"decimal";s:6:"length";N;s:9:"precision";i:14;s:5:"scale";i:4;s:8:"nullable";b:0;s:6:"unique";b:0;s:10:"columnName";s:11:"marketPrice";}s:6:"ogMeta";a:8:{s:9:"fieldName";s:6:"ogMeta";s:4:"type";s:4:"text";s:6:"length";N;s:9:"precision";i:0;s:5:"scale";i:0;s:8:"nullable";b:0;s:6:"unique";b:0;s:10:"columnName";s:6:"ogMeta";}s:11:"useCustomOG";a:8:{s:9:"fieldName";s:11:"useCustomOG";s:4:"type";s:7:"boolean";s:6:"length";N;s:9:"precision";i:0;s:5:"scale";i:0;s:8:"nullable";b:0;s:6:"unique";b:0;s:10:"columnName";s:11:"useCustomOG";}s:10:"product_id";a:9:{s:9:"fieldName";s:10:"product_id";s:4:"type";s:8:"uinteger";s:6:"length";N;s:9:"precision";i:0;s:5:"scale";i:0;s:8:"nullable";b:0;s:6:"unique";b:0;s:2:"id";b:1;s:10:"columnName";s:10:"product_id";}s:5:"price";a:9:{s:9:"fieldName";s:5:"price";s:4:"type";s:5:"money";s:6:"length";N;s:9:"precision";i:0;s:5:"scale";i:0;s:8:"nullable";b:0;s:6:"unique";b:0;s:7:"options";a:3:{i:0;O:39:"XLite\Core\Doctrine\Annotation\Behavior":2:{s:4:"list";a:1:{i:0;s:7:"taxable";}s:5:"value";N;}i:1;O:38:"XLite\Core\Doctrine\Annotation\Purpose":3:{s:4:"name";s:3:"net";s:6:"source";s:5:"clear";s:5:"value";N;}i:2;O:38:"XLite\Core\Doctrine\Annotation\Purpose":3:{s:4:"name";s:7:"display";s:6:"source";s:3:"net";s:5:"value";N;}}s:10:"columnName";s:5:"price";}s:3:"sku";a:8:{s:9:"fieldName";s:3:"sku";s:4:"type";s:6:"string";s:6:"length";i:32;s:9:"precision";i:0;s:5:"scale";i:0;s:8:"nullable";b:1;s:6:"unique";b:0;s:10:"columnName";s:3:"sku";}s:7:"enabled";a:8:{s:9:"fieldName";s:7:"enabled";s:4:"type";s:7:"boolean";s:6:"length";N;s:9:"precision";i:0;s:5:"scale";i:0;s:8:"nullable";b:0;s:6:"unique";b:0;s:10:"columnName";s:7:"enabled";}s:6:"weight";a:8:{s:9:"fieldName";s:6:"weight";s:4:"type";s:7:"decimal";s:6:"length";N;s:9:"precision";i:14;s:5:"scale";i:4;s:8:"nullable";b:0;s:6:"unique";b:0;s:10:"columnName";s:6:"weight";}s:14:"useSeparateBox";a:8:{s:9:"fieldName";s:14:"useSeparateBox";s:4:"type";s:7:"boolean";s:6:"length";N;s:9:"precision";i:0;s:5:"scale";i:0;s:8:"nullable";b:0;s:6:"unique";b:0;s:10:"columnName";s:14:"useSeparateBox";}s:8:"boxWidth";a:8:{s:9:"fieldName";s:8:"boxWidth";s:4:"type";s:7:"decimal";s:6:"length";N;s:9:"precision";i:14;s:5:"scale";i:4;s:8:"nullable";b:0;s:6:"unique";b:0;s:10:"columnName";s:8:"boxWidth";}s:9:"boxLength";a:8:{s:9:"fieldName";s:9:"boxLength";s:4:"type";s:7:"decimal";s:6:"length";N;s:9:"precision";i:14;s:5:"scale";i:4;s:8:"nullable";b:0;s:6:"unique";b:0;s:10:"columnName";s:9:"boxLength";}s:9:"boxHeight";a:8:{s:9:"fieldName";s:9:"boxHeight";s:4:"type";s:7:"decimal";s:6:"length";N;s:9:"precision";i:14;s:5:"scale";i:4;s:8:"nullable";b:0;s:6:"unique";b:0;s:10:"columnName";s:9:"boxHeight";}s:11:"itemsPerBox";a:8:{s:9:"fieldName";s:11:"itemsPerBox";s:4:"type";s:7:"integer";s:6:"length";N;s:9:"precision";i:0;s:5:"scale";i:0;s:8:"nullable";b:0;s:6:"unique";b:0;s:10:"columnName";s:11:"itemsPerBox";}s:13:"free_shipping";a:8:{s:9:"fieldName";s:13:"free_shipping";s:4:"type";s:7:"boolean";s:6:"length";N;s:9:"precision";i:0;s:5:"scale";i:0;s:8:"nullable";b:0;s:6:"unique";b:0;s:10:"columnName";s:13:"free_shipping";}s:7:"taxable";a:8:{s:9:"fieldName";s:7:"taxable";s:4:"type";s:7:"boolean";s:6:"length";N;s:9:"precision";i:0;s:5:"scale";i:0;s:8:"nullable";b:0;s:6:"unique";b:0;s:10:"columnName";s:7:"taxable";}s:10:"javascript";a:8:{s:9:"fieldName";s:10:"javascript";s:4:"type";s:4:"text";s:6:"length";N;s:9:"precision";i:0;s:5:"scale";i:0;s:8:"nullable";b:0;s:6:"unique";b:0;s:10:"columnName";s:10:"javascript";}s:11:"arrivalDate";a:8:{s:9:"fieldName";s:11:"arrivalDate";s:4:"type";s:7:"integer";s:6:"length";N;s:9:"precision";i:0;s:5:"scale";i:0;s:8:"nullable";b:0;s:6:"unique";b:0;s:10:"columnName";s:11:"arrivalDate";}s:4:"date";a:8:{s:9:"fieldName";s:4:"date";s:4:"type";s:7:"integer";s:6:"length";N;s:9:"precision";i:0;s:5:"scale";i:0;s:8:"nullable";b:0;s:6:"unique";b:0;s:10:"columnName";s:4:"date";}s:10:"updateDate";a:8:{s:9:"fieldName";s:10:"updateDate";s:4:"type";s:8:"uinteger";s:6:"length";N;s:9:"precision";i:0;s:5:"scale";i:0;s:8:"nullable";b:0;s:6:"unique";b:0;s:10:"columnName";s:10:"updateDate";}s:10:"attrSepTab";a:8:{s:9:"fieldName";s:10:"attrSepTab";s:4:"type";s:7:"boolean";s:6:"length";N;s:9:"precision";i:0;s:5:"scale";i:0;s:8:"nullable";b:0;s:6:"unique";b:0;s:10:"columnName";s:10:"attrSepTab";}s:8:"cleanURL";a:8:{s:9:"fieldName";s:8:"cleanURL";s:4:"type";s:6:"string";s:6:"length";i:255;s:9:"precision";i:0;s:5:"scale";i:0;s:8:"nullable";b:1;s:6:"unique";b:1;s:10:"columnName";s:8:"cleanURL";}}s:10:"fieldNames";a:21:{s:11:"marketPrice";s:11:"marketPrice";s:6:"ogMeta";s:6:"ogMeta";s:11:"useCustomOG";s:11:"useCustomOG";s:10:"product_id";s:10:"product_id";s:5:"price";s:5:"price";s:3:"sku";s:3:"sku";s:7:"enabled";s:7:"enabled";s:6:"weight";s:6:"weight";s:14:"useSeparateBox";s:14:"useSeparateBox";s:8:"boxWidth";s:8:"boxWidth";s:9:"boxLength";s:9:"boxLength";s:9:"boxHeight";s:9:"boxHeight";s:11:"itemsPerBox";s:11:"itemsPerBox";s:13:"free_shipping";s:13:"free_shipping";s:7:"taxable";s:7:"taxable";s:10:"javascript";s:10:"javascript";s:11:"arrivalDate";s:11:"arrivalDate";s:4:"date";s:4:"date";s:10:"updateDate";s:10:"updateDate";s:10:"attrSepTab";s:10:"attrSepTab";s:8:"cleanURL";s:8:"cleanURL";}s:10:"identifier";a:1:{i:0;s:10:"product_id";}s:21:"isIdentifierComposite";b:0;s:4:"name";s:19:"XLite\Model\Product";s:9:"namespace";s:11:"XLite\Model";s:5:"table";a:3:{s:4:"name";s:11:"xc_products";s:7:"indexes";a:4:{s:5:"price";a:1:{s:7:"columns";a:1:{i:0;s:5:"price";}}s:6:"weight";a:1:{s:7:"columns";a:1:{i:0;s:6:"weight";}}s:13:"free_shipping";a:1:{s:7:"columns";a:1:{i:0;s:13:"free_shipping";}}s:12:"customerArea";a:1:{s:7:"columns";a:2:{i:0;s:7:"enabled";i:1;s:11:"arrivalDate";}}}s:17:"uniqueConstraints";a:1:{s:3:"sku";a:1:{s:7:"columns";a:1:{i:0;s:3:"sku";}}}}s:14:"rootEntityName";s:19:"XLite\Model\Product";s:11:"idGenerator";O:33:"Doctrine\ORM\Id\IdentityGenerator":1:{s:43:" Doctrine\ORM\Id\IdentityGenerator _seqName";N;}s:25:"customRepositoryClassName";s:25:"\XLite\Model\Repo\Product";s:13:"generatorType";i:4;s:18:"lifecycleCallbacks";a:3:{s:10:"prePersist";a:3:{i:0;s:17:"prepareBeforeSave";i:1;s:19:"prepareBeforeCreate";i:2;s:13:"clearSitemaps";}s:9:"preUpdate";a:3:{i:0;s:17:"prepareBeforeSave";i:1;s:19:"prepareBeforeUpdate";i:2;s:13:"clearSitemaps";}s:9:"preRemove";a:2:{i:0;s:19:"prepareBeforeRemove";i:1;s:13:"clearSitemaps";}}}