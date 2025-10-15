<?php
/**
 * Job Processing Utility Functions
 */

/**
 * Apply filters to job data
 * 
 * @param array $allJobs All jobs data
 * @param array $filters Filter parameters
 * @return array Filtered jobs data
 */
function applyJobFilters($allJobs, $filters) {
    $filterType = $filters['type'] ?? 'all';
    $filterGrade = $filters['grade'] ?? '';
    $filterCode = $filters['code'] ?? '';
    $filterDivision = $filters['division'] ?? '';
    
    // Initialize empty arrays for job types that don't exist
    if (!isset($allJobs['administration'])) $allJobs['administration'] = [];
    if (!isset($allJobs['licensed'])) $allJobs['licensed'] = [];
    if (!isset($allJobs['support'])) $allJobs['support'] = [];
    
    // Apply job type filter if specified
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
    
    return $allJobs;
}

/**
 * Calculate current job counts from filtered data
 * 
 * @param array $jobsData Filtered jobs data
 * @return array Current counts
 */
function calculateCurrentCounts($jobsData) {
    return [
        'administration' => isset($jobsData['administration']) ? count($jobsData['administration']) : 0,
        'licensed' => isset($jobsData['licensed']) ? count($jobsData['licensed']) : 0,
        'support' => isset($jobsData['support']) ? count($jobsData['support']) : 0
    ];
}

/**
 * Prepare search status array
 * 
 * @param array $params Request parameters
 * @return array Search status
 */
function prepareSearchStatus($params) {
    return [
        'search_term' => $params['search'] ?? '',
        'filter_type' => $params['filter'] ?? 'all',
        'filter_grade' => $params['grade'] ?? '',
        'filter_code' => $params['code'] ?? '',
        'filter_division' => $params['division'] ?? ''
    ];
}

/**
 * Sanitize and validate job data for database operations
 * 
 * @param array $data Raw form data
 * @param string $jobType Job type
 * @return array Sanitized data
 * @throws Exception If required fields are missing
 */
function sanitizeJobData($data, $jobType) {
    $sanitized = [];
    
    // Common required field
    if (empty($data['title'])) {
        throw new Exception("Job title is required.");
    }
    $sanitized['title'] = trim($data['title']);
    
    // Type-specific validation and sanitization
    switch ($jobType) {
        case 'administration':
            $requiredFields = ['grade', 'ccode', 'division', 'description'];
            foreach ($requiredFields as $field) {
                if (empty($data[$field])) {
                    throw new Exception(ucfirst($field) . " is required for administration jobs.");
                }
                $sanitized[$field] = trim($data[$field]);
            }
            break;
            
        case 'licensed':
            $requiredFields = ['job_id', 'category', 'division', 'certification_type'];
            foreach ($requiredFields as $field) {
                if (empty($data[$field])) {
                    throw new Exception(ucfirst(str_replace('_', ' ', $field)) . " is required for licensed jobs.");
                }
                $sanitized[$field] = trim($data[$field]);
            }
            
            // Optional fields
            // Convert Y/N to 1/0 for database integer field
            $activeValue = isset($data['active']) ? trim($data['active']) : 'Y';
            $sanitized['active'] = ($activeValue === 'Y') ? 1 : 0;
            $sanitized['salary_code'] = isset($data['salary_code']) ? trim($data['salary_code']) : null;
            break;
            
        case 'support':
            // Title is the only required field for support jobs
            // Optional fields
            $optionalFields = ['grade', 'job_code', 'department_code', 'union_code'];
            foreach ($optionalFields as $field) {
                $sanitized[$field] = isset($data[$field]) ? trim($data[$field]) : null;
            }
            break;
            
        default:
            throw new Exception("Invalid job type: " . $jobType);
    }
    
    return $sanitized;
}

/**
 * Get job type display name
 * 
 * @param string $jobType Job type
 * @return string Display name
 */
function getJobTypeDisplayName($jobType) {
    switch ($jobType) {
        case 'administration':
            return 'Administration';
        case 'licensed':
            return 'Licensed';
        case 'support':
            return 'Support';
        default:
            return ucfirst($jobType);
    }
}

/**
 * Get valid job types
 * 
 * @return array Valid job types
 */
function getValidJobTypes() {
    return ['administration', 'licensed', 'support'];
}