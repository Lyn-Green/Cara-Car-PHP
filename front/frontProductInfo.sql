select p_i.img_id, p_i.img_name 
    from product p join pro_img p_i on p.pro_id = p_i.pro_id
    where p_i.pro_id = {$pageId};
    
select *
	from pro_img;
    
select *
	from product;
    
select *
	from product p
    join (select MIN(img_id) AS min_img_id, pro_id, img_name from pro_img group by pro_id) AS sub on p.pro_id = sub.pro_id;

