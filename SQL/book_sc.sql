create database book_sc character set utf8;

use book_sc;

create table customers
(
  customerid int unsigned not null auto_increment primary key,
  name char(60) not null,
  phonenum char(11),
  address char(80) not null,
  username varchar(16) not null,
  passwd char(40) not null,
  email varchar(100) not null
) DEFAULT CHARSET=utf8;
/*这里我们声明所有的列都是NOT NULL,这是一个小小的优化*/

create table orders
(
  orderid int unsigned not null auto_increment primary key,
  customerid int unsigned not null references customers(customerid),
  ship_phonenum char(11),
  ship_email varchar(100) not null,
  index (customerid),
  amount float(6,2),
  date date not null,
  order_status char(10) not null,
  ship_name char(60) not null,
  ship_address char(80) not null
) DEFAULT CHARSET=utf8;
/*由于创建订单之前我们可能无法知道订单的总金额，所以允许amount列为NULL 对常用的列建立索引   明确各个数据表之间的外键*/

create table books
(
   index(author),
   index(title),
   index(isbn),
   index(description),
   isbn char(13) not null primary key,
   author char(80),
   title char(100),
   catid int unsigned,
   price double not null,
   url char(255) not null,
   description varchar(255),
   site char(255),
   image_url char(255),
   num int unsigned not null,
) DEFAULT CHARSET=utf8;
/*isbn可以作为一本图书的唯一标识，作为主键*/

create table categories
(
  catid int unsigned not null auto_increment primary key,
  catname char(60) not null
) DEFAULT CHARSET=utf8;

create table order_items
(
  orderid int unsigned not null references orders(orderid),
  isbn char(13) not null references books(isbn),
  item_price float(4,2) not null,
  quantity tinyint unsigned not null,
  primary key (orderid, isbn)
) DEFAULT CHARSET=utf8;
/*多列主键*/

create table admin
(
  username char(16) not null primary key,
  password char(40) not null
) DEFAULT CHARSET=utf8;

create table bestseller (
  index(isbn),
  isbn char(13) not null references books(isbn),
  quantity int unsigned not null
) DEFAULT CHARSET=utf8;

create table book_reviews (
  rid int unsigned not null auto_increment primary key,
  isbn char(13) not null,
  posted datetime not null,
  review text,
  customerid int unsigned not null references customers(customerid)
) DEFAULT CHARSET=utf8;
