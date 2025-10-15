<?php
/**
 * Search and Filter Form Component
 * Renders the search form with filtering options
 * 
 * @param array $search_config Search form configuration
 *   - action: Form action URL (default: '')
 *   - method: Form method (default: 'GET')
 *   - search_term: Current search term
 *   - filter_type: Current job type filter
 *   - filter_grade: Current grade filter
 *   - filter_code: Current code filter
 *   - filter_division: Current division filter
 *   - filter_options: Array with available filter options ['grades' => [], 'codes' => [], 'divisions' => []]
 *   - show_clear: Whether to show clear filters button (default: true)
 */

// Set default configuration
$default_search_config = [
    'action' => '',
    'method' => 'GET',
    'search_term' => '',
    'filter_type' => 'all',
    'filter_grade' => '',
    'filter_code' => '',
    'filter_division' => '',
    'filter_options' => ['grades' => [], 'codes' => [], 'divisions' => []],
    'show_clear' => true
];

// Merge with provided config
$search_config = isset($search_config) ? array_merge($default_search_config, $search_config) : $default_search_config;

// Check if filters are active
$has_active_filters = !empty($search_config['search_term']) || 
                     $search_config['filter_type'] !== 'all' || 
                     !empty($search_config['filter_grade']) || 
                     !empty($search_config['filter_code']) || 
                     !empty($search_config['filter_division']);
?>

<div class="search-filter-container">
    <form method="<?php echo htmlspecialchars($search_config['method']); ?>" 
          action="<?php echo htmlspecialchars($search_config['action']); ?>" 
          class="search-form">
        
        <div class="search-input-group">
            <input type="text" 
                   name="search" 
                   placeholder="Search jobs by title, grade, division, code, etc..." 
                   value="<?php echo htmlspecialchars($search_config['search_term']); ?>" 
                   class="search-input">
        </div>
        
        <div class="filter-group">
            <label for="filter">Filter by type:</label>
            <select name="filter" id="filter" class="filter-select">
                <option value="all"<?php echo ($search_config['filter_type'] === 'all' ? ' selected' : ''); ?>>All Jobs</option>
                <option value="administration"<?php echo ($search_config['filter_type'] === 'administration' ? ' selected' : ''); ?>>Administration</option>
                <option value="licensed"<?php echo ($search_config['filter_type'] === 'licensed' ? ' selected' : ''); ?>>Licensed</option>
                <option value="support"<?php echo ($search_config['filter_type'] === 'support' ? ' selected' : ''); ?>>Support</option>
            </select>
        </div>
        
        <div class="filter-group">
            <label for="grade">Filter by grade:</label>
            <select name="grade" id="grade" class="filter-select">
                <option value="">All Grades</option>
                <?php foreach ($search_config['filter_options']['grades'] as $grade): ?>
                    <option value="<?php echo htmlspecialchars($grade); ?>"<?php echo ($search_config['filter_grade'] === $grade) ? ' selected' : ''; ?>>
                        <?php echo htmlspecialchars($grade); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        
        <div class="filter-group">
            <label for="code">Filter by code:</label>
            <select name="code" id="code" class="filter-select">
                <option value="">All Codes</option>
                <?php foreach ($search_config['filter_options']['codes'] as $code): ?>
                    <option value="<?php echo htmlspecialchars($code); ?>"<?php echo ($search_config['filter_code'] === $code) ? ' selected' : ''; ?>>
                        <?php echo htmlspecialchars($code); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        
        <div class="filter-group">
            <label for="division">Filter by division:</label>
            <select name="division" id="division" class="filter-select">
                <option value="">All Divisions</option>
                <?php foreach ($search_config['filter_options']['divisions'] as $division): ?>
                    <option value="<?php echo htmlspecialchars($division); ?>"<?php echo ($search_config['filter_division'] === $division) ? ' selected' : ''; ?>>
                        <?php echo htmlspecialchars($division); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        
        <div class="button-group">
            <button type="submit" class="search-btn">Search</button>
            <?php if ($search_config['show_clear'] && $has_active_filters): ?>
                <a href="<?php echo htmlspecialchars($search_config['action'] ?: $_SERVER['PHP_SELF']); ?>" class="clear-filters">Clear Filters</a>
            <?php endif; ?>
        </div>
    </form>
</div>