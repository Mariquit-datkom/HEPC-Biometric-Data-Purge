<div class="nav-panel-container">
    <div class="nav-item-container">
        <?php
        $currentPage = basename($_SERVER['PHP_SELF']);
        
        $navItems = [
            'dashboard.php' => ['text' => 'Dashboard'],
            'history.php' => ['text' => 'History'],
            'editList.php' => ['text' => 'Edit Devices']
        ];

        foreach ($navItems as $page => $details):
            $isActive = ($currentPage === $page);
            $href = $isActive ? 'javascript:void(0)' : $page;
            $activeClass = $isActive ? 'active' : '';
        ?>

        <div class="nav-panel-item <?php echo $activeClass ?>">
            <a href="<?php echo $href ?>">
                </i> <?php echo $details['text'] ?>
            </a>
        </div>
        <?php endforeach; ?>
    </div>
    <?php if ($currentPage === 'dashboard.php'): ?>
    <div class="sort-container" id="sortContainer">
        <div class="selected-display">By Cutoff</div>
        <ul class="options-list">
            <li data-value="byCutoff">By Cutoff</li>
            <li data-value="alphabetical">Alphabetical</li>
        </ul>
        <input type="hidden" name="sortby" id="sortByValue" value="default">
    </div>
    <div class="search-container">
        <input type="text" name="search" id="search" class="search-bar" placeholder="Search">
    </div>
    <?php endif; ?>
</div>

<script src="js/sortDropdown.js"></script>
<script src="js/search.js"></script>