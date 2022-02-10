### MySQL

##### InnoDB

MySQL5.5以降でデフォルトのエンジン。
https://docs.oracle.com/cd/E17952_01/mysql-8.0-ja/innodb-introduction.html
https://dev.mysql.com/doc/refman/5.6/ja/innodb-default-se.html

DBeaverのSQL実行方法
```
opt + x       1行実行
ctrl + enter  複数行実行
* DBの作成や削除後は更新しないと変更が反映されない
```

##### データ型

```
・整数型
TINYINT      1バイト 4桁 範囲: -128 ～ 127                       または 0 ～ 255
SMALLINT     2バイト 6桁 範囲: -32,768 ～ 32,767                 または 0 ～ 65,535
MEDIUMINT    3バイト 9桁 -8,388,608 ～ 8,388,607                または 0 ～ 16,777,215
INTEGER（INT）4バイト 11桁 範囲: -2,147,483,648 ～ 2,147,483,647  または 0 ～ 4,294,967,295
BIGINT       8バイト 20桁 範囲: -9,223,372,036,854,775,808 ～ 9,223,372,036,854,775,807 または 0 ～ 18,446,744,073,709,551,615

UNSIGNED   プラス値だけに制限する
ZEROFILL   余った桁を左から0埋めする

int  unsigned  zerofill
https://blog.s-giken.net/367.html
```

##### テーブル・DB操作

```
・テーブル作成
test_tableテーブルを作成。id(6桁までの整数)とval(20桁までの可変文字数)の2つのカラムを持つ。

create table test_db.test_table (            * test_db. DBの指定
	id int(6) unsigned default 0 comment 'ID',    * comment部分はカラム名の和訳
	val varchar(20) default 'hello' comment '値'
);

・テーブル削除
drop table test_db.test_table;

・テーブル詳細確認
desc test_db.test_table;                    主要な項目のみ(describe)
show full columns from test_db.test_table;  commentなども含む(fullを付けないとdescと同じ)

show create table test_db.test_table;       テーブル情報の表示
↓  結果
CREATE TABLE `test_table` (
  `id` int(6) unsigned DEFAULT '0' COMMENT 'ID',
  `val` varchar(20) DEFAULT 'hello' COMMENT '値'
) ENGINE=InnoDB DEFAULT CHARSET=utf8

・DB切り替え
use test_db;              アクティブなDBを切り替える(以降の記述でDB部分を省略できる)
desc test_table;
```

##### 制約

UNIQUE:        一意
NOT NULL: NOT  NULLはダメ
CHECK:        チェック
PRIMARY KEY:  主キー
FOREIGN KEY:  外部キー

```
create table test2 (
	key1 int,
	key2 int,
	primary key(key1, key2),              複合主キーの設定(key1とkey2の組み合わせが一意であればOK)
	id int not null default 0 comment 'ID',
	val varchar(20) unique comment '値'
);
```

##### カラム操作

```
create table test3 (
	key1 int auto_increment primary key   index番号のあるカラムに対して自動的に連番を振る機能(テーブルに1つしか設定できない)
);
alter table test3                       カラムの追加
add column val1 varchar(10),
add column val2 varchar(10);

alter table test3
add column item1 varchar(10) after key1,    指定カラムの後に追加
add column item2 varchar(10) after item1;
modify column item2 int(5) default 0;       データ型の変更 varchar => int

alter table test3 drop column item2;        itemの削除

alter table test3
modify column key1 int(10) not null;        auto_incrementを解除しておく(解除しないとエラーになる)
alter table test3 drop column key1;         key1(primary key の削除)

alter table test3 change item3 item2 varchar(10);    カラム名の変更 item3 => item2
alter table test3 change item2 item2 text;           カラムのデータ型定義を変更 varchar(10) => text
```

##### 外部キー

自動でインデックスが付与される。

