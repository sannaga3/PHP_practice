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

##### 基本コマンド

```
select version();       バージョン情報確認
select @@datadir;       データの保存場所 /Applications/MAMP/db/mysql57/
https://oreno-it3.info/archives/435
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

テーブル名の頭に mst_ txn_ とつけると把握しやすくなる
```

##### 論理削除

データの削除時に実際には削除せず、削除されたとみなして表示しない方法

```
物理削除    DELETE文発行により削除する。容易に復元したり削除されたデータを参照することができない
論理削除    テーブルに論理削除フラグ（Boolean型やint型）を用いて、UPDATEアクションで削除の有無を管理する。削除後にデータが減らないのでストレージを圧迫していく。

https://www.itd-blog.jp/entry/data-delete-1
```

##### テーブル作成例

```
create table mst_products (
	id int(10) unsigned auto_increment primary key comment 'ID',
	name varchar(20) NOT NULL comment '名前',
	delete_flag int(1) not null default 0,
	updated_at timestamp default current_timestamp on update current_timestamp,
	updated_by varchar(20) not null        * 更新者名を記録することが多い
);

create table mst_prefs (
	id int (2) unsigned auto_increment primary key,
	name varchar(10) not null,
	delete_flag int(1) not null default 0,
	updated_at timestamp default current_timestamp on update current_timestamp,
	updated_by varchar(20) not null
);

create table mst_shops (
	id int(10) unsigned auto_increment primary key,
	name varchar(50) not null,
	pref_id int(2) unsigned not null,
	delete_flag int(1) not null default 0,
	updated_at timestamp default current_timestamp on update current_timestamp,
	updated_by varchar(20) not null,
	constraint fk_pref_id
		foreign key(pref_id)
		references mst_prefs(id)
		on update cascade
);

create table txn_stocks (
	product_id int(10) unsigned,
	shop_id int(10) unsigned,
	amount int(10) unsigned not null,
	primary key(product_id, shop_id),
	delete_flag int(1) not null default 0,
	updated_at timestamp default current_timestamp on update current_timestamp,
	updated_by varchar(20) not null,
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

##### レコード操作

```
・レコードの追加
insert into mst_prefs(name, updated_by) values('北海道', 'sannaga');   1レコード追加
insert into mst_prefs(name, updated_by) values('岩手', 'sannaga'),
('山形', 'sannaga'), ('秋田', 'sannaga');                              複数レコード追加

insert into mst_shops(name, pref_id, updated_by) values('ramens', 1, 'sannaga'); * 外部キーとなるレコードを予め作らないとエラーになる

・レコードの取得
select * from mst_prefs;                           レコードを全て取得
select count(*) from mst_prefs;                    レコードの件数を取得。count(1)としても結果は同じ
select count(*) as "件数" from mst_prefs;           レコードの数に件数という名前をつけて表示。as '' ではエラーになるDBもある、ダブルクォーテーションの方が良い
select id "ID", name "都道府県名" from mst_prefs;    レコードの名前とidを全て取得
select distinct name from mst_prefs;               nameカラムの重複値を省いて表示
select count(distinct name) from mst_prefs;        nameカラムの重複値を省いた後のレコード数を表示

・レコードの削除
delete from mst_shops;                             レコードの削除(親のレコードから順に削除していくこと)
delete from mst_prefs;
alter table mst_prefs auto_increment = 1;          インデックス番号を初期化(レコードを削除してもそのまま番号が振られていくので注意)
alter table mst_shops auto_increment = 1;

・条件句
select * from txn_stocks where product_id = 1;      product_idが１
select * from txn_stocks where product_id <> 1;     product_idが１以外。!= でも同じ
select * from txn_stocks where amount >= 50;        amountが50以上
select * from txn_stocks where product_id = 1 and shop_id = 1;  product_idとshop_idが1
select * from txn_stocks where product_id = 1 or shop_id = 1;   product_idまたはshop_idが1
select * from txn_stocks where (product_id = 1 and shop_id = 1) or (product_id = 2 and shop_id = 2);  ()内の組み合わせのみ

