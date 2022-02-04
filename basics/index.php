<?php
  declare(strict_types=1);
  // strictモード　厳密な型宣言を必要とするモード、strict_types=1 で有効になる。ファイルの先頭に記述が必要。
  function add3(int $val): int  // 引数と返り値の型を指定
  {
    return $val + 1;
  }
  // $result = add1("1");  //　int型以外はエラーになる
  echo $result5 = add3(1);
  var_dump($result5);
?>

<!-- <?php
// 配列①

echo 'abc';
$array = ['taro', 'hanako', 'jiro'];
$array2 = array('a', 'b', 'c');
print_r($array);
echo '<br>';
var_dump($array2);
echo '<br>';
echo $array[1];
$array[1] = 'kotaro';
echo '<br>';
echo $array[1];
echo '<br>';
$array[] = 'last';
echo $array[array_key_last($array)];
echo '<br>';
echo count($array2);

for($i = 0; $i < count($array); $i++) {
  echo '<div>', $i, ' : ', $array[$i], '</div>';
}
echo '----------------------------';
echo '<br>';
foreach($array as $i => $v) {
  echo '<div>',  $i, ' : ', $v, '</div>';
}
?> -->


<!-- <?php
// 配列②

  $array = [
    ['table', 1000],
    ['chair', 800],
    ['desk', 2000],
  ];
  foreach($array as $val){
    echo "{$val[0]} is {$val[1]}";
    echo '<br>';
  }

  $array[0][0] = 'bed';
  echo $array[0][0];
  echo '<br>';
  echo '----------------------------';
  echo '<br>';

  array_shift($array);     // 先頭を削除
  foreach($array as $val){
    echo "{$val[0]} is {$val[1]}";
    echo '<br>';
  }
  echo '<br>';
  echo '----------------------------';
  echo '<br>';

  array_pop($array);     // 末尾を削除
  foreach($array as $val){
    echo "{$val[0]} is {$val[1]}";
    echo '<br>';
  }

  echo '<br>';
  echo '----------------------------';
  echo '<br>';

  $array = [
    ['table', 1000],
    ['chair', 800],
    ['desk', 2000],
    ['desk', 2000],
    ['desk', 2000],
  ];

  array_splice($array, 2, 3);   // 要素番号からn個を削除
  foreach($array as $val){
    echo "{$val[0]} is {$val[1]}";
    echo '<br>';
  }

  echo '<br>';
  echo '----------------------------';
  echo '<br>';

  array_splice($array, 0, 1, [['shelf', 1500]]);   // 要素番号からn個を削除し、第四引数に置換
  foreach($array as $val){
    echo "{$val[0]} is {$val[1]}";
    echo '<br>';
  }
?> -->


<!-- <?php
// 連想配列

$array = [
  'name' => 'Bob',
  'age' => 20,
  'sports' => ['soccer', 'basketball']
];
echo $array['name'], '<br>';
echo $array['age'] += 20, '<br>';
echo $array['sports'][0], '<br>';
echo '----------------------------', '<br>';

unset($array['name']);              // 対象のkeyを削除
$keys = array_keys($array);         // key一覧を取得            https://webukatu.com/wordpress/blog/29767/
foreach($keys as $val){             // key一覧を表示
  echo $val, '<br>';
}

echo '----------------------------', '<br>';

//  配列で異なる次元数の場合の全要素取得方法
foreach($array as $key => $val){
  if(is_array($val)) {               // is_arrayメソッド    引数が配列であればtrue
    foreach($val as $key2 => $val2){
      echo $key." : ".$val2.'<br>';
    }
  } else {
    echo $key." : ".$val.'<br>';
  }
}
?> -->


<!-- <?php
  $products = [
    'table' => [1000, 3],
    'chair' => [500, 6],
    'bed' => [3000, 2],
  ];
  $cart = [
    'table' => 1,
    'bed' => 2
  ];
  echo '<div>商品在庫</div>';
  foreach($products as $key => $val) {
    echo $key.' is '.$val[0].' dollers, and in stock '.$val[1].'<br>';
  }
  echo '<div>商品購入</div>';
  foreach($cart as $key => $val) {
    $c_name = $key;
    $c_stock = $val;
    echo "<div>Can I get {$c_stock} of {$c_name}?</div>";

    $p_stock = $products[$c_name][1];
    if($c_stock <= $p_stock) {
      echo '<div>OK, Thank you for your purchase!</div>';
    } else {
      echo '<div>Sorry, we don’t have enough stock to sell</div>';
    }
  }
