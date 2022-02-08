### Apache

web3層アーキテクチャ(プレゼンテーション層、アプリケーション層、データ層)のプレゼンテーション層(webサーバ)に位置する。

モジュール単位で機能の追加等を行う。

apache_auth_basic  基本認証
mod_dir            ディレクトリ毎に設定
mod_write          URLの書き換え

http.conf or .htaccess にapacheの設定を記述
セクションにより適応範囲を変更
ディレクティブにより設定値を変更

##### httpd.confの編集

https://go-journey.club/archives/14030

```
Aplications > MANP > conf

ServerRoot "/Applications/MAMP/Library"         ルートディレクトリ
Listen 8888                                     webサーバを立ち上げるポート番号

LoadModule                                      モジュールの読み込み
ServerName localhost:8888                       Webサーバーとして公開するホスト名(ホスト名＋ドメイン名)
DocumentRoot "/Applications/MAMP/htdocs"        ドキュメントルート。Webサーバで表示するコンテンツの最上位ディレクトリ

* http://localhost:8888/ から http://localhost/ への変更方法
① MAMP のアプリでApacheのポート番号変更と「Set Web & My SQL ports to 80 & 3306」をクリック。
② httpd.confの Listen と ServerName を変更。
https://simplesimples.com/web/application/mamp/httplocalhost8888_httplocalhost/
https://qiita.com/shiki_neki/items/35d73f57615ed1f1d4fb

・ルートディレクトリ配下の設定を記述(セクションと呼ばれる部分)
<Directory />
    Options Indexes FollowSymLinks
    AllowOverride None
</Directory>

設定を適用する範囲を指定
<Directory "/Applications/MAMP/htdocs">
・
・
</Directory>

・エイリアスの作成(ドキュメントルート以外のパスを立ち上げ可能にする)
以下で http://localhost:8888/apache/ とした時にパスのディレクトリをwebサーバとして立ち上げる。パスの最後は / で終えること。
Alias /apache "パス"
```

##### コンテキストの種類

```
サーバ設定ファイル     httpd.conf, srm.conf, access.conf
バーチャルホスト       <VirturlHost>内で使用可能。仮想ホスト機能。
ディレクトリ          <Directory>, <Location>, <Files>など
.htaccess           .htaccess内で使用可能
```

##### セクションの設定

```
<Directory "パス">
  DirectoryIndex index.php index.html    パスのディレクトリにアクセスした時に表示するファイルを指定する(ファイルを複数記述した場合、先頭から順に探していく。該当するファイルがない場合、ディレクトリ内の一覧を表示する)
  Options -Indexes   該当ファイルがない場合ディレクトリ内一覧表示ではなく、Forbiddenのエラーを表示する
</Directory>

デフォルトの設定は <Directory "/Applications/MAMP/htdocs"> の箇所を見る
```

##### .htaccessの設定

```
apacheの設定を追記するファイル、レンタルサーバを扱う時に使われることが多い。
AllowOverride All で有効化する。None で無効化。初期設定では２箇所記述があるので注意。
リクエスト毎に、ドキュメントルート以下全てのディレクトリに対しこのファイルを探す為パフォーマンスは落ちる。
自身と配下のディレクトリにもディレクティブが有効になる。
階層毎に .htaccess ファイルがある場合は、下位の設定で上書きされる。
```

##### URLのリダイレクト

Redirect [ステータス] URLパス URL(301の場合省略可)  

301 恒久的な移転  
302 一時的な転送 => 301と同じ挙動になったが、一時的もしくはリダイレクト先が条件分岐している場合は302の方が意図が伝わりやすい  
https://www.sakurasaku-labo.jp/blogs/301_redirect

```
Redirect 301 /apache1/todo_list /apache1      /apache1/todo_list へのアクセスに対して /apache へリダイレクトする

https://www.javadrive.jp/apache/htaccess/index10.html
```

##### ログレベル

LogLevel 記録するレベル。デフォルトは error?(バージョンによって異なるかもしれない)
下記レベル8つは上の方がレベルが高く、指定レベル以上のログを全て残す。  
https://www.javadrive.jp/apache/log/index4.html  

サーバ設定ファイル、バーチャルホストに記述可能。.htaccessは不可。