select * from mst_shops where name like '店舗%';     店舗〇〇に一致するもの。〇〇の部分は何文字でも可
select * from mst_shops where name like '店_A';      店〇Aに一致するもの。〇部分は1文字。_を続けて複数文字も可

select * from mst_shops where name in ('店舗A', '店舗C');     いずれかの値に一致するもの
select * from mst_shops where name not in ('店舗A', '店舗C'); どの値にも一致しないもの
select * from txn_stocks where amount between 50 and 100;    範囲内に一致するもの
select * from txn_stocks where amount is null;               amountがnullのもの
select * from txn_stocks where amount is not null;           amountがnullでないもの

・並び替え
select * from txn_stocks order by amount desc;                   amountの降順
select * from txn_stocks where amount > 50 order by amount desc; where文との組み合わせ
select * from txn_stocks order by product_id desc, shop_id desc; product_idで降順にした後、shop_idを降順にする

・limit と offset
select * from txn_stocks order by amount desc limit 2;           降順の上から２つ目まで
select * from txn_stocks order by amount desc limit 2 offset 1;  降順の上から1つ飛ばした所から2つ。limit 1, 2; でも同じだが、limitとoffsetの記述が逆になるので注意。

・レコードの変更
update tablename set columnname = 値 where 変更したいレコードを取得する文

select * from txn_stocks where product_id =1 and shop_id = 1;
update txn_stocks set amount = 50 where product_id = 1 and shop_id = 1;
＊ product_id = 1 かつ shop_id = 1 のレコードを取得し、amountカラムを50に変更。
   select文で予め取得し、変更したいレコードなのを確認してから実際に変更・削除すること。

update txn_stocks set amount = amount - 50 where product_id = 1 and shop_id = 1;   変更する値への自己代入も可
update txn_stocks set amount = amount + 50, delete_flag = 1 where product_id =1 and shop_id = 1;    カラムをまとめて更新

update mst_shops set id = 10 where id = 1;
show full columns from stocks;
* on update cascade の設定により、idを変更するとそのカラムを外部キーにした子テーブルのレコードも変更される。
```

##### テーブルの結合

```
・結合の種類
内部結合    INNER JOIN(結合したテーブルの重複する部分)
左外部結合  LEFT JOIN(結合したテーブルの左側の部分)
右外部結合  RIGHT JOIN(結合したテーブルの右側の部分)
外部結合    OUTER JOIN(結合したテーブルの両方) * MySQLには実装されていない。あまり使う機会がない。

・内部結合
pref_idカラム を用いて mst_shopsテーブル に対して mst_prefsテーブルを結合する

select ms.id, ms.name '店舗名', mp.name '都道府県名' from mst_shops ms
inner join mst_prefs mp      ms, mpはテーブルの省略。内部結合の後 ms.name '店舗名', mp.name '都道府県名'など必要なカラムに限定すると見やすくなる(同名カラムはラベルをつける)
on ms.pref_id = mp.id
where ms.id = 1;        結合後に絞り込み

下記でも上記と同じように取得できる
select ms.id, ms.name '店舗名', mp.name '都道府県名'
from mst_shops ms, mst_prefs mp
where ms.pref_id = mp.id and ms.id =1;

・左外部結合

select pr.name "都道府県名", sh.name "店舗名" from mst_prefs pr
left join mst_shops sh
on pr.id = sh.pref_id;

都道府県名|店舗名|    左側のテーブルのみ全て取得している
----+-----+
北海道 |店舗A |
青森  |店舗B  |
岩手  |店舗C  |
北海道 |ネット店|
山形  |     |
宮城  |     |

・右外部結合

左外部結合のテーブルを逆にすると右外部結合になる
select pr.name "都道府県名", sh.name "店舗名" from mst_shops sh
right join mst_prefs pr
on pr.id = sh.pref_id;

・複数のテーブルを結合

select sh.name "店舗名", ps.name "都道府県名", pr.name "商品名", st.amount "在庫数" from txn_stocks st
inner join mst_shops sh
on st.shop_id = sh.id
inner join mst_products pr
on st.product_id = pr.id
inner join mst_prefs ps
on sh.pref_id = ps.id
order by sh.name;

