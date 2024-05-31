<div class="row my-4" style="overflow-x: hidden;">
    <div class="col-12">
        <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="d-flex justify-content-between bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                    <h6 class="text-white text-capitalize ps-3">Books</h6>
                    <a class="px-3 bg-transparent border-0" href="/books/create">
                        <i class="material-icons opacity-10 text-white">add_circle</i>
                    </a>
                </div>
            </div>
            <div class="card-body px-0 pb-2">
                <div class="table-responsive px-2">
                    <table class="table display align-items-center mb-0" id="books-table">
                        <thead class="text-left">
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-4">Code</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Title</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Author</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Genre</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Available</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Loan Count</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Last Updated</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (!empty($books)) {
                                foreach ($books as $book) { ?>
                                    <tr>
                                        <td class="ps-4">
                                            <p class="text-xs font-weight-bold mb-0"><?= $book->code ?></p>
                                        </td>
                                        <td>
                                            <div class="d-flex">
                                                <!-- <div>
                                                    <img src="../src<?= $book->cover ?>" class="avatar avatar-sm me-3 border-radius-lg" alt="user1">
                                                </div> -->
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm"><?= $book->title ?></h6>
                                                    <p class="text-xs text-secondary d-inline-block text-truncate" style="max-width: 200px;"><?= $book->description ?></p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0"><?= $book->author ?></p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0"><?= $book->publisher ?></p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0"><?= $book->available ?></p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0"><?= $book->loan_count ?></p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0"><?= $book->updated_at ?></p>
                                        </td>
                                        <td class="align-middle p-0">
                                            <a href="/books/edit?id=<?= $book->id ?>" class="font-weight-bold text-xs" data-bs-toggle="tooltip" data-bs-title="Edit book">
                                                <i class="material-icons opacity-10">edit</i>
                                            </a>
                                            &nbsp;
                                            <a href="#" onclick='deleteItem("<?= $book->title ?>", "<?= $book->id ?>", "/books/delete")' data-bs-toggle="tooltip" data-bs-title="Delete book">
                                                <i class="material-icons opacity-10">delete</i>
                                            </a>
                                        </td>
                                    </tr>
                            <?php }
                            } else {
                                echo "<tr><td colspan='9' class='text-center py-5'>No items</td></tr>";
                            } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>