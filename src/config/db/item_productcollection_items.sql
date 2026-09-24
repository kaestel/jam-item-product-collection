CREATE TABLE`SITE_DB`.`item_productcollection_items` (
  `id` int(11) NOT NULL auto_increment,
  `item_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,

  `position` int(11) DEFAULT '0',

  PRIMARY KEY  (`id`),
  KEY `item_id` (`item_id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `item_productcollection_items_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `SITE_DB`.`items` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `item_productcollection_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `SITE_DB`.`items` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;