店舗名 |都道府県名|商品名|在庫数|
-----+-----+----+---+
ネット店舗|北海道  |ベッド |   |
店舗A  |北海道  |テーブル| 50|
店舗A  |北海道  |椅子   | 30|
店舗B  |青森   |テーブル| 80|
店舗B  |青森   |椅子   |  0|
店舗B  |青森   |ベッド | 100|
店舗C  |岩手   |ベッド |  60|
```

##### SQL文の種類

https://morizyun.github.io/database/sql-ddl-dml-dcl.html

```
DDL(Data Definition Language)   DB操作のコマンド。CREATE、DROP、ALTER
DML(Data Manipulation Language) レコード操作のコマンド。SELECT、INSERT、UPDATE、DELETE
DCL(Data Control Language)      トランザクションの制御のコマンド。BEGIN、COMMIT、ROLLBACK
```

##### トランザクション

開始から終了まで連続する複数の操作をひとまとまりにしたもの。(DML文)


```
・ACID特性4つ
Atomicity(原子性)  SQLの命令がすべて実行される(commit)か一つも実行されない(rollback)か、どちらかになる性質のこと。
Consistency(一貫性) トランザクション前後のデータの整合性が保たれ、矛盾が起きない性質。
Isolation(独立性)   トランザクション内部の処理は他のセッションから独立して処理され、別の処理に影響を及ぼさない性質。
Durability(永続性)  トランザクション処理が完了した場合、記録された結果がシステム障害などで失われることがない性質。データ操作の時系列の記録（ログ）を保存しておき、処理中に中断しても復元が可能。

https://e-words.jp/w/ACID%E7%89%B9%E6%80%A7.html


------------------------------------------
start transaction         トランザクション開始

insert into txn_stocks (product_id, shop_id, amount, updated_by) values (1, 3, 20, 'sannaga');   レコード作成

select * from txn_stocks ts where (product_id = 1 and shop_id = 1 )   作成したレコードの確認(この時点で別のセッションを開き同じSQL文を実行しても、トランザクション内の為レコードの追加が反映されていない)
or  (product_id = 1 and shop_id = 3);

update txn_stocks set amount = 1000
where product_id = 1 and shop_id = 1;

commit;                   commitかrollbackで処理が終了する(別のセッションからでも確認できるようになる)
rollback;

* トランザクションを使わずにSQL文を実行した場合は、自動でトランザクションの機能が働いている。
------------------------------------------
```

##### ロックとデッドロック

```
ロック   データを更新する前に行またはテーブルを他のセッションから更新できないようにする。
        データ更新処理(ロック → update → ロック解除)
デッドロック  複数のセッションがロック解除待ちで処理が完了しない状態に陥ること。
            セッションAがトランザクション処理でレコードをロックした状態で、他のセッションが同じレコードをトランザクション処理でロックしてしまうと、どちらのセッションからも解除ができなくなり処理が終わらない。

---------------------------------------------------------------
・デッドロックをしてみる

両方のセッションでトランザクションを開始し、①のクエリを実行する。
その後に②のクエリを実行すると、どちらのレコードにもロックが掛かっている為、それ以上処理が進まなくなる。

# セッション１

start transaction;

①update txn_stocks set amount = 500 where product_id = 1 and shop_id  = 1;
②update txn_stocks set amount = 500 where product_id = 1 and shop_id  = 2;

commit;

# セッション2

start transaction;

①update txn_stocks set amount = 700 where product_id = 1 and shop_id  = 2;
②update txn_stocks set amount = 700 where product_id = 1 and shop_id  = 1;

commit;
---------------------------------------------------------------

・ロック解除待ちの確認
select * from information_schema.innodb_lock_waits;

リクエスト側のID   リクエスト側のロックID ブロックしているID ブロックしている側のロックID
---------------------------------------------------------------------
requesting_trx_id|requested_lock_id|blocking_trx_id|blocking_lock_id|
-----------------+-----------------+---------------+----------------+
42070            |42070:156:3:3    |42069          |42069:156:3:3   |
---------------------------------------------------------------------

