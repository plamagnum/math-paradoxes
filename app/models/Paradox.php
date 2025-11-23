<?php

require_once __DIR__ . '/../config/Database.php';

class Paradox {
    private $db;
    private $collection = 'paradoxes';

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function findAll($sortOrder = ['order' => 1]) {
        $cursor = $this->db->executeQuery($this->collection, [], ['sort' => $sortOrder]);
        return iterator_to_array($cursor);
    }

    public function findById($id) {
        $filter = ['_id' => new MongoDB\BSON\ObjectId($id)];
        $cursor = $this->db->executeQuery($this->collection, $filter);
        
        foreach ($cursor as $document) {
            return $document;
        }
        return null;
    }

    public function create($title, $description, $content, $order = 0) {
        $bulk = new MongoDB\Driver\BulkWrite;
        $bulk->insert([
            'title' => $title,
            'description' => $description,
            'content' => $content,
            'order' => (int)$order,
            'created_at' => new MongoDB\BSON\UTCDateTime()
        ]);
        
        try {
            $result = $this->db->executeBulkWrite($this->collection, $bulk);
            return $result->getInsertedCount() > 0;
        } catch (Exception $e) {
            return false;
        }
    }

    public function update($id, $title, $description, $content, $order = 0) {
        $bulk = new MongoDB\Driver\BulkWrite;
        $bulk->update(
            ['_id' => new MongoDB\BSON\ObjectId($id)],
            ['$set' => [
                'title' => $title,
                'description' => $description,
                'content' => $content,
                'order' => (int)$order,
                'updated_at' => new MongoDB\BSON\UTCDateTime()
            ]]
        );
        
        try {
            $result = $this->db->executeBulkWrite($this->collection, $bulk);
            return $result->getModifiedCount() > 0 || $result->getMatchedCount() > 0;
        } catch (Exception $e) {
            return false;
        }
    }

    public function delete($id) {
        $bulk = new MongoDB\Driver\BulkWrite;
        $bulk->delete(['_id' => new MongoDB\BSON\ObjectId($id)]);
        
        try {
            $result = $this->db->executeBulkWrite($this->collection, $bulk);
            return $result->getDeletedCount() > 0;
        } catch (Exception $e) {
            return false;
        }
    }

    public function count() {
        $command = new MongoDB\Driver\Command([
            'count' => $this->collection
        ]);
        
        try {
            $cursor = $this->db->executeCommand($command);
            $result = current($cursor->toArray());
            return $result->n ?? 0;
        } catch (Exception $e) {
            return 0;
        }
    }
}
