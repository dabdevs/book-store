<?php
$id = '';
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

if (isset($book)) {
    $id = $book->getId();
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

<div class="card p-3 my-5">
    <form action="/books<?= isset($book) ? '/update' : '' ?>" method="POST" enctype="multipart/form-data">
        <div>
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
                    <label for="language" class="form-label m-0">Language</label>
                    <select class="form-control border field select2" name="language" value="" id="language">
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
                    <label for="genre" class="form-label m-0">Genre</label>
                    <select class="form-control border field select2" value="" name="genre" id="genre">
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
                <div class="col-sm-1">
                    <label for="page_count" class="form-label m-0">Pages</label>
                    <input type="number" class="form-control border field" name="page_count" id="page_count">
                    <small class="text-danger error"><?= $errors["page_count"] ?? '' ?></small>
                </div>
                <div class="col-sm-1">
                    <label for="rating" class="form-label m-0">Rating</label>
                    <input type="number" step="0.1" class="form-control border field" name="rating" id="rating">
                    <small class="text-danger error"><?= $errors["rating"] ?? '' ?></small>
                </div>
                <div class="col-sm-1">
                    <label for="available" class="form-label m-0">Available</label>
                    <input type="number" class="form-control border field" value="<?= $available ?>" name="available" id="available">
                    <small class="text-danger error"><?= $errors["available"] ?? '' ?></small>
                </div>
                <?php if ($page === "Edit Book") { ?>
                    <div class="col-sm-1">
                        <label for="loan_count" class="form-label m-0">Loans</label>
                        <input readonly type="number" class="form-control border field" value="<?= $loan_count ?>" name="loan_count" id="loan_count">
                    </div>
                <?php } ?>
                <div class="col-sm-4" id="cover-column">
                    <label for="cover" class="form-label m-0">Cover</label>
                    <input accept="image/jpg, image/jpeg" type="file" class="form-control border field" value="<?= $cover ?>" name="cover" id="cover">
                    <input type="hidden" id="coverFromApi" name="coverFromApi">
                    <small class="text-danger error"><?= $errors["cover"] ?? '' ?></small>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <a href="/books" class="btn">Cancel</a>
            <button type="submit" class="btn btn-primary" id="submit-btn">
                <i class="material-icons opacity-10 text-white">save</i>
                Save
            </button>
        </div>
    </form>
</div>