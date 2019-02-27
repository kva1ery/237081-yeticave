create database yeticave
  default character set utf8
  default collate utf8_general_ci;

use yeticave;

create table categories (
  id   int auto_increment primary key,
  name varchar(30) not null,
  class varchar(30)
);

create table users (
  id            int auto_increment primary key,
  register_date timestamp not null default current_timestamp,
  email         varchar(130) not null,
  name          varchar(100) not null,
  password      varchar(30) not null,
  avatar        varchar(50),
  contacts      varchar(256) not null
);

create unique index ind_users_email on users(email);

create table lots (
  id          int auto_increment primary key,
  create_date timestamp not null default current_timestamp,
  name        varchar(200) not null,
  category    int not null,
  description text not null,
  image       varchar(50) not null,
  start_price decimal not null,
  finish_date datetime not null,
  price_step  int default 1,
  author      int not null
);

create index ind_lots_author on lots(author);
create index ind_lots_category on lots(category);
create index ind_lots_finish on lots(finish_date);
create fulltext index ind_lots_fulltext on lots(name, description);

alter table lots
 add foreign key (category) references categories(id);
alter table lots
  add foreign key (author) references users(id);

create table bets (
  id          int auto_increment primary key,
  lot         int not null,
  user        int not null,
  create_date timestamp not null default current_timestamp,
  price       decimal not null,
  win         bit default 0
);

create index ind_bets_lot on bets(lot);
create index ind_bets_user on bets(user);

alter table bets
  add foreign key (lot) references lots(id);
alter table bets
  add foreign key (user) references users(id);

-- drop database yeticave;