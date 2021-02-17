<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

  public function __construct(?string $name = null, array $data = [], string $dataName = '')
  {
    $this->hotfixSqlite();
    parent::__construct($name, $data, $dataName);
  }

  /**
   * Fix for: BadMethodCallException : SQLite doesn't support dropping foreign keys (you would need to re-create the table).
   */
  public function hotfixSqlite()
  {
    \Illuminate\Database\Connection::resolverFor('sqlite', function ($connection, $database, $prefix, $config) {
      return new class($connection, $database, $prefix, $config) extends \Illuminate\Database\SQLiteConnection
      {
        public function getSchemaBuilder()
        {
          if ($this->schemaGrammar === null) {
            $this->useDefaultSchemaGrammar();
          }
          return new class($this) extends \Illuminate\Database\Schema\SQLiteBuilder
          {
            protected function createBlueprint($table, \Closure $callback = null)
            {
              return new class($table, $callback) extends \Illuminate\Database\Schema\Blueprint
              {
                public function dropForeign($index)
                {
                  return new \Illuminate\Support\Fluent();
                }
              };
            }
          };
        }
      };
    });
  }
}
