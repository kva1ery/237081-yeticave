create database yeticave
  default character set utf8
  default collate utf8_general_ci;

use yeticave;

create table categories (
  id   int auto_increment primary key,
  name varchar(30) not null
);

create table lots (
  id          int auto_increment primary key,
  create_date timestamp not null default current_timestamp,
  name        varchar(200) not null,
  catigory    int not null,
  description text not null,
  image       varchar(50) not null,
  start_price decimal not null,
  finish_date timestamp not null,
  price_step  int default 1,
  author      int not null
);

create table bets (
  id          int auto_increment primary key,
  lot         int not null,
  user        int not null,
  create_date timestamp not null default current_timestamp,
  price       decimal not null,
  win         bit default 0
);

create table users (
  id          int auto_increment primary key,
  register_date timestamp not null default current_timestamp,
  email       varchar(130) not null,
  name        varchar(100) not null,
  password    varchar(30) not null,
  avatar      varchar(50),
  contacts    varchar(256) not null
);


-- drop database yeticave;