* INNODB_LOCK_WAITS テーブルはトランザクションのロックと、リクエストをブロックしているロック全ての情報を持つ。
https://dev.mysql.com/doc/refman/5.6/ja/information-schema-innodb-lock-waits-table.html


・deadlock確認
show engine innodb status;    エンジンの状態に関する広範囲にわたる情報を表示する。

---------------------------------------------------------------
LATEST DETECTED DEADLOCKの項目を確認すると、デッドロックを起こしたセッション名と、デッドロック時にロックを掛けていたSQL文が書かれている

*** (1) TRANSACTION:
TRANSACTION 42080, ACTIVE 11 sec starting index read
mysql tables in use 1, locked 1
/* ApplicationName=DBeaver 21.3.4 - SQLEditor <Product.sql> */ update txn_stocks set amount = 500
where product_id = 1 and shop_id  = 2

*** (2) TRANSACTION:
TRANSACTION 42081, ACTIVE 8 sec starting index read
mysql tables in use 1, locked 1
/* ApplicationName=DBeaver 21.3.4 - SQLEditor <Script-1.sql> */ update txn_stocks set amount = 700
where product_id = 1 and shop_id  = 1
---------------------------------------------------------------

以下がコマンドの結果全文

------------------------
LATEST DETECTED DEADLOCK
------------------------
2022-02-12 10:36:51 0x70000ffe4000
*** (1) TRANSACTION:
TRANSACTION 42080, ACTIVE 11 sec starting index read
mysql tables in use 1, locked 1
LOCK WAIT 3 lock struct(s), heap size 1136, 2 row lock(s)
MySQL thread id 27, OS thread handle 123145569796096, query id 3364 localhost 127.0.0.1 root updating
/* ApplicationName=DBeaver 21.3.4 - SQLEditor <Product.sql> */ update txn_stocks set amount = 500
where product_id = 1 and shop_id  = 2
*** (1) WAITING FOR THIS LOCK TO BE GRANTED:
RECORD LOCKS space id 156 page no 3 n bits 80 index PRIMARY of table `shop_system`.`txn_stocks` trx id 42080 lock_mode X locks rec but not gap waiting
Record lock, heap no 3 PHYSICAL RECORD: n_fields 8; compact format; info bits 0
 0: len 4; hex 00000001; asc     ;;
 1: len 4; hex 00000002; asc     ;;
 2: len 6; hex 00000000a455; asc      U;;
 3: len 7; hex 3b000001300f17; asc ;   0  ;;
 4: len 4; hex 000002bc; asc     ;;
 5: len 4; hex 80000000; asc     ;;
 6: len 4; hex 62070c19; asc b   ;;
 7: len 7; hex 73616e6e616761; asc sannaga;;

*** (2) TRANSACTION:
TRANSACTION 42081, ACTIVE 8 sec starting index read
mysql tables in use 1, locked 1
3 lock struct(s), heap size 1136, 2 row lock(s)
MySQL thread id 29, OS thread handle 123145570631680, query id 3366 localhost 127.0.0.1 root updating
/* ApplicationName=DBeaver 21.3.4 - SQLEditor <Script-1.sql> */ update txn_stocks set amount = 700
where product_id = 1 and shop_id  = 1
*** (2) HOLDS THE LOCK(S):
RECORD LOCKS space id 156 page no 3 n bits 80 index PRIMARY of table `shop_system`.`txn_stocks` trx id 42081 lock_mode X locks rec but not gap
Record lock, heap no 3 PHYSICAL RECORD: n_fields 8; compact format; info bits 0
 0: len 4; hex 00000001; asc     ;;
 1: len 4; hex 00000002; asc     ;;
 2: len 6; hex 00000000a455; asc      U;;
 3: len 7; hex 3b000001300f17; asc ;   0  ;;
 4: len 4; hex 000002bc; asc     ;;
 5: len 4; hex 80000000; asc     ;;
 6: len 4; hex 62070c19; asc b   ;;
 7: len 7; hex 73616e6e616761; asc sannaga;;

