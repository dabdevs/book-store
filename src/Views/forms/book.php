<?php
$id = '';
$code = '';
$title = '';
$description = '';
$author = '';
$language = '';
$isbn = '';
$rating = '';
$genre = '';
$publisher = '';
$published_date = '';
$page_count = '';
$available = '';
$cover = '';
$date_created = '';
$last_updated = '';

if (isset($book)) {
    $id = $book->getId();
    $code = $book->getCode();
    $title = $book->getTitle();
    $description = $book->getDescription();
    $author = $book->getAuthor();
    $isbn = $book->getIsbn();
    $genre = $book->getGenre();
    $language = $book->getLanguage();
    $rating = $book->getRating();
    $publisher = $book->getPublisher();
    $published_date = $book->getPublishedDate();
    $available = $book->getAvailable();
    $loan_count = $book->getLoanCount();
    $page_count = $book->getPageCount();
    $cover = $book->getCover();
    $date_created = $book->getDateCreated();
    $last_updated = $book->getLastUpdated();
}

if (isset($oldInputs["title"])) {
    $title = $oldInputs["title"];
    $description = $oldInputs["description"];
    $author = $oldInputs["author"];
    $isbn = $oldInputs["isbn"];
    $genre = $oldInputs["genre"];
    $language = $oldInputs["language"];
    $publisher = $oldInputs["publisher"];
    $published_date = $oldInputs["published_date"];
    $available = $oldInputs["available"];
    $cover = isset($oldInputs["cover"]) ? $oldInputs["cover"] : '';
    $page_count = isset($oldInputs["page_count"]) ? $oldInputs["page_count"] : '';
    $rating = isset($oldInputs["rating"]) ? $oldInputs["rating"] : '';
}
?>

