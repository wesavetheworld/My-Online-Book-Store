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

create table orders
(
  orderid int unsigned not null auto_increment primary key,
  customerid int unsigned not null,
  phonenum char(11),
  index (customerid),
  amount float(6,2),
  date date not null,
  order_status char(10),
  ship_name char(60) not null,
  ship_address char(80) not null
) DEFAULT CHARSET=utf8;

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
   price float(4,2) not null,
   description varchar(255)
) DEFAULT CHARSET=utf8;

create table categories
(
  catid int unsigned not null auto_increment primary key,
  catname char(60) not null
) DEFAULT CHARSET=utf8;

create table order_items
(
  orderid int unsigned not null,
  isbn char(13) not null,
  item_price float(4,2) not null,
  quantity tinyint unsigned not null,
  primary key (orderid, isbn)
) DEFAULT CHARSET=utf8;

create table admin
(
  username char(16) not null primary key,
  password char(40) not null
) DEFAULT CHARSET=utf8;
