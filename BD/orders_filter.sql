SELECT v.order_id,
       v.customer,
       v.status_id,
       v.STATUS,
       v.date_added,
       v.date_modified,
       v.totalproducts,
       v.productstodelete,
       ( v.totalproducts - v.productstodelete ) AS pendingProducts
FROM   (SELECT o.order_id,
               CONCAT(o.firstname, ' ', o.lastname) AS customer,
               o.order_status_id                    AS status_id,
               (SELECT os.NAME
                FROM   order_status os
                WHERE  os.order_status_id = o.order_status_id
                       AND os.language_id = '1')    AS STATUS,
               o.date_added,
               o.date_modified,
               (SELECT COUNT(*) orderProducts
                FROM   order_product
                WHERE  order_id = o.order_id)       AS totalproducts,
               (SELECT COUNT(DISTINCT op.order_product_id) AS productsToDelete
                FROM   `order` od
                       INNER JOIN order_product op
                               ON op.order_id = od.order_id
                WHERE  od.order_id = o.order_id
                       AND DATE(od.date_added) >= DATE('2016-11-01')
                       AND DATE(od.date_added) <= DATE('2016-11-29')
                       AND op.product_id = '121')   AS productsToDelete
        FROM   `order` o
        WHERE  o.order_status_id > '0') v
WHERE  v.productstodelete > 0
ORDER  BY v.order_id ASC
LIMIT  0, 20 