<?php

class Database {
    private static $instance = null;
    private $client;
    private $db;

    private function __construct() {
        $host = getenv('MONGODB_HOST') ?: 'mongodb';
        $port = getenv('MONGODB_PORT') ?: '27017';
        $database = getenv('MONGODB_DATABASE') ?: 'math_paradoxes';
        
        try {
            $this->client = new MongoDB\Driver\Manager("mongodb://{$host}:{$port}");
            $this->db = $database;
        } catch (Exception $e) {
            die("MongoDB Connection Error: " . $e->getMessage());
        }
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getClient() {
        return $this->client;
    }

    public function getDatabase() {
        return $this->db;
    }

    public function executeQuery($collection, $filter = [], $options = []) {
        $query = new MongoDB\Driver\Query($filter, $options);
        return $this->client->executeQuery("{$this->db}.{$collection}", $query);
    }

    public function executeBulkWrite($collection, $bulk) {
        return $this->client->executeBulkWrite("{$this->db}.{$collection}", $bulk);
    }

    public function executeCommand($command) {
        return $this->client->executeCommand($this->db, $command);
    }
}
