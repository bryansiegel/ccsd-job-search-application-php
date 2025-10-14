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
    
    // Initialize empty arrays for job types that don't exist
    if (!isset($allJobs['administration'])) $allJobs['administration'] = [];
    if (!isset($allJobs['licensed'])) $allJobs['licensed'] = [];
    if (!isset($allJobs['support'])) $allJobs['support'] = [];
    
    // Apply job type filter if specified (keep all arrays but filter content)
    if ($filterType !== 'all') {
        $tempJobs = $allJobs;
        $allJobs = [
            'administration' => [],
            'licensed' => [],
            'support' => []
        ];
        $allJobs[$filterType] = isset($tempJobs[$filterType]) ? $tempJobs[$filterType] : [];
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
    
} catch (Exception $e) {
    $error = "Error: " . $e->getMessage();
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
<div style="margin-left:100px; margin-right: 100px;">
<?php if (isset($error)): ?>
        <div style="color: red; text-align: center; margin: 20px;">
            <?php echo $error; ?>
        </div>
    <?php else: ?>

    
    <h1>CCSD Job Search Portal</h1>
    
    <div class='summary-stats'>
        <h2>Job Summary</h2>
        
        <?php
        // Show search/filter status
        if (!empty($searchTerm)): ?>
            <p class='search-status'><strong>Search results for:</strong> "<?php echo htmlspecialchars($searchTerm); ?>"</p>
        <?php endif; ?>
        
        <?php if ($filterType !== 'all'): ?>
            <p class='filter-status'><strong>Filtered by:</strong> <?php echo ucfirst($filterType); ?> Jobs</p>
        <?php endif; ?>
        
        <?php
        // Calculate filtered counts
        $currentCounts = [
            'administration' => isset($allJobs['administration']) ? count($allJobs['administration']) : 0,
            'licensed' => isset($allJobs['licensed']) ? count($allJobs['licensed']) : 0,
            'support' => isset($allJobs['support']) ? count($allJobs['support']) : 0
        ];
        $currentTotal = $currentCounts['administration'] + $currentCounts['licensed'] + $currentCounts['support'];
        
        if (!empty($searchTerm) || $filterType !== 'all' || !empty($filterGrade) || !empty($filterCode) || !empty($filterDivision)): ?>
            <p><strong>Results Found:</strong></p>
            <?php if ($currentCounts['administration'] > 0): ?>
                <p>Administration Jobs: <?php echo $currentCounts['administration']; ?></p>
            <?php endif; ?>
            <?php if ($currentCounts['licensed'] > 0): ?>
                <p>Licensed Jobs: <?php echo $currentCounts['licensed']; ?></p>
            <?php endif; ?>
            <?php if ($currentCounts['support'] > 0): ?>
                <p>Support Jobs: <?php echo $currentCounts['support']; ?></p>
            <?php endif; ?>
            <p><strong>Total Results: <?php echo $currentTotal; ?></strong></p>
            <hr>
            <p><em>Total Available Jobs:</em></p>
        <?php endif; ?>
        
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-number"><?php echo $jobCounts['administration']; ?></div>
                <p class="stat-label">Administration Jobs</p>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?php echo $jobCounts['licensed']; ?></div>
                <p class="stat-label">Licensed Jobs</p>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?php echo $jobCounts['support']; ?></div>
                <p class="stat-label">Support Jobs</p>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?php echo $jobCounts['total']; ?></div>
                <p class="stat-label">Total Jobs</p>
            </div>
        </div>
    </div>
    
    <!-- Search and Filter Form -->
    <div class='search-filter-container'>
        <form method='GET' action='' class='search-form'>
            <div class='search-input-group'>
                <input type='text' name='search' placeholder='Search jobs by title, grade, division, code, etc...' value='<?php echo htmlspecialchars($searchTerm); ?>' class='search-input'>
            </div>
            
            <div class='filter-group'>
                <label for='filter'>Filter by type:</label>
                <select name='filter' id='filter' class='filter-select'>
                    <option value='all'<?php echo ($filterType === 'all' ? ' selected' : ''); ?>>All Jobs</option>
                    <option value='administration'<?php echo ($filterType === 'administration' ? ' selected' : ''); ?>>Administration</option>
                    <option value='licensed'<?php echo ($filterType === 'licensed' ? ' selected' : ''); ?>>Licensed</option>
                    <option value='support'<?php echo ($filterType === 'support' ? ' selected' : ''); ?>>Support</option>
                </select>
            </div>
            
            <div class='filter-group'>
                <label for='grade'>Filter by grade:</label>
                <select name='grade' id='grade' class='filter-select'>
                    <option value=''>All Grades</option>
                    <?php foreach ($filterOptions['grades'] as $grade): ?>
                        <option value='<?php echo htmlspecialchars($grade); ?>'<?php echo ($filterGrade === $grade) ? ' selected' : ''; ?>><?php echo htmlspecialchars($grade); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class='filter-group'>
                <label for='code'>Filter by code:</label>
                <select name='code' id='code' class='filter-select'>
                    <option value=''>All Codes</option>
                    <?php foreach ($filterOptions['codes'] as $code): ?>
                        <option value='<?php echo htmlspecialchars($code); ?>'<?php echo ($filterCode === $code) ? ' selected' : ''; ?>><?php echo htmlspecialchars($code); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class='filter-group'>
                <label for='division'>Filter by division:</label>
                <select name='division' id='division' class='filter-select'>
                    <option value=''>All Divisions</option>
                    <?php foreach ($filterOptions['divisions'] as $division): ?>
                        <option value='<?php echo htmlspecialchars($division); ?>'<?php echo ($filterDivision === $division) ? ' selected' : ''; ?>><?php echo htmlspecialchars($division); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class='button-group'>
                <button type='submit' class='search-btn'>Search</button>
                <?php if (!empty($searchTerm) || $filterType !== 'all' || !empty($filterGrade) || !empty($filterCode) || !empty($filterDivision)): ?>
                    <a href='index.php' class='clear-filters'>Clear Filters</a>
                <?php endif; ?>
            </div>
        </form>
    </div>
    
    <!-- Tabs for job results -->
    <div class='tabs-container'>
        <div class='tabs-nav'>
            <button class='tab-btn active' data-tab='administration'>Administration Jobs (<?php echo count($allJobs['administration']); ?>)</button>
            <button class='tab-btn' data-tab='licensed'>Licensed Jobs (<?php echo count($allJobs['licensed']); ?>)</button>
            <button class='tab-btn' data-tab='support'>Support Jobs (<?php echo count($allJobs['support']); ?>)</button>
        </div>
        
        <!-- Administration Jobs Tab -->
        <div class='tab-content active' id='administration-tab'>
            <div class='jobs-container'>
                <?php foreach ($allJobs['administration'] as $job): ?>
                    <div class='job-item admin-job'>
                        <h3><?php echo htmlspecialchars($job['title']); ?></h3>
                        <p><strong>Grade:</strong> <?php echo htmlspecialchars($job['grade']); ?></p>
                        <p><strong>Code:</strong> <?php echo htmlspecialchars($job['ccode']); ?></p>
                        <p><strong>Division:</strong> <?php echo htmlspecialchars($job['division']); ?></p>
                        <p><strong>Description:</strong> <?php echo htmlspecialchars($job['description']); ?></p>
                        <?php if (!empty($job['filename'])): ?>
                            <p><strong>Filename:</strong> <?php echo htmlspecialchars($job['filename']); ?></p>
                        <?php endif; ?>
                        <span class='job-type'>Administration</span>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        
        <!-- Licensed Jobs Tab -->
        <div class='tab-content' id='licensed-tab'>
            <div class='jobs-container'>
                <?php foreach ($allJobs['licensed'] as $job): ?>
                    <div class='job-item licensed-job'>
                        <h3><?php echo htmlspecialchars($job['title']); ?></h3>
                        <?php if (!empty($job['job_id'])): ?>
                            <p><strong>Job ID:</strong> <?php echo htmlspecialchars($job['job_id']); ?></p>
                        <?php endif; ?>
                        <p><strong>Category:</strong> <?php echo htmlspecialchars($job['category']); ?></p>
                        <p><strong>Division:</strong> <?php echo htmlspecialchars($job['division']); ?></p>
                        <p><strong>Certification:</strong> <?php echo htmlspecialchars($job['certification_type']); ?></p>
                        <?php if (!empty($job['filename'])): ?>
                            <p><strong>Filename:</strong> <?php echo htmlspecialchars($job['filename']); ?></p>
                        <?php endif; ?>
                        <?php if (!empty($job['salary_code'])): ?>
                            <p><strong>Salary Code:</strong> <?php echo htmlspecialchars($job['salary_code']); ?></p>
                        <?php endif; ?>
                        <span class='job-type'>Licensed</span>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        
        <!-- Support Jobs Tab -->
        <div class='tab-content' id='support-tab'>
            <div class='jobs-container'>
                <?php foreach ($allJobs['support'] as $job): ?>
                    <div class='job-item support-job'>
                        <h3><?php echo htmlspecialchars($job['title']); ?></h3>
                        <?php if (!empty($job['grade'])): ?>
                            <p><strong>Grade:</strong> <?php echo htmlspecialchars($job['grade']); ?></p>
                        <?php endif; ?>
                        <?php if (!empty($job['job_code'])): ?>
                            <p><strong>Job Code:</strong> <?php echo htmlspecialchars($job['job_code']); ?></p>
                        <?php endif; ?>
                        <?php if (!empty($job['department_code'])): ?>
                            <p><strong>Department:</strong> <?php echo htmlspecialchars($job['department_code']); ?></p>
                        <?php endif; ?>
                        <?php if (!empty($job['union_code'])): ?>
                            <p><strong>Union Code:</strong> <?php echo htmlspecialchars($job['union_code']); ?></p>
                        <?php endif; ?>
                        <?php if (!empty($job['filename'])): ?>
                            <p><strong>Filename:</strong> <?php echo htmlspecialchars($job['filename']); ?></p>
                        <?php endif; ?>
                        <span class='job-type'>Support</span>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

</div>
    
    <?php endif; ?>
    
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const tabBtns = document.querySelectorAll('.tab-btn');
        const tabContents = document.querySelectorAll('.tab-content');
        
        tabBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                const targetTab = this.getAttribute('data-tab');
                
                // Remove active class from all buttons and contents
                tabBtns.forEach(b => b.classList.remove('active'));
                tabContents.forEach(c => c.classList.remove('active'));
                
                // Add active class to clicked button and corresponding content
                this.classList.add('active');
                document.getElementById(targetTab + '-tab').classList.add('active');
            });
        });
    });
    </script>
</body>
</html>
