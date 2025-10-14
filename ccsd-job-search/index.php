<?php
// Include MySQL connection and model
require_once 'includes/db/mysql-connect.php';
require_once 'includes/db/model.php';

try {
    // Create model instance
    $jobModel = new JobModel($pdo);
    
    // Get all administration jobs using the model
    $administration_jobs = $jobModel->getAdminJobs();
    
    echo "<h1>CCSD Administration Jobs</h1>";
    echo "<div class='jobs-container'>";
    
    // Loop through all administration jobs
    foreach ($administration_jobs as $job) {
        echo "<div class='job-item'>";
        echo "<h3>" . htmlspecialchars($job['title']) . "</h3>";
        echo "<p><strong>Grade:</strong> " . htmlspecialchars($job['grade']) . "</p>";
        echo "<p><strong>Code:</strong> " . htmlspecialchars($job['ccode']) . "</p>";
        echo "<p><strong>Division:</strong> " . htmlspecialchars($job['division']) . "</p>";
        echo "<p><strong>Description:</strong> " . htmlspecialchars($job['description']) . "</p>";
        if (!empty($job['filename'])) {
            echo "<p><strong>Filename:</strong> " . htmlspecialchars($job['filename']) . "</p>";
        }
        echo "</div><hr>";
    }
    
    echo "</div>";
    echo "<p>Total Administration Jobs: " . count($administration_jobs) . "</p>";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>

<style>
.jobs-container {
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
}

.job-item {
    background: #f5f5f5;
    padding: 15px;
    margin-bottom: 10px;
    border-radius: 5px;
}

.job-item h3 {
    color: #333;
    margin-top: 0;
}

.job-item p {
    margin: 5px 0;
}
</style>