?> -->


<!-- <?php
// 正規表現
  $char = "aAbBBbbaAadicls_aAa";
  if (preg_match("/aAa/", $char, $matches)) {
    echo 'success <br>';
    print_r($matches);
  } else {
    echo 'failed';
  }

  if (preg_match("/\w+/", $char, $matches)) {
    echo 'success <br>';
    print_r($matches);
  } else {
    echo 'failed';
  }

  if (preg_match("/ba/", $char, $matches)) {
    echo 'success <br>';
    print_r($matches);
  } else {
    echo 'failed';
  }
  if (preg_match("/bbbb/i", $char, $matches)) {
    echo 'success <br>';
    print_r($matches);
  } else {
    echo 'failed';
  }

  $char = "abcdeFG";
  if (preg_match("/[b-zF]{2,7}/", $char, $matches)) {  // []の文字で2-7文字の最長がマッチングする
    echo 'success <br>';
    print_r($matches);
  } else {
    echo 'failed';
  }
  $char = "<div>1ZAbcde_123_abc</div>";
  if (preg_match("/(123)(.+)<\/div>/", $char, $matches)) {
    echo 'success <br>';
    print_r($matches);           // マッチした部分全て、1つ目のマッチ、2つ目のマッチで配列に格納される
  } else {
    echo 'failed';
  }
?> -->


<!-- <?php
  function post_code_check($char){
    if (preg_match("/^\d{3}-\d{4}$/", $char, $matches)) {
      echo 'success ';
      print_r($matches);         // マッチした部分全て、1つ目のマッチ、2つ目のマッチで配列に格納される
      echo '<br>';
    } else {
      echo 'failed', '<br>';
    }
  }
  post_code_check("001-0012");
  post_code_check("001-001");
  post_code_check("2.2-3022");
  post_code_check("aa2-3022");
  post_code_check("332-30223");
  echo '-----------------------------', '<br>';
?> -->


<!-- <?php
  function email_check($char){
    if (preg_match("/^[\w\.\-]+@[\w\.]+$/", $char, $matches)) {
      echo 'success ';
      print_r($matches);         // マッチした部分全て、1つ目のマッチ、2つ目のマッチで配列に格納される
      echo '<br>';
    } else {
      echo 'failed', '<br>';
    }
  }
  email_check("example000@gmail.com");
  email_check("example-0.00@gmail.com");
  email_check("example-0.00@ex.co.jp");
  email_check("example/0.00@ex.co.jp");
  echo '-----------------------------', '<br>';
?> -->


