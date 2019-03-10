use yeticave;

-- Заполнение списка категорий --
insert into categories (name, class)
  values ('Доски и лыжи', 'promo__item--boards'),
         ('Крепления', 'promo__item--attachment'),
         ('Ботинки', 'promo__item--boots'),
         ('Одежда', 'promo__item--clothing'),
         ('Инструменты', 'promo__item--tools'),
         ('Разное', 'promo__item--other');

-- Заполнение пользователей --
insert into users (email, name, password, contacts)
  values ('ivan@mail.ru', 'Иван', '123', '8 800 2000-600'),
         ('petr@mail.ru', 'Петр', '321', '8 800 555-86-28');

-- Заполнение лотов --
insert into lots (name, category, image, start_price, finish_date, price_step, author, description)
  values ('2014 Rossignol District Snowboard', 1, 'lot-1.jpg', 10999, '2019-03-10', 100, 1,
          'Многоцелевые доски Rossignol категории Фристайл очень прочные для амплитудных приземлений и имеют более широкую стойку с новейшей джиббинговой технологией и изогнутыми кантами Magne-Traction.'),
         ('DC Ply Mens 2016/2017 Snowboard', 1, 'lot-2.jpg', 159999, '2019-03-10', 1000, 2,
          'И снова в сезоне 16/17 нас радует одна из лучших универсальный фановых досок для фристайла - DC Ply. Настоящий зимний скейтборд на ваших ногах. Не обремененная весом, отлично спроектированная конструкция, которая проверена годами.'),
         ('Крепления Union Contact Pro 2015 года размер L/XL', 2, 'lot-3.jpg', 8000, '2019-03-10', 100, 1,
          'Эти крепления ежегодно проверяет на прочность один из самых титулованных бэккантри-райдеров - австриец Gigi Rüf.'),
         ('Ботинки для сноуборда DC Mutiny Charocal', 3, 'lot-4.jpg', 10999, '2019-03-10', 100, 2,
          'Прогрессивный дизайн в классическом силуэте - ботинки DC Mutiny созданы для комфортного катания и высокой производительности.'),
         ('Куртка для сноуборда DC Mutiny Charocal', 4, 'lot-5.jpg', 7500, '2019-03-10', 200, 1,
          'Горнолыжная куртка от спортивного бренда выполнена из текстиля с использованием водостойкой дышащей мембраны Weather Defense 10K.'),
         ('Маска Oakley Canopy', 6, 'lot-6.jpg', 5400, '2019-03-10', 100, 2,
          'Увеличенный объем линзы и низкий профиль оправы маски Canopy способствуют широкому углу обзора, а специальное противотуманное покрытие поможет ориентироваться в условиях плохой видимости. ');

-- Заполнение ставок --
insert into bets (lot, user, price)
  values (1, 2, 11000),
         (3, 2, 8500);


-- Получение всех категорий --
select * from categories;

-- Получение новых лотов --
select lots.id, lots.name, lots.image, lots.start_price, categories.id, categories.name as category_name
  from lots
  join categories on lots.category = categories.id
 where finish_date > current_timestamp
 order by create_date desc;

-- Получение лота по id --
select lots.*, categories.name as category_name
  from lots
  join categories on lots.category = categories.id
 where lots.id = 1;

-- Получение ставок для лота --
select bets.id, users.name, bets.price, bets.create_date
  from bets
  join lots on bets.lot = lots.id
  join users on bets.user = users.id
 where lots.id = 1
 order by bets.create_date desc;

-- Получение ставок пользователя --
  select bets.id, categories.name, lots.name, lots.finish_date, bets.price, bets.create_date
    from bets
    join lots on bets.lot = lots.id
    join categories on lots.category = categories.id
   where bets.user = 2;

-- Обновить название лота --
update lots
   set name = 'test'
 where id = 1;

-- Поиск лотов --
select categories.name as category_name, lots.id, lots.name, lots.description, lots.image, lots.start_price
  from lots
  join categories on lots.category = categories.id
 where match (lots.name, lots.description) against ('Snowboard' in BOOLEAN mode )
order by create_date desc;

-- Поиск победителей --
select lots.id, lots.name, lots.finish_date, bets.id as bet_id, bets.price, users.name winner_name,
       users.email winner_email
  from lots
  join bets on lots.id = bets.lot
  join users on bets.user = users.id
where lots.finish_date <= current_timestamp()
  and lots.id not in ( select l1.id
                         from lots l1
                         join bets b1 on l1.id = b1.lot
                        where b1.win = 1 )
  and bets.price = ( select max(b2.price)
                       from bets b2
                      where b2.lot = lots.id );