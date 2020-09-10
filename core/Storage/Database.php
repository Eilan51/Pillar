<?php

namespace Core\Storage;

use PDO;

class Database {
  private $pdoInstance = null;

  public function __construct() {
    $config = database_config();

    if($config['db'] !== '') {
      $driver = $config['driver'];
      $dsn = $driver . ':';

      switch($driver) {
        case 'mysql':
          $dsn .= "dbname={$config['db']};host={$config['host']}";
          break;
        case 'sqlsrv':
          $dsn .= "Server={$config['host']},{$config['port']};Database={$config['db']}";
          break;
      }

      $this->pdoInstance = new PDO($dsn, $config['username'], $config['password']);
    }
  }

  public function query(string $sql, array $params = []): array {
    $statement = $this->pdoInstance->prepare($sql);
    $statement->execute($params);

    $errors = $statement->errorInfo();

    if(count($errors) > 3 && app()->config('env') === 'dev') {
      print_r(array_slice($errors, 2));
      die;
    }

    return $statement->fetchAll();
  }

  function raw(string $sql) {
    $query = $this->pdoInstance->query($sql);

    return $query->fetchAll();
  }

  public function escapeString($string) {
    return $this->pdoInstance->quote($string);
  }

  public function close() {
    $this->pdoInstance = null;
  }
}
