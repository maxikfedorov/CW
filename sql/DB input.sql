use musicstore;

DELETE FROM order_list;
DELETE FROM order_main;
DELETE FROM class_properties;
DELETE FROM items;
DELETE FROM item_class;
DELETE FROM clients;
DELETE FROM property_catalog;
DELETE FROM manager;
DELETE FROM department;
DELETE FROM employee;



# item_class - заполняем типы инструментов (id типа и его описание)--------

INSERT INTO item_class
	VALUES 
		("1", "Guitar"),
		("2", "Bass"),
		("3", "String"),
		("4", "Headphones"),
		("5", "Pickups"),
        ("6", "Drums"),
        ("7", "Keyboards/MIDI");
#SELECT * FROM item_class;
#------------------------------------------------------------------------------

# item - заполняем информацию об инструменте (id и т.д.)--------
ALTER TABLE items AUTO_INCREMENT=1;
INSERT INTO items (class_id, vender_number, item_name, item_brand, fact_date, fact_country, item_amount, item_price)
	VALUES 
        ('1', item_id, "Ibanez RGIM7", "Ibanez", "2017-01-01", "Indonesia", "55", "1500"),
        ('1', item_id, "Inspector TT", "Inspector", "2022-09-15", "Russia", "1", "2000"),
        ('1', item_id, "Aristides T/0", "Aristides", "2000-10-10", "Canada", "5", "2600"),
        ('1', item_id, "ESP TE Bariton", "ESP LTD", "2012-12-09", "Japan", "5", "2600"),
        ('1', item_id, "Ibanez RGD", "Ibanez", "2019-06-06", "Indonesia", "23", "1800"),
        
        ('2', item_id, "Dingwall NG-3", "Dingwall", "2015-08-15", "Canada", "4", "2800"),        
        ('2', item_id, "Dingwall Combustion", "Dingwall", "2018-12-25", "Canada", "10", "4000"),         
        ('2', item_id, "Dingwall NG-2", "Dingwall", "2013-08-04", "Canada", "5", "2200"), 
        
		('3', item_id, "Dingwall strings 45-130", "Dingwall", "2010-07-03", "Canada", "400", "40"),

		('4', item_id, "AKG K271", "AKG", "2018-10-27", "Austria", "27", "1800"),
        
        ('5', item_id, "Fokin Machete", "Fokin", "2019-04-03", "Russia", "4", "100"),
        
        ('6', item_id, "TAMA WBR42S", "TAMA", "2015-07-28", "Japan", "10", "4000"),
        
        ('7', item_id, "Komplete Kontrol M32", "Native Instruments", "2020-05-06", "Indonesia", "3", "200");
        
SELECT * FROM items;
#------------------------------------------------------------------------------

# property_catalog - заполняем информацию об свойствах товара (id и т.д.)--------
ALTER TABLE property_catalog AUTO_INCREMENT=1;
INSERT INTO property_catalog (property_descr)
	VALUES 
    #гитары и басы (id = 1, 2)
		("Body type"), #тип корпуса
        ("Scale"), #мензура
        ("Body material"), #материал топа
        ("Pickups Config."), #конфигурация звукоснимателей (HH, SSS и т.д.)
        ("Number of frets"), #кол-во ладов
        ("Bridge"), #бридж
        ("Number of strings"), #кол-во струн
	#струны
        ("Purpose"), #назначение, т.е. для какого вида гитар предназначено (акустика, электро, бас и т.д.)
        ("Caliber"), #калибр или толщина струн, указывается в тысячных долях дюймов
        ("Included"), #сколько струн в комлпекте
        ("Material"), #материал струны
    #наушники    
        ("Type"), #открытые, закрытые или полуоткрытые
        ("Speaker"), #диаметр динамика, в миллиметрах
        ("SPL"), #звуковое давление, в децибелах
        ("Impedance"), #сопротивление, в Омах
        ("Power"), #мощность, в мВ
	#звукосниматели
		#("Type"), #хамбакер, сингл, рельса
        #("Purpose"), #назначение, т.е. для какого вида гитар предназначено (акустика, электро, бас и т.д.)
        ("Position"), #бридж, нек
        #("Number of strings"), #кол-во струн
        ("Electronics"), #активный, пассивный
	#барабаны и их размеры
		("Kick"), #бочка
        ("Snare"), #малый
        ("Toms high"), #том выс.
        ("Toms mid"), #том сред.
        ("Toms low"), #том низ.
        ("Hi-Hat"), #привет-шляпа
        ("Crash"), #авария
        ("Ride"), #дорога
	
    #клавиши, пианино
		("Number of keys"), #кол-во клавиш
        ("Regulators"), #уло-во регуляторов, крутилочек, патенцометров
        ("Pads"), #кол-во пэдов
        
    #универсальные    
        ("Color"), #цвет
        ("Weight");#вес
        
