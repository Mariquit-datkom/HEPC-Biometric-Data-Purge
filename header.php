<?php 
$pageTitle = "";
switch($currentPage) {
    case 'dashboard.php':
        $pageTitle = "Dashboard";
        break;
    case 'history.php':
        $pageTitle = "History";
        break;
    case 'editList.php':
        $pageTitle = "Edit Devices";
        break;
}
?>

<div class="header-container">
    <div class="live-clock-container">
        <div id="current-time"></div>
        <div id="current-date"></div>
    </div>
    <div class="page-title-container">
        <p class="page-title"><?php echo $pageTitle ?></p>
    </div>
    <div class="user-account-container" id="userDropdownContainer">
        <div class="user-display-wrapper">
            <p class="username-display"><?php echo $_SESSION['username'] ?></p>
            <img src="assets/img/userIcon.png" class="user-icon" alt="user profile icon">
        </div>

        <ul class="user-dropdown-menu">
            <li>
                <a href="logout.php">
                    <i class="fa-solid fa-right-from-bracket"></i> Sign Out
                </a>
            </li>
        </ul>
    </div>
</div>

<script src="js/liveClock.js"></script>
<script src="js/userDropdown.js"></script>