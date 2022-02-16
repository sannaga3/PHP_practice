drop db pollapp;
create database if not exists pollapp default character set utf8mb4 collate utf8mb4_general_ci;
use pollapp;

create user if not exists 'test_user'@'localhost' identified by 'pwd';
grant all on pollapp.* 'test_user'@'localhost';

create table comments (
  id int(10) unsigned auto_increment primary key comment 'コメントID',
  topic_id int(10) not null comment 'トピックID',
  agree int(1) not null comment "賛否(賛成:1, 反対:0)",
  body varchar(100) default null comment '本文',
  user_id varchar(10) not null comment "作成したユーザID",
  del_flg int(1) not null default 0 comment '削除フラグ(1: 削除, 0: 利用可)',
  updated_by varchar(20) not null default 'sannaga' comment '最終更新者',
  updated_at timestamp not null default current_timestamp on update current_timestamp comment '最終更新日'
);

create table topics (
  id int(10) unsigned auto_increment primary key comment 'トピックID',
  title varchar(30) not null comment 'トピックタイトル',
  published int(1) not null comment '公開状態(1: 公開, 0: 非公開)',
  views int(10) not null default 0 comment '閲覧数',
  likes int(10) not null default 0 comment'賛成数',
  dislikes int(10) not null default '0' comment '反対数',
  user_id varchar(10) not null comment '作成したユーザーID',
  del_flg int(1) not null default 0 comment '削除フラグ(1: 削除, 0: 利用可)',
  updated_by varchar(20) not null default 'sannaga' comment '最終更新者',
  updated_at timestamp not null default current_timestamp on update current_timestamp comment '最終更新日'
);

create table users (
  id varchar(10) primary key comment 'ユーザID',
  pwd varchar(60) not null comment 'パスワード',
  nickname varchar(10) not null comment 'ニックネーム',
  del_flg int(1) not null default 0 comment '削除フラグ(1: 削除, 0: 利用可)',
  updated_by varchar(20) not null default 'sannaga' comment '最終更新者',
  updated_at timestamp not null default current_timestamp on update current_timestamp comment '最終更新日'
);

start transaction;

set time_zone = '+9:00';

insert into comments (id, topic_id, agree, body, user_id, del_flg) values
(1, 1, 0, 'いいえ遅いです。', 'test', 0),
(2, 1, 1, '亀はウサギよりも早いと思います。', 'test', 0),
(3, 1, 1, '早いですね。', 'test', 0),
(4, 1, 1, 'いや遅いですね。', 'test', 0),
(5, 2, 0, 'いいえ。そんなことないと思います。', 'test', 0),
(6, 2, 1, 'はい。そうでしょうね。', 'test', 0),
(7, 3, 1, 'はい。そうですね。', 'test', 0),
(8, 3, 1, 'うん、そう思います。', 'test', 0),
(9, 3, 0, 'そうですかね？', 'test', 0),
(10, 4, 1, 'たまには当たるのでは？？', 'test', 0),
(11, 4, 0, '多分、当たらないですよ。', 'test', 0),
(12, 4, 0, 'あなたの思い込みでは。。', 'test', 0),
(13, 4, 1, 'はい。当たります。', 'test', 0),
(14, 4, 1, '一生に一回くらいは当たると思います。', 'test', 0);

insert into topics (id, title, published, views, likes, dislikes) values
(1, '亀はウサギよりも早いですか？', 1, 8, 3, 1, 'test', 0),
(2, 'スーパーサイヤ人は最強ですか？', 1, 9, 1, 1, 'test', 0),
(3, 'たこ焼きっておいしいですよね。', 1, 21, 2, 1, 'test', 0),
(4, '犬も歩けば棒に当たりますか？', 1, 25, 3, 2, 'test', 0);

insert into users (id, pwd, nickname, del_flg) values
('test', '$2y$10$n.PPvod4ai0r0qpqn5DurenOoxTyRhvef3S7DxoMu5BLRspG5oiBK', 'テストユーザー', 0);

commit;