```
・エラーレベル一覧
emerg	サーバが稼動できないほどの重大なエラー
alert	critよりも重大なエラー
crit	重大なエラー
error	エラー
warn	警告
notice	重要なメッセージ
info	サーバ情報
debug	デバック用の情報

・httpd.confの初期設定
ErrorLog "/Applications/MAMP/logs/apache_error.log"    エラーの出力先
LogLevel error

--------------------------------------------------------
*下記は combined と common という名前の2つのログ出力形式が定義されている

LogFormat "%h %l %u %t \"%r\" %>s %b \"%{Referer}i\" \"%{User-Agent}i\"" combined
LogFormat "%h %l %u %t \"%r\" %>s %b" common

<IfModule logio_module>
  # You need to enable mod_logio.c to use %I and %O
  LogFormat "%h %l %u %t \"%r\" %>s %b \"%{Referer}i\" \"%{User-Agent}i\" %I %O" combinedio
</IfModule>

#CustomLog "/Applications/MAMP/logs/apache_access.log" common    #カスタムログ
--------------------------------------------------------

・LogFormatの意味
https://www.tweeeety.blog/entry/20140107/1389091743
https://sumologic.digitalstacks.net/blog/apache-access-log/

変数一覧
https://httpd.apache.org/docs/2.4/ja/mod/mod_log_config.html

・2つフォーマットとカスタムログを作成し、同じファイルに出力してみる => 2つのログが同一ファイルに出力されるのを確認できた(tail -f ファイルパス としておくと楽)
<IfModule log_config_module>
    LogFormat "%h %l %u %t \"%r\" %>s %b \"%{Referer}i\" \"%{User-Agent}i\"" combined
    LogFormat "%h %l %u %t \"%r\" %>s %b" common
    LogFormat "%{Referer}i -> %U" referer
    LogFormat "%{User-agent}i" agent

    CustomLog "/Applications/MAMP/logs/apache_referer.log" agent
    CustomLog "/Applications/MAMP/logs/apache_referer.log" referer
</IfModule>
```

##### REWRITE

サーバー側で擬似的にURLの書き換えを行う。リダイレクトより設定が柔軟に設定可能。  
mod_rewriteモジュールによりURLのリダイレクト・置き換え、正規表現を利用した RewriteRule の使用が可能になる。  
サーバ設定、バーチャルホスト、Directory、.htaccessで使用可。  

https://memorva.jp/memo/linux/mod_rewrite.php

```
・使用条件
RewriteEngine On が必要
Options Indexes FollowSymLinks が必要

・書き方
---------------------------------------------
RewriteEngine On
RewriteRule form/index.php /apache1/index.html   左のURLへのアクセスを右のURLへリダイレクトする(クライアント側には置換前の form/index.php が表示される)   * RewriteRule Pattern substitution[flag]
RewriteRule form/index.php - [F]   * 指定URLへのアクセスに対し Forbidden 403 を返す
---------------------------------------------

* Redirect と RewriteRule の違い
Redirect      外部転送(指定されたURLへアクセス)
RewriteRule   内部転送(同じサーバ内の別の場所へアクセス)を行う。フラグにR(301)をつけるとRedirectを行う
https://penpen-dev.com/blog/rewriterule-redirect-apache/
https://reoxynotes.com/?p=7392

・RewriteBase
基準のディレクトリを指定することで、substitutionでは指定ディレクトリ以下の相対パスの記述で済む
---------------------------------------------
RewriteRule form/index.php /apache1/index.html
↓
RewriteBase /apache1/
RewriteRule form/index.php index.html
---------------------------------------------

・正規表現を使う
---------------------------------------------
RewriteRule form/(.+\.html) index.html    対象ディレクトリのhtmlファイルにマッチさせる
---------------------------------------------

・RewriteCond
RewriteRuleをの条件を定義したもの。RewriteCondを複数記述可。
RewriteCond %{変数名} 条件パターン(正規表現) で記述
* 変数名には httpdの変数が利用できる  https://weblabo.oscasierra.net/apache-rewritecond-base/
---------------------------------------------
URLがホスト名から始まっており、html形式の場合
RewriteCond %{HTTP_HOST} ^localhost:8888     URLがホスト名から始まるか確認
RewriteRule form/(.+\.html) index2.html      転送処理

リクエストされたファイルとディレクトリが存在しない場合、全てのリクエスト(.)をindex.htmlへ置換
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule . index.html
---------------------------------------------

マッチを利用する
---------------------------------------------
sampleディレクトリ配下でファイル名の番号をマッチさせ、ルートディレクトリ配下の同じファイル名に置換
RewriteBase /apache1/
RewriteRule sample/index(\d)\.html$ index$1.html

どこかのディレクトリのhtmlファイルにアクセスした時、ルートディレクトリ配下の同名ファイルに置換
RewriteRule /(.+)\.html$ $1.php
---------------------------------------------

クエリを利用する
---------------------------------------------
URLに http://localhost:8888/apache1/sample/?p=index1.html を打ち込み、sampleディレクトリへのクエリを取得し、ルートディレクトリのファイル名に置換
RewriteCond %{QUERY_STRING} p=(.+)
RewriteRule sample/ %1               %1 で1つ目のマッチ(p=(.+))を参照する
---------------------------------------------
```

##### IfVersion

version_moduleによるバージョン依存の設定を記述  
https://httpd.apache.org/docs/2.4/ja/mod/mod_version.html

```
---------------------------------------------
<IfVersion 2.4.2>      指定バージョンと一致する場合
  LogLevel warn
</IfVersion>

<IfVersion <= 2.4.2>     指定バージョンとより古い場合
  省略
</IfVersion>
---------------------------------------------
```