*** (2) WAITING FOR THIS LOCK TO BE GRANTED:
RECORD LOCKS space id 156 page no 3 n bits 80 index PRIMARY of table `shop_system`.`txn_stocks` trx id 42081 lock_mode X locks rec but not gap waiting
Record lock, heap no 4 PHYSICAL RECORD: n_fields 8; compact format; info bits 0
 0: len 4; hex 00000001; asc     ;;
 1: len 4; hex 00000001; asc     ;;
 2: len 6; hex 00000000a44e; asc      N;;
 3: len 7; hex 37000001ad035e; asc 7     ^;;
 4: len 4; hex 000001f4; asc     ;;
 5: len 4; hex 80000001; asc     ;;
 6: len 4; hex 62070ae8; asc b   ;;
 7: len 7; hex 73616e6e616761; asc sannaga;;
```

##### truncate文

```
------------------------------------
truncate table txn_stocks;
------------------------------------

rollbackで戻せない
deleteより速い(delete文は1レコードずつ削除するが、truncateはテーブル毎削除してから作り直す)
whereは使えない
auto_incrementは初期値に戻る

https://www.dbonline.jp/mysql/insert/index12.html
https://uxmilk.jp/52122
```

##### システム変数

MySQL サーバーを操作するための変数。

```
・2種類のシステム変数
グローバル変数   サーバーの操作全体に影響する.サーバーが起動時に各グローバル変数はデフォルト値に初期化。
セッション変数   個々のクライアント接続の操作に影響する

@@session.変数名   現在のセッションの値を取得
@@global.変数名    サーバー上の値を取得
@@変数名           sessionとglobal両方に設定できる変数の場合、session => global の順番で取得する


・システム変数の変更
SET ステートメントを使用して変更する

https://docs.oracle.com/cd/E17952_01/mysql-8.0-ja/using-system-variables.html

set session
set global

------------------------------------
show variables;                         システム変数一覧表示
show session variables like '%auto%';   セッションのシステム変数を名前で絞り込み検索
select @@session.autocommit;  =>  1     autocommitのセッションのシステム変数値を表示
set session autocommit = 0;             autocommitの値を変更(セッションを再起動すると元に戻る)。無効にすると常にstart transactionの状態であり、commitする毎にレコードに反映される。
------------------------------------

* autocommit  SQL文実行時に自動でトランザクションを開始し、終了時にコミット、エラー時にはロールバックを行う機能。
https://dev.mysql.com/doc/refman/8.0/ja/innodb-autocommit-commit-rollback.html
```

##### ユーザー定義変数

変数を作成し、そこにカラムの値や集計値を保存して扱う機能。(セッション変数)  
SET @[変数名] = 値;  
https://notepad-blog.com/content/166/  
https://tocsato.hatenablog.com/entry/2016/08/31/065408

```
------------------------------------
set @s_id = 2;
select * from mst_shops ms where ms.id = @s_id;                shop_id = 2 のレコードを取得
select @s_name := name from mst_shops ms where ms.id = @s_id;  @s_name に shop_id = 2 の nameの値を格納
select @s_name;   格納した値の確認
------------------------------------
```

##### TIMESTAMPとDATETIME

```
・TIMESTAMP
4bytes
'1970-01-01 00:00:01' UTC to '2038-01-09 03:14:07'   2038年までしか使えない
タイムゾーンを考慮する

・DATETIME
5bytes(バージョンが古いと8bytes)
'1000-01-01 00:00:00' to '9999-12-31 23:59:59'       期限の制限がない
タイムゾーンを考慮しない

-------------------------------------------------
create table dates(
	dt datetime,
	ts timestamp
);

select @@session.time_zone;    タイムゾーンの取得。デフォルト値は SYSTEM(ホストマシンのタイムゾーンと同じ)
                               https://dev.mysql.com/doc/refman/5.6/ja/time-zone-support.html

