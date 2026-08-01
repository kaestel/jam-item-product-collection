INSERT INTO `SITE_DB`.`navigation_nodes` (node_name, node_link, navigation_id)
SELECT 'Products', '/janitor/product/list', (SELECT id FROM `SITE_DB`.`navigation` WHERE handle = 'main-janitor')
WHERE NOT EXISTS (
	SELECT id FROM `SITE_DB`.`navigation_nodes` WHERE node_link = '/janitor/product/list'
);