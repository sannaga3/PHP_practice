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

### コンテキストの種類

```
サーバ設定ファイル     httpd.conf, srm.conf, access.conf
バーチャルホスト       <VirturlHost>内で使用可能。仮想ホスト機能。
ディレクトリ          <Directory>, <Location>, <Files>など
.htaccess           .htaccess内で使用可能
```

### セクションの設定

```
<Directory "パス">
  DirectoryIndex index.php index.html    パスのディレクトリにアクセスした時に表示するファイルを指定する(ファイルを複数記述した場合、先頭から順に探していく。該当するファイルがない場合、ディレクトリ内の一覧を表示する)
  Options -Indexes  　該当ファイルがない場合ディレクトリ内一覧表示ではなく、Forbiddenのエラーを表示する
</Directory>

デフォルトの設定は　<Directory "/Applications/MAMP/htdocs"> の箇所を見る
```

### .htaccessの設定

```
apacheの設定を追記するファイル、レンタルサーバを扱う時に使われることが多い。
AllowOverride All で有効化する。None で無効化。初期設定では２箇所記述があるので注意。
リクエスト毎に、ドキュメントルート以下全てのディレクトリに対しこのファイルを探す為パフォーマンスは落ちる。
自身と配下のディレクトリにもディレクティブが有効になる。
階層毎に .htaccess ファイルがある場合は、下位の設定で上書きされる。
```

### URLのリダイレクト

Redirect [ステータス] URLパス URL(301の場合省略可)  

301 恒久的な移転  
302 一時的な転送 => 301と同じ挙動になったが、一時的もしくはリダイレクト先が条件分岐している場合は302の方がわかりやすい  
https://www.sakurasaku-labo.jp/blogs/301_redirect

```
Redirect 301 /apache1/todo_list /apache1      /apache1/todo_list へのアクセスに対して /apache へリダイレクトする

https://www.javadrive.jp/apache/htaccess/index10.html
```