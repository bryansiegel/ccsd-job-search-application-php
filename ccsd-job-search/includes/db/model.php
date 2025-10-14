<?php

class JobModel {
    private $pdo;
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    
    /**
     * Get all administration jobs from the database
     * @return array Array of administration job records
     * @throws Exception If query fails
     */
    public function getAdminJobs() {
        try {
            // Query to get all records from administration_jobs table
            $sql = "SELECT * FROM administration_jobs";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            
            // Fetch all results
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Error fetching administration jobs: " . $e->getMessage());
        }
    }
    
    /**
     * Get administration jobs by specific criteria
     * @param array $criteria Array of field => value pairs for filtering
     * @return array Array of filtered administration job records
     */
    public function getAdminJobsByCriteria($criteria = []) {
        try {
            $sql = "SELECT * FROM administration_jobs";
            $conditions = [];
            $params = [];
            
            // Build WHERE clause if criteria provided
            if (!empty($criteria)) {
                foreach ($criteria as $field => $value) {
                    $conditions[] = "$field = :$field";
                    $params[":$field"] = $value;
                }
                $sql .= " WHERE " . implode(" AND ", $conditions);
            }
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Error fetching administration jobs by criteria: " . $e->getMessage());
        }
    }
    
    /**
     * Get administration job by ID
     * @param int $id Job ID
     * @return array|null Job record or null if not found
     */
    public function getAdminJobById($id) {
        try {
            $sql = "SELECT * FROM administration_jobs WHERE id = :id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':id' => $id]);
            
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Error fetching administration job by ID: " . $e->getMessage());
        }
    }
    
    /**
     * Get count of administration jobs
     * @return int Total number of administration jobs
     */
    public function getAdminJobsCount() {
        try {
            $sql = "SELECT COUNT(*) as total FROM administration_jobs";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return (int) $result['total'];
        } catch (PDOException $e) {
            throw new Exception("Error counting administration jobs: " . $e->getMessage());
        }
    }
}

?>