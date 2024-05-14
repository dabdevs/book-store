<?php

// Check if there are errors stored in session
if (isset($_SESSION['errors'])) {
    $errors = $_SESSION['errors'];
    $oldInputs = $_SESSION['oldInputs'];
    unset($_SESSION['errors'], $_SESSION['oldInputs']);
} else {
    $errors = null;
    $oldInputs = [];
}

var_dump($errors, $oldInputs);
?>

<div style="z-index: 9000;" class="modal fade" id="bookModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="bookModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="bookModalLabel">Book</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="/books" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <label for="code" class="form-label m-0">Code</label>
                            <input type="text" class="form-control border field" value="<?= $oldInputs["code"] ?? '' ?>" name="code" id="code">
                            <small class="text-danger"><?= $errors["code"] ?? '' ?></small>
                        </div>
                        <div class="col-sm-9">
                            <label for="title" class="form-label m-0">Title</label>
                            <input type="text" class="form-control border field" value="<?= $oldInputs["title"] ?? '' ?>" name="title" id="title">
                            <small class="text-danger"><?= $errors["title"] ?? '' ?></small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-12">
                            <label for="description" class="form-label m-0">Description</label>
                            <textarea class="form-control border field" name="description" id="description"><?= $oldInputs["description"] ?? '' ?></textarea>
                            <small class="text-danger"><?= $errors["description"] ?? '' ?></small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-6">
                            <label for="author" class="form-label m-0">Author</label>
                            <input type="text" class="form-control border field" name="author" value="<?= $oldInputs["author"] ?? '' ?>" id="author">
                            <small class="text-danger"><?= $errors["author"] ?? '' ?></small>
                        </div>
                        <div class="col-sm-3">
                            <label for="isbn" class="form-label m-0">ISBN</label>
                            <input type="text" class="form-control border field" name="isbn" value="<?= $oldInputs["isbn"] ?? '' ?>" id="isbn">
                            <small class="text-danger"><?= $errors["isbn"] ?? '' ?></small>
                        </div>
                        <div class="col-sm-3">
                            <label for="genre" class="form-label m-0">Genre</label>
                            <select class="form-control border field" name="genre" value="<?= $oldInputs["genre"] ?? '' ?>" id="genre">
                                <option value="">Select</option>
                                <option value="Fantasy">Fantasy</option>
                                <option value="Drama">Drama</option>
                                <option value="Adventure">Adventure</option>
                                <option value="Romance">Romance</option>
                                <option value="Science Fiction">Science Fiction</option>
                            </select>
                            <small class="text-danger"><?= $errors["genre"] ?? '' ?></small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-5">
                            <label for="publisher" class="form-label m-0">Publisher</label>
                            <input type="text" class="form-control border field" value="<?= $oldInputs["publisher"] ?? '' ?>" name="publisher" id="publisher">
                            <small class="text-danger"><?= $errors["publisher"] ?? '' ?></small>
                        </div>
                        <div class="col-sm-3">
                            <label for="published_date" class="form-label m-0">Published Date</label>
                            <input type="text" class="form-control border field" value="<?= $oldInputs["publishedDate"] ?? '' ?>" name="publishedDate" id="published_date">
                            <small class="text-danger"><?= $errors["publishedDate"] ?? '' ?></small>
                        </div>
                        <div class="col-sm-4">
                            <label for="cover" class="form-label m-0">Cover</label>
                            <input accept="image/png" type="file" class="form-control border field" value="<?= $oldInputs["cover"] ?? '' ?>" name="cover" id="cover">
                            <small class="text-danger"><?= $errors["cover"] ?? '' ?></small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn" data-bs-dismiss="modal" id="close-btn" onclick="clearForm()">Close</button>
                    <button type="submit" class="btn btn-primary" id="submit-btn">
                        <i class="material-icons opacity-10 text-white">save</i>
                        Save
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function clearForm() {
        const fields = document.querySelectorAll(".field")

        fields.forEach(field => {
            field.value = ""
        })
    }
</script>