#SELECT * FROM property_catalog;
#------------------------------------------------------------------------------

# class_properties - связываем id типа и id свойства --------------------------------
INSERT INTO class_properties
	VALUES 
    #для гитар и басов
		("1", "1"),
        ("1", "2"),
        ("1", "3"),
        ("1", "4"),
        ("1", "5"),
        ("1", "6"),
		("1", "7"),
        ("1", "30"),
        ("1", "31"),
        
        ("2", "1"),
        ("2", "2"),
        ("2", "3"),
        ("2", "4"),
        ("2", "5"),
        ("2", "6"),
		("2", "7"),
        ("2", "30"),
        ("2", "31"),
    #для струн
		("3", "8"),
        ("3", "9"),
        ("3", "10"),
        ("3", "11"),
	#для наушников
        ("4", "12"),
		("4", "13"),
        ("4", "14"), 
        ("4", "15"), 
        ("4", "16"),
        ("4", "30"), 
        ("4", "31"),
	#для звукоснимателей
        ("5", "12"),
		("5", "8"),
        ("5", "17"), 
        ("5", "7"), 
        ("5", "18"),
    #для барабанов
        ("6", "19"),
		("6", "20"),
        ("6", "21"), 
        ("6", "22"), 
        ("6", "23"),
        ("6", "25"), 
        ("6", "26"),
        ("6", "30"), 
        ("6", "31"),
	#для клавиш
        ("7", "27"),
		("7", "28"),
        ("7", "29"), 
        ("7", "30"), 
        ("7", "31");

#SELECT * FROM class_properties;
#------------------------------------------------------------------------------

# employee - заполняем информацию об работниках (id и т.д.)--------
ALTER TABLE employee AUTO_INCREMENT=1;
INSERT INTO employee (emp_surname, emp_name, emp_patronymic)
	VALUES 
		("Fedorov", "Maxim", "Alexandrovich"),
		("Hodos", "Maxim", "Dmitrievich"),
		("Somov", "Nikita", "Ilyich");

#SELECT * FROM employee;
#------------------------------------------------------------------------------

# department - заполняем информацию об работниках (id и т.д.)--------
ALTER TABLE department AUTO_INCREMENT=1;
INSERT INTO department (dep_name, dep_address)
	VALUES 
		("MusicStore №1", "Russia, Moscow, m. Taganskaya, b. 3"),
		("MusicStore №2", "Russia, Moscow, m. Vyatskaya, b. 1"),
		("MusicStore №3", "Russia, Moscow, m. Kuznetzkiy Most, b. 6/2");

#SELECT * FROM department;
#------------------------------------------------------------------------------

# manager - заполняем информацию об менеджере --------
INSERT INTO manager
	VALUES 
		("1", "3"),
		("3", "2");

#SELECT * FROM manager;
#------------------------------------------------------------------------------

# clients - заполняем информацию об клиенте (id и т.д.)--------
ALTER TABLE clients AUTO_INCREMENT=1;
INSERT INTO clients (client_address, client_phone, client_surname)
	VALUES 
		("Russia, Moscow", "+7(927)111-11-11", "Smirnov"),
        ("Russia, Moscow", "+7(927)222-11-11", "Holodov"),
        ("Russia, Moscow", "+7(927)333-11-11", "Smetanov"),
        ("Russia, Moscow", "+7(927)444-11-11", "Glebov"),
        ("Russia, Moscow", "+7(927)555-11-11", "Chernyaev"),
        ("Russia, Moscow", "+7(927)666-11-11", "Fedorov"),
        ("Russia, Moscow", "+7(927)777-11-11", "Tarasov"),
        ("Russia, Moscow", "+7(927)888-11-11", "Zazonov"),
        
		("Germany, Berlin", "+49 09404168620", "Christoph"),
		("USA, New-York", "+828-980-7616", "Mike");

