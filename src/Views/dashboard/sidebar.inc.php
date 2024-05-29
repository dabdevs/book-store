<aside style="z-index: 500;" class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3 bg-gradient-dark bg-white" id="sidenav-main">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-white opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand m-0" href="/">
            <img src="../assets/img/logo.png" class="navbar-brand-img h-100" alt="main_logo">
            <span class="ms-1 font-weight-bold text-white">Book Store</span>
        </a>
    </div>
    <hr class="horizontal light mt-0 mb-2">
    <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link text-white <?= $page === 'Dashboard' ? 'active bg-gradient-primary' : '' ?>" href="/">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">dashboard</i>
                    </div>
                    <span class="nav-link-text ms-1">Dashboard</span>
                </a>
            </li>
            <?php if (in_array($authUser->role, ["ADMIN", "LIBRERIAN"])) { ?>
                <li class="nav-item">
                    <a class="nav-link text-white <?= str_contains($page, 'Book') ? 'active bg-gradient-primary' : '' ?>" href="/books">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">menu_book</i>
                        </div>
                        <span class="nav-link-text">Books</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white <?= str_contains($page, 'Loan') ? 'active bg-gradient-primary' : '' ?>" href="/loans">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">compare_arrows</i>
                        </div>
                        <span class="nav-link-text">Loans</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white <?= str_contains($page, 'Member') ? 'active bg-gradient-primary' : '' ?>" href="/members">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">person</i>
                        </div>
                        <span class="nav-link-text">Members</span>
                    </a>
                </li>
            <?php } ?>

            <?php if ($authUser->role === "ADMIN") { ?>
                <li class="nav-item">
                    <a class="nav-link text-white <?= str_contains($page, 'Librerian') ? 'active bg-gradient-primary' : '' ?>" href="/librerians">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">local_library</i>
                        </div>
                        <span class="nav-link-text">Librerians</span>
                    </a>
                </li>
            <?php } ?>
        </ul>
    </div>
    <div class="sidenav-footer position-absolute w-100 bottom-0 ">
        <ul class="navbar-nav">
            <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-8">Account</h6>
            </li>
            <?php if (isset($authUser)) { ?>
                <li class="nav-item">
                    <a class="nav-link text-white <?= str_contains($page, 'Profile') ? 'active bg-gradient-primary' : '' ?>" href="/profile">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">person</i>
                        </div>
                        <span class="nav-link-text ms-1">Profile</span>
                    </a>
                </li>
            <?php } ?>
        </ul>
        <form class="mx-3" action="/logout" method="POST">
            <button class="btn btn-outline-primary mt-4 w-100">
                <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                    <i class="material-icons opacity-10">logout</i>
                    <span class="nav-link-text ms-1">Sign out</span>
                </div>
            </button>
        </form>
    </div>
</aside>