<div class="row">
    <?php if (in_array($authUser->role, ["ADMIN", "LIBRERIAN"])) { ?>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4" role="button" onclick="location.href='/books'">
            <div class="card">
                <div class="card-header p-3 pt-2">
                    <div class="icon icon-lg icon-shape <?= str_contains($page, 'Book') ? 'bg-gradient-dark shadow-dark' : 'bg-gradient-primary shadow-primary' ?> text-center border-radius-xl mt-n4 position-absolute">
                        <i class="material-icons opacity-10">menu_book</i>
                    </div>
                    <div class="text-end pt-1">
                        <p class="text-sm mb-0 text-capitalize">Books</p>
                        <h4 class="mb-0"><?= $cardsData["booksCount"] ?></h4>
                    </div>
                </div>
                <hr class="dark horizontal my-0">
                <div class="card-footer p-3">
                    <p class="mb-0 d-none"><span class="text-success text-sm font-weight-bolder">+55% </span>than last week
                    </p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4" role="button" onclick="location.href='/loans'">
            <div class="card">
                <div class="card-header p-3 pt-2">
                    <div class="icon icon-lg icon-shape <?= str_contains($page, 'Loan') ? 'bg-gradient-dark shadow-dark' : 'bg-gradient-primary shadow-primary' ?> text-center border-radius-xl mt-n4 position-absolute">
                        <i class="material-icons opacity-10">compare_arrows</i>
                    </div>
                    <div class="text-end pt-1">
                        <p class="text-sm mb-0 text-capitalize">Loans</p>
                        <h4 class="mb-0"><?= $cardsData["loansCount"] ?></h4>
                    </div>
                </div>
                <hr class="dark horizontal my-0">
                <div class="card-footer p-3">
                    <p class="mb-0 d-none"><span class="text-success text-sm font-weight-bolder">+3% </span>than last month
                    </p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4" role="button" onclick="location.href='/members'">
            <div class="card">
                <div class="card-header p-3 pt-2">
                    <div class="icon icon-lg icon-shape <?= str_contains($page, 'Member') ? 'bg-gradient-dark shadow-dark' : 'bg-gradient-primary shadow-primary' ?> text-center border-radius-xl mt-n4 position-absolute">
                        <i class="material-icons opacity-10">person</i>
                    </div>
                    <div class="text-end pt-1">
                        <p class="text-sm mb-0 text-capitalize">Members</p>
                        <h4 class="mb-0"><?= $cardsData["membersCount"] ?></h4>
                    </div>
                </div>
                <hr class="dark horizontal my-0">
                <div class="card-footer p-3">
                    <p class="mb-0 d-none"><span class="text-success text-sm font-weight-bolder">+3% </span>than last month
                    </p>
                </div>
            </div>
        </div>
    <?php } ?>

    <?php if ($authUser->role === "ADMIN") { ?>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4" role="button" onclick="location.href='/librerians'">
            <div class="card">
                <div class="card-header p-3 pt-2">
                    <div class="icon icon-lg icon-shape <?= str_contains($page, 'Librerian') ? 'bg-gradient-dark shadow-dark' : 'bg-gradient-primary shadow-primary' ?> text-center border-radius-xl mt-n4 position-absolute">
                        <i class="material-icons opacity-10">local_library</i>
                    </div>
                    <div class="text-end pt-1">
                        <p class="text-sm mb-0 text-capitalize">Librerians</p>
                        <h4 class="mb-0"><?= $cardsData["libreriansCount"] ?></h4>
                    </div>
                </div>
                <hr class="dark horizontal my-0">
                <div class="card-footer p-3">
                    <p class="mb-0 d-none"><span class="text-success text-sm font-weight-bolder">+3% </span>than last month
                    </p>
                </div>
            </div>
        </div>
    <?php } ?>
</div>