```
create table prefs (
	id int(2) unsigned auto_increment primary key,
	name varchar(10) not null
);

create table shops (
	id int(10) unsigned auto_increment primary key,
	name varchar(50) not null,
	pref_id int(2) unsigned not null                   外部キーに使うカラム作成(紐付ける親テーブルのデータ型と同じにしておく)
);


ON DELETE cascade(子テーブルの該当データも削除) or restrict(エラーを出力し削除できないようにする) or set null(子テーブルの該当データをnullに置き換える)
＊ デフォルトは restrict
https://www.guri2o1667.work/entry/2020/10/27/%E3%80%90MySQL%E3%80%91%E5%A4%96%E9%83%A8%E3%82%AD%E3%83%BC%E5%88%B6%E7%B4%84%EF%BC%88ForeignKey%E5%88%B6%E7%B4%84%EF%BC%89%E3%81%AEon_delete%E8%A8%AD%E5%AE%9A%E3%81%AB%E3%81%A4%E3%81%84%E3%81%A6

・外部キーの制約作成
alter table shops
add constraint fk_pref_id           制約の名前
foreign key(pref_id)                制約をつけるカラム
references prefs(id)                紐付けられる親テーブルとカラム
on update cascade                   親データのupdate時に子テーブルも書き換え
on delete restrict;                 親子関係の紐づいた状態でdeleteできないようにエラーを出力

https://qiita.com/SLEAZOIDS/items/d6fb9c2d131c3fdd1387
```

##### 複合主キー

```
create table stocks (
	product_id int(10) unsigned,
	shop_id int(10) unsigned,
	amount int(10) unsigned not null,
	primary key(product_id, shop_id)     product_id と shop_id を複合主キーに設定
);
```

##### テーブルの種類

```
トランザクションテーブル  日常的に更新、削除、追加することが多いテーブル。注文履歴、顧客情報、請求情報、従業員、部署、勤務体系、役職。
マスターテーブル         参照専用のテーブル。業務を遂行する際の基礎情報。管理者のみが更新を行う。辞書、勤務時間、休憩時間。

https://honey8823.hateblo.jp/entry/2015/08/04/172902
https://qiita.com/puripuri_corgi/items/5547813f75038e368be7
https://ameblo.jp/natumasapapa0420/entry-12655253631.html

テーブル名の頭に mst_ tsx_ とつけると把握しやすくなる
```

##### 論理削除

データの削除時に実際には削除せず、削除されたとみなして表示しない方法

```
物理削除    DELETE文発行により削除する。容易に復元したり削除されたデータを参照することができない
論理削除    テーブルに論理削除フラグ（Boolean型やint型）を用いて、UPDATEアクションで削除の有無を管理する。削除後にデータが減らないのでストレージを圧迫していく。

https://www.itd-blog.jp/entry/data-delete-1
```

・テーブル作成例

```
create table mst_products (
	id int(10) unsigned auto_increment primary key comment 'ID',
	name varchar(20) NOT NULL comment '名前',
	delete_flag int(1) not null default 0,
	update_at timestamp default current_timestamp on update current_timestamp,
	update_by varchar(20) not null
);

create table mst_prefs (
	id int (2) unsigned auto_increment primary key,
	name varchar(10) not null,
	delete_flag int(1) not null default 0,
	update_at timestamp default current_timestamp on update current_timestamp,
	update_by varchar(20) not null
);

create table mst_shops (
	id int(10) unsigned auto_increment primary key,
	name varchar(50) not null,
	pref_id int(2) unsigned not null,
	delete_flag int(1) not null default 0,
	update_at timestamp default current_timestamp on update current_timestamp,
	update_by varchar(20) not null,
	constraint fk_pref_id
		foreign key(pref_id)
		references mst_prefs(id)
		on update cascade
);

create table mst_stocks (
	product_id int(10) unsigned,
	shop_id int(10) unsigned,
	amount int(10) unsigned not null,
	primary key(product_id, shop_id),
	delete_flag int(1) not null default 0,
	update_at timestamp default current_timestamp on update current_timestamp,
	update_by varchar(20) not null,
	constraint fk_product_id
		foreign key (product_id)
		references mst_products(id)
		on update cascade,
	constraint fk_shop_id
		foreign key (shop_id)
		references mst_shops(id)
		on update cascade
);
```