<!--
<?php
  function html_check($char){
    if (preg_match_all("/<h[1-6]>(.+)<\/h[1-6]>/", $char, $matches)) {   // reg_match_allメソッド  マッチする部分全てを返す
      print_r($matches[count($matches) - 1]);         // 各マッチごとに表示
      echo '<br>';
    } else {
      echo 'failed', '<br>';
    }
  }
  html_check("
    <!DOCTYPE html>
    <html>
    <head>
        <title>Document</title>
    </head>
    <body>
        <h1>見出し１</h1>
        <h2>見出し２</h2>
        <h3>見出し３</h3>
        <header>ヘッダー</header>
    </body>
    </html>");
  echo '-----------------------------', '<br>';
?> -->


<!-- <?php
  $fruits = array ('a' => 'apple', 'b' => 'banana', 'c' => array ('d', 'e', 'f'));
  print_r ($fruits);
?> -->


<!-- <?php
  function total_sum($numbers) {
    $sum = 0;
    foreach($numbers as $num) {
      $sum = $sum + $num;
    }
    return $sum;
  }
  $result = total_sum([1, 2, 3, 4]);
  echo $result, '<br>';
  $result2 = total_sum([1, 2, 3, 4, 5]);
  echo $result2, '<br>';
?> -->


<!-- <?php
  /*
  *  PHPDoc PHPで書かれたものについてのドキュメントを、ソースコードのコメント内に記述するための書式
  *  ~のファイル
  *  @author
  *  @since 1.0.0
  *
  *  税込金額を取得する変数
  *  @param int $base_price　価格
  *  @param float $tax_rate  税率
  *  @return int なければ void
  *  @see url
  */
  $price = 1000;
  function with_tax($base_price, $tax_rate = 0.1) {
    $sum_price = $base_price + ($base_price * $tax_rate);
    return $sum_price = round($sum_price);
  }
  $result = with_tax($price, 0.12);
  echo $result, '<br>';
  $result = with_tax($price);
  echo $result, '<br>';

  $fn = "with_tax";
  $result = $fn($price, 0.08);   //  phpの特徴として、文字列でも関数を実行できる
  echo $result, '<br>';
?> -->


<!-- <?php
// スコープ　　グローバルスコープ、ローカルスコープ、スーパーグローバル
$a = 1;
$b = 2;
function fn1() {
  global $a, $b;           // globalの宣言がないとグローバル変数を関数内で扱えない。
  $c = 3;
  if(true) {
    $e = 10;
  }
  echo $e, '<br>';
  return $a + $b + $c;
}
echo fn1();
// echo $c;         　　　　　// スコープ外の為参照不可
// var_dump($_SERVER);      // スーパーグローバルスコープ。定義済み変数。スクリプト全体を通してすべてのスコープで使用可能な変数。$ _SERVER はスクリプト、HTTPヘッダー、サーバーパスに関する情報を保持する。
?> -->


<!-- <?php
  $attendance = true;
  $student1 = 'taro';
  $student2 = 'jiro';
  $student3 = 'sabro';
  function tenko($student, $is_absent = false) {
    if ($is_absent) {
      echo "{$student} is attendance", '<br>';
    } else {
      echo "{$student} is not attendance", '<br>';
    }
  }
  tenko($student1, true);
  tenko($student2, true);
  tenko($student3);
?> -->


<!-- <?php
  function counter($step = 1) {
    global $num;
    $num += $step;
    echo $num, '<br>';
    return $num;
  }
  $num = 0;
  counter(2);
  counter(2);
?> -->


<!-- <?php
// 三項演算子　null合体演算子

$arry = [
  'key' => 10,
];
if (isset($arry['key'])) {
  $arry['key'] *= 10;
} else {
  $arry['key'] = 1;
}
echo $arry['key'], '<br>';

unset($arry['key']);
echo $arry['key'] = isset($arry['key']) ? $arry['key'] * 10 : 1, '<br>';      // 三項演算子

unset($arry['key']);
echo $arry['key'] = $arry['key'] ?? 5, '<br>';         // null合体演算子   keyが設定されている場合、そうでない場合で異なる値を返す。
?> -->

<!-- <?php
// 定数

const TAX_RATE = 0.1;               // 名前空間での宣言になる
$price = 100;
echo $price + $price * TAX_RATE, '<br>';

if (!defined('TAX_RATE2')) {        // definedメソッド   引数の定数が定義されているならtrue
  define('TAX_RATE2', 0.5);         // constはif文の中では扱えない為、defineメソッドで定義する。defineでの定義はグローバルスコープになる
  echo $price + $price * TAX_RATE2;
}
?> -->


<!-- <?php
// ファイルの読み込み
// require  ファイルが見つからないと、エラーになりその時点で処理がストップ　　　関数の読み込みに使う
// include  ファイルが見つからないと警告は出るが、処理は進む                 htmlタグ等の読み込みに使う

$arry = [
  'num' => 0
];
require('file1.php');
fn3();   // 上記ファイルのファンクションを呼ぶ
echo '<br>';
require('file1.php');
echo $arry['num'];  // file1を2回呼んだ為、2回 $num++ されている

require_once('file2.php');
require_once('file2.php');   // require_onceメソッド  読み込みの重複を防ぐ

// マジカル定数　 PHPで自動的に定義される定数　
// __LINE__　行番号
// __FILE__　ファイルパス
// __DIR__　ディレクトリパス
// __FUNCTION__　関数名　など

echo __FILE__, '<br>';      // このファイルのフルパスを表示
echo __DIR__, '<br>';       // このファイルの配置されているディレクトリのフルパスを表示
echo dirname(__FILE__, 3);  // 3階層上位のディレクトリまでのフルパスを表示
?> -->

<!-- <?php
  // 名前空間

  require_once 'lib.php';
  use function lib\with_tax2;         //  関数の呼び出し。 \lib\with_tax(1000, 0.1) の \lib が不要になる
  // echo \lib\TAX_RATE3, '<br>';        //  定数の呼び出し
  use const lib\TAX_RATE3;
  echo TAX_RATE3, '<br>';
  $price = with_tax2(1000, 0.1);      //  関数の呼び出し use function を使ってない場合は \lib\with_tax2(1000, 0.1)
  echo $price;

  function global_echo() {
    echo 'this function is global. <br>';
  }
  class GlobalClass {
    function class_exception() {
      echo 'this is global class <br>';
    }
  }
?> -->

<!-- <?php
// クラス
  class Person
  {
    protected $name;
    protected $age;
    public $hobby;
    public static $live = 'Tokyo';   // public const でプロパティを指定しても同じ意味。　先頭の $ はつけない。const だと定数なので上書きできない。

    function __construct($name, $age)   // コンストラクタ関数。インスタンス生成時に呼び出される
    {
      $this->name = $name;
      $this->age = $age;
    }
    function hello() {
      echo 'hello, ' . $this->name, '<br>';  // $this->name インスタンス自身のプロパティにアクセスする
      static::class_introduction();          // クラスメソッド内で静的メソッドを呼び出す方法　  self::class_introduction と self を使っても良い
      return $this;                          // $thisは自身のインスタンスを指す。$bob または $alice が返る為、インスタンスメソッドを続けて記述できる
    }
    function bye() {
      echo 'bye <br>';
      return $this;
    }
    static function class_introduction() {    // 静的メソッド　クラス自体が保持するメソッド。＄thisでインスタンスを示すことはできない
      echo "my class is Person <br>";
    }
    function get_age() {
      echo $this->age, '<br>';
    }
  }

  $bob = new Person('bob', 18);  // コンストラクタ関数への引数を持たせてインスタンスを生成
  $bob->hello();
  $bob->get_age();
  $bob->hobby = 'soccer';
  echo $bob->hobby, '<br>';

  $alice = new Person('alice', 25);
  $alice->hello()->bye()->get_age(). '<br>';   //  チェーンメソッド。メソッドが return $this で終わる場合にメソッドをさらに続ける。

  Person::class_introduction();
  $alice->class_introduction();    // インスタンスから静的メソッドを呼び出すことはできる
  echo Person::$live, '<br>';      // 静的プロパティの呼び出し
  echo '-------------------------- <br>';

  class Japanese extends Person {
    function hello() {
      echo 'hello, ' . $this->name, '<br>';
      return $this;
    }
  }
  $jane = new Japanese('太郎', 30);
  $jane->hello();
?> -->


<!-- <?php
  // 抽象クラス    継承後にインスタンス化することを前提としたクラス。抽象クラス自身はインスタンス化できない。
  abstract class Animal {
    protected $name;
    public static $live = "Lisa's house";     // static  クラスが保持するプロパティ。インスタンス化せずにアクセスできる。

    function __construct($name)
    {
      $this->name = $name;
      echo '<br> ------------------------<br>';
      echo self::$live;       // 自身のプロパティを呼ぶ
      echo '<br> ------------------------<br>';
      echo static::$live;     //　継承先のプロパティを呼ぶ。継承先でオーバーライドされていなければ自身のクラスのプロパティを呼ぶ
      echo '<br> ------------------------<br>';
    }
    function get_name() {
      echo $this->name, '<br>';
      return $this;
    }
    abstract function express_abstract();   // 抽象メソッド　　メソッド名のみ宣言する。継承後のクラスでオーバーライドして扱う。オーバーライドしないとエラーになる。
    function run() {
      echo $this->name . ' is running <br>';
    }
  }
  class Dog extends Animal {
    public static $live = "Alice's house";

    function __construct(string $name, int $age)
    {
      parent::__construct($name);
      $this->age = $age;
    }
    function express_abstract() {
      echo 'this method is override abstract <br>';
    }
    function get_parent_name () {
      echo parent::$live, '<br>';   // 親クラスのプロパティにアクセス
      echo parent::run();           // 親クラスの関数にアクセス
    }
    function get_age() {
      echo $this->age, '<br>';
    }
  }
  $pochi = new Dog('pochi', 2);
  $pochi->get_name()->express_abstract();
  $pochi->get_parent_name();
  $pochi->get_age();
?> -->