<div class="card p-3 my-5 position-relative">
    <button class="btn btn-sm btn-primary position-absolute end-1 top-1" onclick="editForm()">
        <i class="material-icons opacity-10 fs-5">edit</i>
    </button>
    <div class="row plain-value">
        <div class="col-sm-12 mb-2 d-flex gap-3 plain-value">
            <img src="<?= $cover ?>" alt="">
            <div>
                <h3><?= $title ?></h3>
                <p><?= $description ?? 'N/A' ?></p>
            </div>
        </div>
        <div class="col-sm-3 plain-value">
            <p><b>Code: </b> <?= $code ?></p>
        </div>
        <div class="col-sm-3 plain-value">
            <p><b>Author: </b> <?= $author ?></p>
        </div>
        <div class="col-sm-3 plain-value">
            <p><b>Language: </b><?= $language ?></p>
        </div>
        <div class="col-sm-3 plain-value">
            <p><b>ISBN: </b><?= $isbn ?></p>
        </div>
        <div class="col-sm-3 plain-value">
            <p><b>Genre: </b><?= $genre ?></p>
        </div>
        <div class="col-sm-3 plain-value">
            <p><b>Publisher:</b> <?= $publisher ?></p>
        </div>
        <div class="col-sm-3 plain-value">
            <p><b>Published Date:</b> <?= $published_date ?></p>
        </div>
        <div class="col-sm-3 plain-value">
            <p><b>Pages:</b> <?= $page_count ?? 'N/A' ?></p>
        </div>
        <div class="col-sm-3 plain-value">
            <p><b>Rating:</b> <?= $rating ?? 'N/A' ?></p>
        </div>
        <div class="col-sm-3 plain-value">
            <p><b>Available:</b> <?= $available ?></p>
        </div>
        <div class="col-sm-3 plain-value">
            <p><b>Loans:</b> <?= $loan_count ?></p>
        </div>
        <div class="col-sm-3 plain-value">
            <p><b>Date Created:</b> <?= $date_created ?></p>
        </div>
        <div class="col-sm-3 plain-value">
            <p><b>Last Updated:</b> <?= $last_updated ?? 'N/A' ?></p>
        </div>
        <div class="modal-footer">
            <a href="/books" class="btn">Cancel</a>
        </div>
    </div>

    <form class="py-2 form-value d-none" action="/books<?= isset($book) ? '/update' : '' ?>" method="POST">
        <input type="hidden" name="id" value="<?= $id ?>">
        <div class="row mb-3">
            <div class="col-sm-12">
                <label for="title" class="form-label m-0">Title</label>
                <input type="text" class="form-control border field" value="<?= $title ?>" name="title" id="title" oninput="searchBook()">
                <small class="text-danger error"><?= $errors["title"] ?? '' ?></small>
                <div id="books-suggestions"></div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-sm-12">
                <label for="description" class="form-label m-0">Description</label>
                <textarea class="form-control border field" name="description" id="description" max="255"><?= $description ?></textarea>
                <small class="text-danger error"><?= $errors["description"] ?? ''; ?></small>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-sm-4">
                <label for="author" class="form-label m-0">Author</label>
                <input type="text" class="form-control border field" name="author" value="<?= $author ?>" id="author">
                <small class="text-danger error"><?= $errors["author"] ?? '' ?></small>
            </div>
            <div class="col-sm-2">
                <label for="language" class="form-label m-0">Language</label> <br>
                <select style="width: 100%;" class="form-control border field select2" name="language" value="" id="language">
                    <option value="">Select</option>
                    <option value="en" <?= $language === "en" ? "selected" : ''; ?>>English</option>
                    <option value="es" <?= $language === "es" ? "selected" : ''; ?>>Spanish</option>
                    <option value="fr" <?= $language === "fr" ? "selected" : ''; ?>>French</option>
                    <option value="it" <?= $language === "it" ? "selected" : ''; ?>>Italian</option>
                    <option value="pr" <?= $language === "pr" ? "selected" : ''; ?>>Protuguese</option>
                    <option value="jp" <?= $language === "jp" ? "selected" : ''; ?>>Japanese</option>
                </select>
                <small class="text-danger error"><?= $errors["language"] ?? '' ?></small>
            </div>

            <div class="col-sm-3">
                <label for="isbn" class="form-label m-0">ISBN</label>
                <input type="text" class="form-control border field" name="isbn" value="<?= $isbn ?>" id="isbn">
                <small class="text-danger error"><?= $errors["isbn"] ?? '' ?></small>
            </div>

            <div class="col-sm-3">
                <label for="genre" class="form-label m-0">Genre</label> <br>
                <select style="width: 100%;" class="form-control border field select2" value="" name="genre" id="genre">
                    <option value="">Select</option>
                    <option value="Fantasy" <?= $genre === "Fantasy" ? "selected" : ''; ?>>Fantasy</option>
                    <option value="Drama" <?= $genre === "Drama" ? "selected" : ''; ?>>Drama</option>
                    <option value="Adventure" <?= $genre === "Adventure" ? "selected" : ''; ?>>Adventure</option>
                    <option value="Romance" <?= $genre === "Romance" ? "selected" : ''; ?>>Romance</option>
                    <option value="Novel" <?= $genre === "Novel" ? "selected" : ''; ?>>Novel</option>
                    <option value="Science Fiction" <?= $genre === "Science Fiction" ? "selected" : ''; ?>>Science Fiction</option>
                </select>
                <small class="text-danger error"><?= $errors["genre"] ?? '' ?></small>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-sm-3">
                <label for="publisher" class="form-label m-0">Publisher</label>
                <input type="text" class="form-control border field" value="<?= $publisher ?>" name="publisher" id="publisher">
                <small class="text-danger error"><?= $errors["publisher"] ?? '' ?></small>
            </div>

            <div class="col-sm-2">
                <label for="published_date" class="form-label m-0">Published Date</label>
                <input type="date" class="form-control border field" value="<?= $published_date ?>" name="published_date" id="published_date">
                <small class="text-danger error"><?= $errors["published_date"] ?? '' ?></small>
            </div>

            <div class="col-sm-2">
                <label for="page_count" class="form-label m-0">Pages</label>
                <input type="number" value="<?= $page_count ?>" class="form-control border field" name="page_count" id="page_count">
                <small class="text-danger error"><?= $errors["page_count"] ?? '' ?></small>
            </div>

            <div class="col-sm-1">
                <label for="rating" class="form-label m-0">Rating</label>
                <input type="number" step="0.1" value="<?= $rating ?>" class="form-control border field" name="rating" id="rating">
                <small class="text-danger error"><?= $errors["rating"] ?? '' ?></small>
            </div>

            <div class="col-sm-1">
                <label for="available" class="form-label m-0">Available</label>
                <input type="number" class="form-control border field" value="<?= $available ?>" name="available" id="available">
                <small class="text-danger error"><?= $errors["available"] ?? '' ?></small>
            </div>

            <?php if ($page === "View Book") { ?>
                <div class="col-sm-1">
                    <label for="loan_count" class="form-label m-0">Loans</label>
                    <input readonly type="number" class="form-control border field" value="<?= $loan_count ?>" name="loan_count" id="loan_count">
                </div>
            <?php } ?>
            <input type="hidden" class="form-control border field" value="<?= $cover ?>" name="cover" id="cover">
        </div>
        <div class="modal-footer form-value d-none" id="footer">
            <a href="/books" class="btn">Cancel</a>
            <button type="submit" class="btn btn-primary form-value d-none" id="submit-btn">
                <i class="material-icons opacity-10 text-white">save</i>
                Save
            </button>
        </div>
    </form>
</div>