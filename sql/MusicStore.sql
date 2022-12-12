
drop database MusicStore;
create database if not exists MusicStore;
use MusicStore;

#---------------------------------------------------------------------------

#descr - description или описание
#property - свойства товара
#inv - invoice или счёт, накладная
#quantity - кол-во заказанного/проданного товара
#amount - кол-во оставшегося на складе товара
#fact - manufacture или производство

#---------------------------------------------------------------------------
create table item_class (
	class_id int AUTO_INCREMENT PRIMARY KEY,
    class_descr text NOT NULL
);

create table items (
	item_id int AUTO_INCREMENT PRIMARY KEY,
    class_id int (10) NOT NULL,
    vender_number int NOT NULL,  #по хорошему, это должен быть уникальный номер, но в рамках тестовового
    item_brand text NOT NULL,    #задания артикль инструмента будет отличаться от id на 100
    item_name text NOT NULL,
    fact_date DATE NOT NULL,
    fact_country text NOT NULL,
	item_amount int NOT NULL,
    item_price int NOT NULL, # цена товара будет исчисляться в долларах $$$
    FOREIGN KEY (class_id) REFERENCES item_class (class_id)
);

create table property_catalog (
	property_id int AUTO_INCREMENT PRIMARY KEY,
    property_descr text NOT NULL
);

create table class_properties (
	class_id int NOT NULL,
	property_id int NOT NULL,
    FOREIGN KEY (class_id) REFERENCES item_class (class_id),
    FOREIGN KEY (property_id) REFERENCES property_catalog (property_id)
);

create table item_property (
	item_id int NOT NULL,
    property_id int NOT NULL,
    property_value text NOT NULL,
    FOREIGN KEY (item_id) REFERENCES items (item_id),
    FOREIGN KEY (property_id) REFERENCES property_catalog (property_id)
);

#---------------------------------------------------------------------------

create table clients (
	client_id int AUTO_INCREMENT PRIMARY KEY,
    client_address text NOT NULL,
    client_email text NOT NULL,
    client_phone varchar (30) NOT NULL,
    client_surname text NOT NULL
);

create table order_main (
	order_id int AUTO_INCREMENT PRIMARY KEY,
    client_id int NOT NULL,
    order_price int,
    order_date DATE NOT NULL,
    order_date_release DATE NULL,
    FOREIGN KEY (client_id) REFERENCES clients (client_id)
);

create table order_list (
	order_id int NOT NULL,
    item_id_ord int NOT NULL,
    quantity int,
    price int,
    FOREIGN KEY (item_id_ord) REFERENCES items (item_id),
	FOREIGN KEY (order_id) REFERENCES order_main (order_id)
);

#---------------------------------------------------------------------------

create table employee (
	employee_id int AUTO_INCREMENT PRIMARY KEY,
    emp_surname varchar(30) NOT NULL,
    emp_name varchar(30) NOT NULL,
    emp_patronymic varchar(30) NOT NULL
);

create table department (
	department_id int AUTO_INCREMENT PRIMARY KEY,
    dep_name varchar(30) NOT NULL,
    dep_address text NOT NULL
);

create table manager (
	employee_id int NOT NULL,
    department_id int NOT NULL,
    
    FOREIGN KEY (employee_id) REFERENCES employee (employee_id),
    FOREIGN KEY (department_id) REFERENCES department (department_id)
);

#---------------------------------------------------------------------------

create table invoice (
	invoice_id int AUTO_INCREMENT PRIMARY KEY,
    inv_number int NOT NULL,
    order_id int NOT NULL,
    inv_total int NOT NULL,
    inv_date DATE NOT NULL,
    employee_id int NOT NULL,
	FOREIGN KEY (employee_id) REFERENCES employee (employee_id),
    FOREIGN KEY (order_id) REFERENCES order_main (order_id)
);

create table payment (
	payment_id int AUTO_INCREMENT PRIMARY KEY,
    pay_number int NOT NULL,
    pay_date DATE NOT NULL,
    pay_sum int NOT NULL,
    pay_type text NOT NULL
);

create table invoice_payment (
	invoice_id int NOT NULL,
    payment_id int NOT NULL,
    price int NOT NULL,
    FOREIGN KEY (invoice_id) REFERENCES invoice (invoice_id),
    FOREIGN KEY (payment_id) REFERENCES payment (payment_id)
);

create table price_list (
    item_id int NOT NULL,
    invoice_id int NOT NULL,
	quantity int NOT NULL,
    sum int NOT NULL,
	FOREIGN KEY (item_id) REFERENCES items (item_id),
    FOREIGN KEY (invoice_id) REFERENCES invoice (invoice_id)
);
