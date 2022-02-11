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