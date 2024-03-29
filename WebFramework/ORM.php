<?php

namespace WebFramework;

use \PDO;

class ORM {

  private $db;
  private $list;

  private static $instance = null;

  /**
   * Private constructor so nobody else can instantiate it.
   */
  private function __construct()
  {
    $this->list = [];
  }

  /**
   * Retrieve the static instance of the ORM.
   *
   * @return ORM - Instance of the ORM
   */
  public static function getInstance()
  {
      if (is_null(self::$instance)) {
          self::$instance = new ORM();
      }

      return self::$instance;
  }

  /**
   * Connect to a database.
   *
   * @param array $config - Database configuration
   * @return PDO - Instance of PDO used to interact with the connected DB.
   */
  public function connect(array $config)
  {
    try {
      $this->db = new PDO(
        "{$config['driver']}:host={$config['host']};dbname={$config['dbname']}",
        $config['username'],
        $config['password'],
        $config['options']
      );
      return $this->db;
    }
    catch (Exception $e) {
      echo $e->getMessage();
    }
  }

  public function getDb(){
    return $this->db;
  }

  /**
   * Make a model instance managed by the ORM.
   *
   * @param Model $object - Object that will be persisted.
   */
  public function persist($object)
  {
    // TODO: Implement this function
    array_push($this->list,$object);
    var_dump($this->list);
  }

  /**
   * Synchronize each managed models with the database.
   */
  public function flush()
  {
    // TODO: Implement this function
  }

  public function prepareRequest($model,$query,$field){
    $this->db->prepare($model->$query());
    foreach ($field as $value){
      $keyField = ucwords($value);
      $method = "get".$keyField;
      $values = $model->$method();
    };
    $field = [$value => $values];
    $request = $this->db->prepare($model->$query());
    $request->execute($field);
    return $request->fetchAll(PDO::FETCH_ASSOC);
  }
}