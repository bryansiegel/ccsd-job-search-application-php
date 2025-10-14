<?php
// Include MySQL connection and model
require_once 'includes/db/mysql-connect.php';
require_once 'includes/db/model.php';

try {
    // Create model instance
    $jobModel = new JobModel($pdo);
    
    // Handle search and filter
    $searchTerm = isset($_GET['search']) ? trim($_GET['search']) : '';
    $filterType = isset($_GET['filter']) ? $_GET['filter'] : 'all';
    $filterGrade = isset($_GET['grade']) ? $_GET['grade'] : '';
    $filterCode = isset($_GET['code']) ? $_GET['code'] : '';
    $filterDivision = isset($_GET['division']) ? $_GET['division'] : '';
    
    // Get filter options
    $filterOptions = $jobModel->getFilterOptions();
    
    // Get jobs based on search/filter
    if (!empty($searchTerm)) {
        $allJobs = $jobModel->searchAllJobs($searchTerm);
    } else {
        $allJobs = $jobModel->getAllJobs();
    }
    
    // Apply job type filter if specified
    if ($filterType !== 'all') {
        $filteredJobs = [];
        $filteredJobs[$filterType] = isset($allJobs[$filterType]) ? $allJobs[$filterType] : [];
        $allJobs = $filteredJobs;
    }
    
    // Apply additional filters (grade, code, division)
    if (!empty($filterGrade) || !empty($filterCode) || !empty($filterDivision)) {
        foreach ($allJobs as $jobType => &$jobs) {
            $jobs = array_filter($jobs, function($job) use ($filterGrade, $filterCode, $filterDivision) {
                $gradeMatch = empty($filterGrade) || (isset($job['grade']) && $job['grade'] === $filterGrade);
                
                $codeMatch = empty($filterCode) || 
                           (isset($job['ccode']) && $job['ccode'] === $filterCode) ||
                           (isset($job['job_id']) && $job['job_id'] === $filterCode) ||
                           (isset($job['job_code']) && $job['job_code'] === $filterCode);
                
                $divisionMatch = empty($filterDivision) || (isset($job['division']) && $job['division'] === $filterDivision);
                
                return $gradeMatch && $codeMatch && $divisionMatch;
            });
        }
    }
    
    // Get total counts (always show full counts)
    $jobCounts = $jobModel->getAllJobsCounts();
    
    echo "<h1>CCSD Job Search Portal</h1>";
    
    echo "<div class='summary-stats'>";
    echo "<h2>Job Summary</h2>";
    
    // Show search/filter status
    if (!empty($searchTerm)) {
        echo "<p class='search-status'><strong>Search results for:</strong> \"" . htmlspecialchars($searchTerm) . "\"</p>";
    }
    if ($filterType !== 'all') {
        echo "<p class='filter-status'><strong>Filtered by:</strong> " . ucfirst($filterType) . " Jobs</p>";
    }
    
    // Calculate filtered counts
    $currentCounts = [
        'administration' => isset($allJobs['administration']) ? count($allJobs['administration']) : 0,
        'licensed' => isset($allJobs['licensed']) ? count($allJobs['licensed']) : 0,
        'support' => isset($allJobs['support']) ? count($allJobs['support']) : 0
    ];
    $currentTotal = $currentCounts['administration'] + $currentCounts['licensed'] + $currentCounts['support'];
    
    if (!empty($searchTerm) || $filterType !== 'all') {
        echo "<p><strong>Results Found:</strong></p>";
        if ($currentCounts['administration'] > 0) {
            echo "<p>Administration Jobs: " . $currentCounts['administration'] . "</p>";
        }
        if ($currentCounts['licensed'] > 0) {
            echo "<p>Licensed Jobs: " . $currentCounts['licensed'] . "</p>";
        }
        if ($currentCounts['support'] > 0) {
            echo "<p>Support Jobs: " . $currentCounts['support'] . "</p>";
        }
        echo "<p><strong>Total Results: " . $currentTotal . "</strong></p>";
        echo "<hr>";
        echo "<p><em>Total Available Jobs:</em></p>";
    }
    
    echo "<p><strong>Administration Jobs:</strong> " . $jobCounts['administration'] . "</p>";
    echo "<p><strong>Licensed Jobs:</strong> " . $jobCounts['licensed'] . "</p>";
    echo "<p><strong>Support Jobs:</strong> " . $jobCounts['support'] . "</p>";
    echo "<p><strong>Total Jobs:</strong> " . $jobCounts['total'] . "</p>";
    echo "</div>";
    
    // Search and Filter Form
    echo "<div class='search-filter-container'>";
    echo "<form method='GET' action='' class='search-form'>";
    echo "<div class='search-input-group'>";
    echo "<input type='text' name='search' placeholder='Search jobs by title, grade, division, code, etc...' value='" . htmlspecialchars($searchTerm) . "' class='search-input'>";
    echo "<button type='submit' class='search-btn'>Search</button>";
    echo "</div>";
    echo "<div class='filter-group'>";
    echo "<label for='filter'>Filter by type:</label>";
    echo "<select name='filter' id='filter' class='filter-select'>";
    echo "<option value='all'" . ($filterType === 'all' ? ' selected' : '') . ">All Jobs</option>";
    echo "<option value='administration'" . ($filterType === 'administration' ? ' selected' : '') . ">Administration</option>";
    echo "<option value='licensed'" . ($filterType === 'licensed' ? ' selected' : '') . ">Licensed</option>";
    echo "<option value='support'" . ($filterType === 'support' ? ' selected' : '') . ">Support</option>";
    echo "</select>";
    echo "</div>";
    
    echo "<div class='filter-group'>";
    echo "<label for='grade'>Filter by grade:</label>";
    echo "<select name='grade' id='grade' class='filter-select'>";
    echo "<option value=''>All Grades</option>";
    foreach ($filterOptions['grades'] as $grade) {
        $selected = ($filterGrade === $grade) ? ' selected' : '';
        echo "<option value='" . htmlspecialchars($grade) . "'" . $selected . ">" . htmlspecialchars($grade) . "</option>";
    }
    echo "</select>";
    echo "</div>";
    
    echo "<div class='filter-group'>";
    echo "<label for='code'>Filter by code:</label>";
    echo "<select name='code' id='code' class='filter-select'>";
    echo "<option value=''>All Codes</option>";
    foreach ($filterOptions['codes'] as $code) {
        $selected = ($filterCode === $code) ? ' selected' : '';
        echo "<option value='" . htmlspecialchars($code) . "'" . $selected . ">" . htmlspecialchars($code) . "</option>";
    }
    echo "</select>";
    echo "</div>";
    
    echo "<div class='filter-group'>";
    echo "<label for='division'>Filter by division:</label>";
    echo "<select name='division' id='division' class='filter-select'>";
    echo "<option value=''>All Divisions</option>";
    foreach ($filterOptions['divisions'] as $division) {
        $selected = ($filterDivision === $division) ? ' selected' : '';
        echo "<option value='" . htmlspecialchars($division) . "'" . $selected . ">" . htmlspecialchars($division) . "</option>";
    }
    echo "</select>";
    echo "</div>";
    
    if (!empty($searchTerm) || $filterType !== 'all' || !empty($filterGrade) || !empty($filterCode) || !empty($filterDivision)) {
        echo "<a href='index.php' class='clear-filters'>Clear Filters</a>";
    }
    echo "</form>";
    echo "</div>";
    
    // Display Administration Jobs
    echo "<div class='job-section'>";
    echo "<h2>Administration Jobs</h2>";
    echo "<div class='jobs-container'>";
    foreach ($allJobs['administration'] as $job) {
        echo "<div class='job-item admin-job'>";
        echo "<h3>" . htmlspecialchars($job['title']) . "</h3>";
        echo "<p><strong>Grade:</strong> " . htmlspecialchars($job['grade']) . "</p>";
        echo "<p><strong>Code:</strong> " . htmlspecialchars($job['ccode']) . "</p>";
        echo "<p><strong>Division:</strong> " . htmlspecialchars($job['division']) . "</p>";
        echo "<p><strong>Description:</strong> " . htmlspecialchars($job['description']) . "</p>";
        if (!empty($job['filename'])) {
            echo "<p><strong>Filename:</strong> " . htmlspecialchars($job['filename']) . "</p>";
        }
        echo "<span class='job-type'>Administration</span>";
        echo "</div>";
    }
    echo "</div>";
    echo "</div>";
    
    // Display Licensed Jobs
    echo "<div class='job-section'>";
    echo "<h2>Licensed Jobs</h2>";
    echo "<div class='jobs-container'>";
    foreach ($allJobs['licensed'] as $job) {
        echo "<div class='job-item licensed-job'>";
        echo "<h3>" . htmlspecialchars($job['title']) . "</h3>";
        if (!empty($job['job_id'])) {
            echo "<p><strong>Job ID:</strong> " . htmlspecialchars($job['job_id']) . "</p>";
        }
        echo "<p><strong>Category:</strong> " . htmlspecialchars($job['category']) . "</p>";
        echo "<p><strong>Division:</strong> " . htmlspecialchars($job['division']) . "</p>";
        echo "<p><strong>Certification:</strong> " . htmlspecialchars($job['certification_type']) . "</p>";
        if (!empty($job['filename'])) {
            echo "<p><strong>Filename:</strong> " . htmlspecialchars($job['filename']) . "</p>";
        }
        if (!empty($job['salary_code'])) {
            echo "<p><strong>Salary Code:</strong> " . htmlspecialchars($job['salary_code']) . "</p>";
        }
        echo "<span class='job-type'>Licensed</span>";
        echo "</div>";
    }
    echo "</div>";
    echo "</div>";
    
    // Display Support Jobs
    echo "<div class='job-section'>";
    echo "<h2>Support Jobs</h2>";
    echo "<div class='jobs-container'>";
    foreach ($allJobs['support'] as $job) {
        echo "<div class='job-item support-job'>";
        echo "<h3>" . htmlspecialchars($job['title']) . "</h3>";
        if (!empty($job['grade'])) {
            echo "<p><strong>Grade:</strong> " . htmlspecialchars($job['grade']) . "</p>";
        }
        if (!empty($job['job_code'])) {
            echo "<p><strong>Job Code:</strong> " . htmlspecialchars($job['job_code']) . "</p>";
        }
        if (!empty($job['department_code'])) {
            echo "<p><strong>Department:</strong> " . htmlspecialchars($job['department_code']) . "</p>";
        }
        if (!empty($job['union_code'])) {
            echo "<p><strong>Union Code:</strong> " . htmlspecialchars($job['union_code']) . "</p>";
        }
        if (!empty($job['filename'])) {
            echo "<p><strong>Filename:</strong> " . htmlspecialchars($job['filename']) . "</p>";
        }
        echo "<span class='job-type'>Support</span>";
        echo "</div>";
    }
    echo "</div>";
    echo "</div>";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CCSD Job Search Portal</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <!-- Content is already echoed above -->
</body>
</html>
