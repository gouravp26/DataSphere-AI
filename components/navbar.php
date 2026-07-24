<div class="topbar">

    <div class="search">

        <i class="bi bi-search"></i>

        <input type="text" placeholder="Search...">

    </div>

    <div class="top-right">

        <i class="bi bi-bell"></i>

        <i class="bi bi-moon"></i>

        <div class="profile">

            <img src="<?= BASE_URL ?>/assets/images/avatar1.jpg" alt="Profile">

            <span><?= htmlspecialchars($_SESSION['user_name']) ?></span>

        </div>

    </div>

</div>