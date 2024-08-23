<?php

namespace App\Core;

use \PDO;
use \PDOException;

class Database{

  /**
   * Host de conexão com o banco de dados
   * @var string
   */
  private static $host;

  /**
   * Nome do banco de dados
   * @var string
   */
  private static $name;

  /**
   * Usuário do banco
   * @var string
   */
  private static $user;

  /**
   * Senha de acesso ao banco de dados
   * @var string
   */
  private static $pass;

  /**
   * Porta de acesso ao banco
   * @var integer
   */
  private static $port;

  /**
   * Nome da tabela a ser manipulada
   * @var string
   */
  private $table;

  /**
   * Instancia de conexão com o banco de dados
   * @var PDO
   */
  private $connection;

  /**
   * Método responsável por configurar a classe
   * @param  string  $host
   * @param  string  $name
   * @param  string  $user
   * @param  string  $pass
   * @param  integer $port
   */
  public static function config($host,$name,$user,$pass,$port = 3306){
    self::$host = $host;
    self::$name = $name;
    self::$user = $user;
    self::$pass = $pass;
    self::$port = $port;
  }

  /**
   * Define a tabela e instancia e conexão
   * @param string $table
   */
  public function __construct($table = null){
    $this->table = $table;
    $this->setConnection();
  }

  /**
   * Método responsável por criar uma conexão com o banco de dados
   */
  private function setConnection(){

    if($this->connection instanceof PDO) {
      return true;
    }

    try{
      $this->connection = new PDO('mysql:host='.self::$host.';dbname='.self::$name.';port='.self::$port.';charset=utf8',self::$user,self::$pass);
      $this->connection->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
      
    }catch(PDOException $e){
      echo '<pre>'; print_r($e); echo '</pre>';exit;
      die('ERROR: '.$e->getMessage());
    }
  }

    /**
   * Método responsável por executar queries dentro do banco de dados
   * @param  string $query
   * @param  array  $params
   * @return PDOStatement
   */
  public function query($query,$params = []){
    return $this->execute($query, $params);
  }

  /**
   * Método responsável por executar queries dentro do banco de dados
   * @param  string $query
   * @param  array  $params
   * @return PDOStatement
   */
  private function execute($query,$params = []){

    $query = $this->slugQuery($query);
    try{
      $statement = $this->connection->prepare($query);
      $statement->execute($params);
      return $statement;
    }catch(PDOException $e){
      die('ERROR: '.$e->getMessage());
    }
  }

  /**
   * Reponsável por normatizar a query
   * @method slugQuery
   * @param string $query
   *
   */
  public function slugQuery($query){
    $query = trim($query);
    $query = preg_replace("/[\\\\]+\'/",'\\\'',$query);
    return $query;
  }

  /**
   * Método responsável por inserir dados no banco
   * @param  array $values [ field => value ]
   * @return integer ID inserido
   */
  public function insert($dados = null, $ignore = false, $camposSemAspas = []) {
    if (is_object($dados)) {
      if (method_exists($dados, 'getAllAttributes')) {
        $dados = $dados->getAllAttributes(true);
      } else {
        return false;
      }
    }

    $valores = [];
    foreach ($dados as $key => $value) {
      $valores[":{$key}"] = $value;
    }

    $campos  = implode('`,`', array_keys($dados));
    $binds   = implode(', ', array_keys($valores));
    $ignore  = $ignore ? ' IGNORE ' : '';
    $query   = "INSERT " . $ignore . " INTO " . $this->table . " (`" . $campos . "`) VALUES (" . $binds . ")";

    return $this->execute($query, $valores);
  }

  /**
   * Método responsável por executar uma consulta no banco
   * @param  string $where
   * @param  string $order
   * @param  string $limit
   * @param  string $fields
   * @return PDOStatement
   */
  public function select($where = null, $order = null, $limit = null, $fields = '*'){
    //DADOS DA QUERY
    $where = ($where) ? 'WHERE '.$where : '';
    $order = ($order) ? 'ORDER BY '.$order : '';
    $limit = ($limit) ? 'LIMIT '.$limit : '';

    //MONTA A QUERY
    $query = 'SELECT '.$fields.' FROM '.$this->table.' '.$where.' '.$order.' '.$limit;

    //EXECUTA A QUERY
    return $this->execute($query);
  }

  /**
   * Método responsável por executar atualizações no banco de dados
   * @param  string $where
   * @param  array $values [ field => value ]
   * @return boolean
   */
  public function update($where = null, $bindWhere = [], $dados = null, $camposSemAspas = []) {
    if (!is_null($where) and !is_numeric(trim($where))) {
      if (is_object($dados)) {
        if (method_exists($dados, 'getAllAttributes')) {
          $dados = $dados->getAllAttributes(true);
        } else {
          return false;
        }
      }

      $valores = [];
      foreach ($dados as $key => $value) {
        $campo           = ":{$key}";
        $valores[$campo] = $value;
        $binds[]         = "`" . $key . "`= :" . $key;
      }

      $binds = implode(',', $binds);
      $query = "UPDATE " . $this->table . " SET " . $binds . " WHERE " . $where;

      return $this->execute($query, array_merge($bindWhere, $valores));
    } else {
      return false;
    }
  }

  /**
   * Método responsável por excluir dados do banco
   * @param  string $where
   * @return boolean
   */
  public function delete($where = null, $binds = []) {
    if (!is_null($where) and !is_numeric(trim($where))) {
      $query = "DELETE FROM " . $this->table . " WHERE " . $where;
      return $this->execute($query, $binds);
    } else {
      return false;
    }
  }

}