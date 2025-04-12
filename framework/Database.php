<?php

namespace Framework;
use mysqli, Exception;

class Database
{
  public $conn;

  /**
   * Constructor for database class
   *
   * @param array $config - Database and connection config
   */
  public function __construct(array $config)
  {
    try {
      $this->conn = new mysqli(
        $config['host'],
        $config['username'],
        $config['password'],
        $config['dbName'],
        $config['port']
      );

      // Check for connection errors
      if ($this->conn->connect_error) {
        throw new Exception("Database connection failed: " . $this->conn->connect_error);
      }

      // Set error mode to exception
      $this->conn->set_charset("utf8mb4");
    } catch (Exception $e) {
      throw new Exception("Database connection failed: " . $e->getMessage());
    }
  }

  /**
   * Query on the database
   * 
   * @param string $query 
   * @param array $params - parameters that are going to be passed through execution
   * @return mysqli_result
   * @throws Exception
   */
  public function query(string $query, array $params = [])
  {
    try {
      // Prepare the statement
      $statement = $this->conn->prepare($query);

      if (!$statement) {
        throw new Exception("Query preparation failed: " . $this->conn->error);
      }

      // Bind parameters if any
      if (!empty($params)) {
        $types = '';
        $bindParams = [];

        // Determine the types of the parameters
        foreach ($params as $param) {
          if (is_int($param)) {
            $types .= 'i'; // integer
          } elseif (is_float($param)) {
            $types .= 'd'; // double
          } elseif (is_string($param)) {
            $types .= 's'; // string
          } else {
            $types .= 'b'; // blob
          }
          $bindParams[] = $param;
        }

        // Bind the parameters
        $statement->bind_param($types, ...$bindParams);
      }

      // Execute the statement
      $statement->execute();

      // Get the result
      $result = $statement->get_result();

      // Return the result
      return $result;
    } catch (Exception $e) {
      throw new Exception("Query failed to execute: " . $e->getMessage());
    }
  }

  public function get_last_inserted_id(): string|int
  {
    return mysqli_insert_id($this->conn);
  }

  public function fetch_all_as_object(string $query, array $params = []): array
  {
    $result = $this->query($query, $params);
    $objects = [];

    while ($row = $result->fetch_object()) {
      $objects[] = $row;
    }

    return $objects;
  }
}