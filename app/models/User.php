<?php

require_once __DIR__ . '/../config/Database.php';

class User {
    private $db;
    private $collection = 'users';

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function findByUsername($username) {
        $filter = ['username' => $username];
        $cursor = $this->db->executeQuery($this->collection, $filter);
        
        foreach ($cursor as $document) {
            return $document;
        }
        return null;
    }

    public function findById($id) {
        $filter = ['_id' => new MongoDB\BSON\ObjectId($id)];
        $cursor = $this->db->executeQuery($this->collection, $filter);
        
        foreach ($cursor as $document) {
            return $document;
        }
        return null;
    }

    public function findAll() {
        $cursor = $this->db->executeQuery($this->collection, []);
        return iterator_to_array($cursor);
    }

    public function create($username, $password, $role = 'admin') {
        $bulk = new MongoDB\Driver\BulkWrite;
        $bulk->insert([
            'username' => $username,
            'password' => password_hash($password, PASSWORD_BCRYPT),
            'role' => $role,
            'created_at' => new MongoDB\BSON\UTCDateTime()
        ]);
        
        try {
            $result = $this->db->executeBulkWrite($this->collection, $bulk);
            return $result->getInsertedCount() > 0;
        } catch (Exception $e) {
            return false;
        }
    }

    public function update($id, $username, $password = null, $role = 'admin') {
        $bulk = new MongoDB\Driver\BulkWrite;
        
        $updateData = [
            'username' => $username,
            'role' => $role,
            'updated_at' => new MongoDB\BSON\UTCDateTime()
        ];
        
        if ($password !== null && $password !== '') {
            $updateData['password'] = password_hash($password, PASSWORD_BCRYPT);
        }
        
        $bulk->update(
            ['_id' => new MongoDB\BSON\ObjectId($id)],
            ['$set' => $updateData]
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

    public function verifyPassword($username, $password) {
        $user = $this->findByUsername($username);
        if ($user && isset($user->password)) {
            return password_verify($password, $user->password);
        }
        return false;
    }
}
