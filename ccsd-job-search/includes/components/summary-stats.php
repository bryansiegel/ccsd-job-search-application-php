<?php
/**
 * Summary Statistics Component
 * Renders job count statistics with search/filter status
 * 
 * @param array $job_counts Total job counts ['administration' => int, 'licensed' => int, 'support' => int, 'total' => int]
 * @param array $current_counts Current filtered counts (same structure as job_counts)
 * @param array $search_status Search and filter status
 *   - search_term: Current search term
 *   - filter_type: Current job type filter
 *   - filter_grade: Current grade filter
 *   - filter_code: Current code filter
 *   - filter_division: Current division filter
 */

// Default values
$job_counts = $job_counts ?? ['administration' => 0, 'licensed' => 0, 'support' => 0, 'total' => 0];
$current_counts = $current_counts ?? $job_counts;
$search_status = $search_status ?? [];

// Check if we have active filters
$has_filters = !empty($search_status['search_term']) || 
               (isset($search_status['filter_type']) && $search_status['filter_type'] !== 'all') || 
               !empty($search_status['filter_grade']) || 
               !empty($search_status['filter_code']) || 
               !empty($search_status['filter_division']);

$current_total = $current_counts['administration'] + $current_counts['licensed'] + $current_counts['support'];
?>

<div class="summary-stats">
    <h2>Summary</h2>
    
    <?php if (!empty($search_status['search_term'])): ?>
        <p class="search-status">
            <strong>Search results for:</strong> "<?php echo htmlspecialchars($search_status['search_term']); ?>"
        </p>
    <?php endif; ?>
    
    <?php if (isset($search_status['filter_type']) && $search_status['filter_type'] !== 'all'): ?>
        <p class="filter-status">
            <strong>Filtered by:</strong> <?php echo ucfirst($search_status['filter_type']); ?> Jobs
        </p>
    <?php endif; ?>
    
    <?php if ($has_filters): ?>
        <p><strong>Results Found:</strong></p>
        <?php if ($current_counts['administration'] > 0): ?>
            <p>Administration Jobs: <?php echo $current_counts['administration']; ?></p>
        <?php endif; ?>
        <?php if ($current_counts['licensed'] > 0): ?>
            <p>Licensed Jobs: <?php echo $current_counts['licensed']; ?></p>
        <?php endif; ?>
        <?php if ($current_counts['support'] > 0): ?>
            <p>Support Jobs: <?php echo $current_counts['support']; ?></p>
        <?php endif; ?>
        <p><strong>Total Results: <?php echo $current_total; ?></strong></p>
        <hr>
        <p><em>Total Available Jobs:</em></p>
    <?php endif; ?>
    
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-number"><?php echo $job_counts['administration']; ?></div>
            <p class="stat-label">Administration Jobs</p>
        </div>
        <div class="stat-card">
            <div class="stat-number"><?php echo $job_counts['licensed']; ?></div>
            <p class="stat-label">Licensed Jobs</p>
        </div>
        <div class="stat-card">
            <div class="stat-number"><?php echo $job_counts['support']; ?></div>
            <p class="stat-label">Support Jobs</p>
        </div>
        <div class="stat-card">
            <div class="stat-number"><?php echo $job_counts['total']; ?></div>
            <p class="stat-label">Total Jobs</p>
        </div>
    </div>
</div>