insert into dates values(now(), now());          各カラムの値に現在時刻を使用しレコードを作成
select * from dates;

dt                 |ts                 |
-------------------+-------------------+
2022-02-12 06:19:36|2022-02-12 06:19:36|

set session time_zone = "+1:00";                 time_zoneを変更すると、timestampに格納した値の表現が変わる
insert into dates values(now(), now());          NOW(), SYSDATE() は timestamp で値が返る
select * from dates;

dt                 |ts                 |
-------------------+-------------------+
2022-02-12 14:19:36|2022-02-12 06:19:36|
2022-02-12 06:22:06|2022-02-12 06:22:06|
-------------------------------------------------
```

##### ユーザの作成

create user {ユーザー名}@{接続元のホスト名} identified by 'password';  * ユーザ作成
grant {権限名} on {対象のDBオブジェクト} to {ユーザー};                 * 権限の付与

```
-------------------------------------------------
select user();                                            現在のユーザ確認 => root
create user 'test_user'@'localhost' identified by 'pwd';  localhostで接続するユーザ(test_user)を作成
select * from mysql.user;                                 mysqlで扱えるユーザーを表示

grant select on shop_system.* to 'test_user'@'localhost'; shop_systemのDBでselectコマンドを使える権限の付与

grant insert, update on shop_system.* to 'test_user'@'localhost';  shop_systemのDBでupdateとinsertコマンドを使える権限の付与
grant create, alter on shop_system.* to 'test_user'@'localhost';
-------------------------------------------------

新たなセッションを作成しtest_userでログイン。以下のコマンドを入力していく。

-------------------------------------------------
select user();                                           test_userが表示される

use shop_system;

select * from mst_shops;                                 ショップ一覧を確認

update mst_shops set delete_flag = 1, updated_by = 'set_user';  updateコマンドで編集が可能になっている
-------------------------------------------------

権限を確認する

-------------------------------------------------
show grants for 'test_user'@'localhost';                指定ユーザの権限を確認

-----------------------------------------------------------------------------------------
Grants for test_user@localhost                                                           |
-----------------------------------------------------------------------------------------+
GRANT USAGE ON *.* TO 'test_user'@'localhost'       * この行はデフォルト値(実際の権限はない)   |
GRANT SELECT, INSERT, UPDATE, CREATE, ALTER ON `shop_system`.* TO 'test_user'@'localhost'|
-----------------------------------------------------------------------------------------

-------------------------------------------------

権限を削除する

-------------------------------------------------
grant all on shop_system.* to 'test_user'@'localhost';     shop_systemの全てのテーブルとレコードへのアクセスを許可
revoke all on shop_system.* from 'test_user'@'localhost';  上記の権限を削除

* allはrootと同じフル権限を与えるため、一般ユーザに付与すべきではない
https://www.digitalocean.com/community/tutorials/how-to-create-a-new-user-and-grant-permissions-in-mysql-ja
-------------------------------------------------
```

##### 文字コード

```
-------------------------------------------------
utf-8      本来なら4byteだが、mysqlでは3byteのため、表示できない文字がある。非推奨とされており、将来的に削除され、utf8mb3という表記が必要になるかも。
utf-8mb4   4byte。全ての文字列と絵文字に対応する。

＊utf8 は現在 utf8mb3 のエイリアスだが、今後 utf8mb4 への参照になる可能性が高い。utf8mb4を使うべき。
https://penpen-dev.com/blog/mysql-utf8-utf8mb4/


create database sample character set 'utf8mb4';                         DBを作成する時の文字コード指定
create table sample( table名 変数名(データ型) character set 'utf8mb4');    テーブルを作成する時の文字コード指定
-------------------------------------------------
・絵文字をレコードに保存してみる

create table character_code(
	ut3 varchar(20) character set 'utf8',
	ut4 varchar(20) character set 'utf8mb4'
);

insert into character_code(ut3) values ('😆');   * 保存できない
insert into character_code(ut4) values ('😆');   * 保存可能

select * from character_code;

ut3|ut4|
---+---+
   |😆 |
-------------------------------------------------
```
