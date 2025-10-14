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
    
    // ==================== LICENSED JOBS METHODS ====================
    
    /**
     * Get all licensed jobs from the database
     * @return array Array of licensed job records
     * @throws Exception If query fails
     */
    public function getLicensedJobs() {
        try {
            $sql = "SELECT * FROM licensed_jobs";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Error fetching licensed jobs: " . $e->getMessage());
        }
    }
    
    /**
     * Get licensed jobs by specific criteria
     * @param array $criteria Array of field => value pairs for filtering
     * @return array Array of filtered licensed job records
     */
    public function getLicensedJobsByCriteria($criteria = []) {
        try {
            $sql = "SELECT * FROM licensed_jobs";
            $conditions = [];
            $params = [];
            
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
            throw new Exception("Error fetching licensed jobs by criteria: " . $e->getMessage());
        }
    }
    
    /**
     * Get licensed job by ID
     * @param int $id Job ID
     * @return array|null Job record or null if not found
     */
    public function getLicensedJobById($id) {
        try {
            $sql = "SELECT * FROM licensed_jobs WHERE id = :id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':id' => $id]);
            
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Error fetching licensed job by ID: " . $e->getMessage());
        }
    }
    
    /**
     * Get count of licensed jobs
     * @return int Total number of licensed jobs
     */
    public function getLicensedJobsCount() {
        try {
            $sql = "SELECT COUNT(*) as total FROM licensed_jobs";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return (int) $result['total'];
        } catch (PDOException $e) {
            throw new Exception("Error counting licensed jobs: " . $e->getMessage());
        }
    }
    
    // ==================== SUPPORT JOBS METHODS ====================
    
    /**
     * Get all support jobs from the database
     * @return array Array of support job records
     * @throws Exception If query fails
     */
    public function getSupportJobs() {
        try {
            $sql = "SELECT * FROM support_jobs";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Error fetching support jobs: " . $e->getMessage());
        }
    }
    
    /**
     * Get support jobs by specific criteria
     * @param array $criteria Array of field => value pairs for filtering
     * @return array Array of filtered support job records
     */
    public function getSupportJobsByCriteria($criteria = []) {
        try {
            $sql = "SELECT * FROM support_jobs";
            $conditions = [];
            $params = [];
            
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
            throw new Exception("Error fetching support jobs by criteria: " . $e->getMessage());
        }
    }
    
    /**
     * Get support job by ID
     * @param int $id Job ID
     * @return array|null Job record or null if not found
     */
    public function getSupportJobById($id) {
        try {
            $sql = "SELECT * FROM support_jobs WHERE id = :id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':id' => $id]);
            
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Error fetching support job by ID: " . $e->getMessage());
        }
    }
    
    /**
     * Get count of support jobs
     * @return int Total number of support jobs
     */
    public function getSupportJobsCount() {
        try {
            $sql = "SELECT COUNT(*) as total FROM support_jobs";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return (int) $result['total'];
        } catch (PDOException $e) {
            throw new Exception("Error counting support jobs: " . $e->getMessage());
        }
    }
    
    // ==================== COMBINED METHODS ====================
    
    /**
     * Get all jobs from all tables
     * @return array Array with separate arrays for each job type
     */
    public function getAllJobs() {
        try {
            return [
                'administration' => $this->getAdminJobs(),
                'licensed' => $this->getLicensedJobs(),
                'support' => $this->getSupportJobs()
            ];
        } catch (Exception $e) {
            throw new Exception("Error fetching all jobs: " . $e->getMessage());
        }
    }
    
    /**
     * Get total count of all jobs across all tables
     * @return array Array with counts for each job type and total
     */
    public function getAllJobsCounts() {
        try {
            $adminCount = $this->getAdminJobsCount();
            $licensedCount = $this->getLicensedJobsCount();
            $supportCount = $this->getSupportJobsCount();
            
            return [
                'administration' => $adminCount,
                'licensed' => $licensedCount,
                'support' => $supportCount,
                'total' => $adminCount + $licensedCount + $supportCount
            ];
        } catch (Exception $e) {
            throw new Exception("Error counting all jobs: " . $e->getMessage());
        }
    }
    
    /**
     * Search across all job tables in all fields except filename
     * @param string $searchTerm Search term to look for across all job fields
     * @return array Array with search results from all tables
     */
    public function searchAllJobs($searchTerm) {
        try {
            $searchParam = '%' . $searchTerm . '%';
            $results = [];
            
            // Search administration jobs (all fields except filename)
            $sql = "SELECT *, 'administration' as job_type FROM administration_jobs WHERE 
                    title LIKE :search OR 
                    grade LIKE :search OR 
                    ccode LIKE :search OR 
                    division LIKE :search OR 
                    description LIKE :search";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':search' => $searchParam]);
            $results['administration'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            // Search licensed jobs (all fields except filename)
            $sql = "SELECT *, 'licensed' as job_type FROM licensed_jobs WHERE 
                    title LIKE :search OR 
                    job_id LIKE :search OR 
                    category LIKE :search OR 
                    division LIKE :search OR 
                    certification_type LIKE :search OR 
                    active LIKE :search OR 
                    salary_code LIKE :search";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':search' => $searchParam]);
            $results['licensed'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            // Search support jobs (all fields except filename)
            $sql = "SELECT *, 'support' as job_type FROM support_jobs WHERE 
                    title LIKE :search OR 
                    grade LIKE :search OR 
                    job_code LIKE :search OR 
                    department_code LIKE :search OR 
                    union_code LIKE :search";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':search' => $searchParam]);
            $results['support'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            return $results;
        } catch (PDOException $e) {
            throw new Exception("Error searching jobs: " . $e->getMessage());
        }
    }
    
    /**
     * Get unique values for filter dropdowns
     * @return array Array with unique values for grades, codes, and divisions
     */
    public function getFilterOptions() {
        try {
            $options = [
                'grades' => [],
                'codes' => [],
                'divisions' => []
            ];
            
            // Get unique grades from admin and support jobs
            $sql = "SELECT DISTINCT grade FROM administration_jobs WHERE grade IS NOT NULL AND grade != '' 
                    UNION 
                    SELECT DISTINCT grade FROM support_jobs WHERE grade IS NOT NULL AND grade != '' 
                    ORDER BY grade";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            $options['grades'] = $stmt->fetchAll(PDO::FETCH_COLUMN);
            
            // Get unique codes from admin jobs (ccode), licensed jobs (job_code via job_id), and support jobs (job_code)
            $sql = "SELECT DISTINCT ccode as code FROM administration_jobs WHERE ccode IS NOT NULL AND ccode != '' 
                    UNION 
                    SELECT DISTINCT job_id as code FROM licensed_jobs WHERE job_id IS NOT NULL AND job_id != '' 
                    UNION 
                    SELECT DISTINCT job_code as code FROM support_jobs WHERE job_code IS NOT NULL AND job_code != '' 
                    ORDER BY code";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            $options['codes'] = $stmt->fetchAll(PDO::FETCH_COLUMN);
            
            // Get unique divisions from all job types
            $sql = "SELECT DISTINCT division FROM administration_jobs WHERE division IS NOT NULL AND division != '' 
                    UNION 
                    SELECT DISTINCT division FROM licensed_jobs WHERE division IS NOT NULL AND division != '' 
                    ORDER BY division";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            $options['divisions'] = $stmt->fetchAll(PDO::FETCH_COLUMN);
            
            return $options;
        } catch (PDOException $e) {
            throw new Exception("Error getting filter options: " . $e->getMessage());
        }
    }
}

?>