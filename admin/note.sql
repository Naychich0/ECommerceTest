CREATE TABLE admin(
id integer PRIMARY KEY AUTO_INCREMENT,
   email varchar(100) UNIQUE,
   password varchar(60)
);


CREATE TABLE category(
    id integer PRIMARY KEY AUTO_INCREMENT,
    cat_name varchar(100) UNIQUE,
    description varchar(100)
);

CREATE TABLE products(
    id integer PRIMARY KEY AUTO_INCREMENT,
    product_name varchar(100),
    cost float,
    price float,
    description varchar(200),
    img_path varchar(255),
    category integer
);

/*adding the category col in the products table form category table*/
ALTER TABLE products
ADD FOREIGN KEY (category)
REFERENCES category(id);


SELECT p.id, p.product_name, p.cost,p.price, p.description,p.img_path, c.cat_name as category, p.id catid, p.quantity 
FROM products p, category c 
WHERE p.category = c.id;