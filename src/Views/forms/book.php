<?php
$id = '';
$code = '';
$title = '';
$description = '';
$author = '';
$isbn = '';
$genre = '';
$publisher = '';
$published_date = '';
$available = '';
$cover = '';

if (isset($book)) {
    $id = $book->id;
    $code = $book->code;
    $title = $book->title;
    $description = $book->description;
    $author = $book->author;
    $isbn = $book->isbn;
    $genre = $book->genre;
    $publisher = $book->publisher;
    $published_date = $book->published_date;
    $available = $book->available;
    $cover = $book->cover;
}

if (isset($oldInputs["code"])) {
    $code = $oldInputs["code"];
    $title = $oldInputs["title"];
    $description = $oldInputs["description"];
    $author = $oldInputs["author"];
    $isbn = $oldInputs["isbn"];
    $genre = $oldInputs["genre"];
    $publisher = $oldInputs["publisher"];
    $published_date = $oldInputs["published_date"];
    $available = $oldInputs["available"];
    $cover = $oldInputs["cover"];
}
?>

<div class="card p-3 my-5">
    <form action="/books<?= isset($book) ? '/update' : '' ?>" method="POST" enctype="multipart/form-data">
        <div>
            <input type="hidden" name="id" value="<?= $id ?>">
            <div class="row mb-3">
                <div class="col-sm-3">
                    <label for="code" class="form-label m-0">Code </label>
                    <input type="text" class="form-control border field" value="<?= $code ?>" name="code" id="code">
                    <small class="text-danger"><?= $errors["code"] ?? '' ?></small>
                </div>
                <div class="col-sm-9">
                    <label for="title" class="form-label m-0">Title</label>
                    <input type="text" class="form-control border field" value="<?= $title ?>" name="title" id="title">
                    <small class="text-danger"><?= $errors["title"] ?? '' ?></small>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-sm-12">
                    <label for="description" class="form-label m-0">Description</label>
                    <textarea class="form-control border field" name="description" id="description"><?= $description ?></textarea>
                    <small class="text-danger"><?= $errors["description"] ?? ''; ?></small>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-sm-6">
                    <label for="author" class="form-label m-0">Author</label>
                    <input type="text" class="form-control border field" name="author" value="<?= $author ?>" id="author">
                    <small class="text-danger"><?= $errors["author"] ?? '' ?></small>
                </div>
                <div class="col-sm-3">
                    <label for="isbn" class="form-label m-0">ISBN</label>
                    <input type="text" class="form-control border field" name="isbn" value="<?= $isbn ?>" id="isbn">
                    <small class="text-danger"><?= $errors["isbn"] ?? '' ?></small>
                </div>
                <div class="col-sm-3">
                    <label for="genre" class="form-label m-0">Genre</label>
                    <select class="form-control border field" name="genre" value="" id="genre">
                        <option value="">Select</option>
                        <option value="Fantasy" <?= $genre === "Fantasy" ? "selected" : ''; ?>>Fantasy</option>
                        <option value="Drama" <?= $genre === "Drama" ? "selected" : ''; ?>>Drama</option>
                        <option value="Adventure" <?= $genre === "Adventure" ? "selected" : ''; ?>>Adventure</option>
                        <option value="Romance" <?= $genre === "Romance" ? "selected" : ''; ?>>Romance</option>
                        <option value="Novel" <?= $genre === "Novel" ? "selected" : ''; ?>>Novel</option>
                        <option value="Science Fiction" <?= $genre === "Science Fiction" ? "selected" : ''; ?>>Science Fiction</option>
                    </select>
                    <small class="text-danger"><?= $errors["genre"] ?? '' ?></small>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-sm-5">
                    <label for="publisher" class="form-label m-0">Publisher</label>
                    <input type="text" class="form-control border field" value="<?= $publisher ?>" name="publisher" id="publisher">
                    <small class="text-danger"><?= $errors["publisher"] ?? '' ?></small>
                </div>
                <div class="col-sm-2">
                    <label for="published_date" class="form-label m-0">Published Date</label>
                    <input type="date" class="form-control border field" value="<?= $published_date ?>" name="published_date" id="published_date">
                    <small class="text-danger"><?= $errors["published_date"] ?? '' ?></small>
                </div>
                <div class="col-sm-1">
                    <label for="available" class="form-label m-0">Available</label>
                    <input type="number" class="form-control border field" value="<?= $available ?>" name="available" id="available">
                    <small class="text-danger"><?= $errors["available"] ?? '' ?></small>
                </div>
                <div class="col-sm-4">
                    <label for="cover" class="form-label m-0">Cover</label>
                    <input accept="image/jpg, image/jpeg" type="file" class="form-control border field" value="<?= $cover ?>" name="cover" id="cover">
                    <small class="text-danger"><?= $errors["cover"] ?? '' ?></small>
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