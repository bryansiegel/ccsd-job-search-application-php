<?php
/**
 * Navigation Component
 * Renders the top navigation bar for the application
 * 
 * @param array $config Navigation configuration
 *   - logo_path: Path to logo image
 *   - logo_alt: Alt text for logo
 *   - links: Array of navigation links [['url' => '', 'text' => '', 'class' => '']]
 *   - base_path: Base path for relative URLs (default: '')
 */

// Set default configuration
$default_config = [
    'logo_path' => 'img/ccsd-main-logo-white.png',
    'logo_alt' => 'CCSD Job Application',
    'links' => [],
    'base_path' => ''
];

// Merge with provided config
$nav_config = isset($nav_config) ? array_merge($default_config, $nav_config) : $default_config;
?>

<nav class="top-navbar">
    <div class="nav-container">
        <div class="nav-logo">
            <img src="<?php echo htmlspecialchars($nav_config['base_path'] . $nav_config['logo_path']); ?>" 
                 alt="<?php echo htmlspecialchars($nav_config['logo_alt']); ?>" 
                 class="logo">
        </div>
        
        <div class="nav-menu">
            <ul class="nav-utility">
                <?php foreach ($nav_config['links'] as $link): ?>
                    <li>
                        <a href="<?php echo htmlspecialchars($nav_config['base_path'] . $link['url']); ?>" 
                           class="<?php echo htmlspecialchars($link['class'] ?? 'utility-link'); ?>">
                            <?php echo htmlspecialchars($link['text']); ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</nav>