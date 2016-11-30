SELECT DISTINCT po.option_id,
                po.option_value_id,
                od.NAME  optionName,
                ovd.NAME valueName
FROM   product_option_value po
       INNER JOIN option_description od
               ON po.option_id = od.option_id
                  AND od.language_id = 1
       INNER JOIN option_value_description ovd
               ON ovd.option_value_id = po.option_value_id
		  AND ovd.language_id=1
WHERE  po.product_id = 121 