SELECT * FROM clients;
#------------------------------------------------------------------------------

# order_main - заполняем информацию о заказе (id и т.д.)--------
ALTER TABLE order_main AUTO_INCREMENT=1;
INSERT INTO order_main (client_id, order_date)
	VALUES 
		("1", "2019-01-01"),
        ("2", "2018-06-29"),
        ("3", "2020-03-20"),
        ("4", "2018-11-12"),
        ("5", "2011-02-23"),
        ("6", "2017-09-13"),
        ("7", "2018-10-10"),
        ("8", "2014-10-12"),
        ("9", "2016-11-12"),
        ("10", "2018-11-12"),
        
        ("1", "2022-02-13"),
        ("1", "2013-12-15"),
                
        ("2", "2012-12-14"),
        ("2", "2018-12-21"),
                
        ("3", "2021-06-10"),
        ("3", "2022-04-14"),
                
        ("4", "2018-11-30"),
        ("4", "2019-02-07"),
                
        ("5", "2019-04-17"),
        ("5", "2022-04-01"),
                
        ("6", "2018-08-17"),
        ("6", "2020-03-09"),
                
        ("7", "2015-07-29"),
        ("7", "2016-02-08"),
                
        ("8", "2017-04-15"),
        ("8", "2019-12-31"),
                
        ("9", "2019-03-24"),
        ("9", "2020-08-27");
        
        
UPDATE order_main SET order_date_release = DATE_ADD(order_date, INTERVAL 14 DAY);
#ордер релиз - это ориентировочная дата заказа, точная дата релиза
#будет отображаться на чеке (invoice)
SELECT * FROM order_main;
#------------------------------------------------------------------------------

# order_list - заполняем информацию о товарах в заказе (id и т.д.)--------
INSERT INTO order_list (order_id, item_id_ord, quantity)
	VALUES 
		("1", "1", "1"),
        ("1", "9", "2"),
        ("1", "11", "1"),
        ("1", "8", "1"),
        
        ("2", "5", "1"),
        ("2", "10", "1"),
        
        ("3", "6", "1"),
        
        ("4", "1", "1"),
		("4", "2", "1"),
        ("4", "7", "1"),
        ("4", "4", "12"),
        ("4", "12", "4"),
        
        ("5", "9", "2"),
        ("5", "13", "4"),
        
        ("6", "8", "1"),
        
        ("7", "6", "1"),
        
        ("8", "7", "1"),
        
        ("9", "6", "1"),
        
        ("10", "8", "1");
        
UPDATE order_list
	SET price = (SELECT item_price FROM items WHERE item_id = item_id_ord);
	
SELECT * FROM order_list;

#запрос на фамилии клиентов, релиз заказов которых включает бас-гитары
#фирмы Dingwall и состоялся в 2018-2019 года
#нужные нам бас-гитары имеют id 6,7,8.
#они содержаться в заказах с id 1-10 кроме 2 и 5
#условиям даты соответствуют 1,4,7,10, владельцами которых соответственно являются
#1 - smirnov, 4 - glebov, 7 - tarasov, 10 - mike.


/*SELECT client_surname FROM client 
	WHERE client_id IN (SELECT client_id FROM order_main
		WHERE (order_id IN (SELECT order_id FROM order_list 
			WHERE (item_id_ord IN (SELECT item_id FROM items 
				WHERE item_brand = "Dingwall" AND class_id = 2))))
					AND (order_date_release >= "2018-01-01")
						AND (order_date_release <= "2019-12-31"));*/
 
SELECT client_surname 
FROM clients, order_main, order_list, items
WHERE clients.client_id = order_main.client_id 
	AND (order_main.order_date_release >= "2018-01-01" AND order_date_release <= "2019-12-31") 
    AND order_main.order_id = order_list.order_id 
    AND order_list.item_id_ord = items.item_id 
    AND ( items.class_id = 2 AND items.item_brand = "Dingwall"); 
     
#------------------------------------------------------------------------------




