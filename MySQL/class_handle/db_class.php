<?php
namespace db;

use PDO;

class DataSource {

  private $conn;
  private $sqlResult;
  public const CLS = 'class';

  public function __construct($username = 'test_user', $password ='pwd', $host = 'localhost', $port = '8889', $dbName = 'test_phpdb')
  {
    $dsn = "mysql:host={$host};port={$port};dbname={$dbName};";
    $this->conn = new PDO($dsn, $username, $password);
    $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $this->conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
  }

  public function select($sql = "", $params = [], $type = '', $class = '')    // レコードの取得       ＄typeで連想配列とクラスのどちらを使うか決める。
  {
    $stmt = $this->executeSql($sql, $params);
    if ($type === static::CLS) {   // static::CLS は 静的プロパティのCLS
      return $stmt->fetchAll(PDO::FETCH_CLASS, $class);    // '\model\ProductModel' の インスタンスを返す   https://www.php.net/manual/ja/pdostatement.fetchall.php
    } else {
      return $stmt->fetchAll();
    }
  }
  public function execute($sql = "", $params = [])   // レコードの更新
  {
    $this->executeSql($sql, $params);
    return $this->sqlResult;
  }

  public function selectOne($sql = "", $params = [], $type = '', $class = '')
  {
    $result = $this->select($sql, $params, $type, $class);
    return count($result) > 0 ? $result[0] : false;
  }

  public function begin_transaction()
  {
    $this->conn->beginTransaction();
  }

  public function commit()
  {
    $this->conn->commit();
  }

  public function rollback()
  {
    $this->conn->rollback();
  }

  private function executeSql($sql, $params) {   // sqlを実行する関数
    $stmt = $this->conn->prepare($sql);
    $this->sqlResult = $stmt->execute($params);  // sqlResultプロパティにsql実行後に変更されたレコードの数を格納し、execute関数でsqlResultプロパティを参照可能にする。
    // echo "sqlResult : {$this->sqlResult}". '<br>';
    return $stmt;                                // select関数の処理で返り値が必要
  }
}
?>