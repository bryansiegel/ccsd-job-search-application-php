<?php
// Database connection configuration
$host = 'localhost';
$dbname = 'ccsd_jobs_php';
$username = 'root'; // Adjust as needed
$password = 'advanced'; // Adjust as needed

try {
    // Create PDO connection
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Query to get all records from administration_jobs table
    $sql = "SELECT * FROM administration_jobs";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    
    // Fetch all results
    $administration_jobs = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
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
    
} catch (PDOException $e) {
    echo "Database Error: " . $e->getMessage();
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
