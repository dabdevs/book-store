<div class="card p-3 my-5">
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
                        <option value="Novel">Novel</option>
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
                <div class="col-sm-2">
                    <label for="published_date" class="form-label m-0">Published Date</label>
                    <input type="date" class="form-control border field" value="<?= $oldInputs["published_date"] ?? '' ?>" name="published_date" id="published_date">
                    <small class="text-danger"><?= $errors["published_date"] ?? '' ?></small>
                </div>
                <div class="col-sm-1">
                    <label for="available" class="form-label m-0">Available</label>
                    <input type="number" class="form-control border field" value="<?= $oldInputs["available"] ?? '' ?>" name="available" id="available">
                    <small class="text-danger"><?= $errors["available"] ?? '' ?></small>
                </div>
                <div class="col-sm-4">
                    <label for="cover" class="form-label m-0">Cover</label>
                    <input accept="image/jpg, image/jpeg" type="file" class="form-control border field" value="<?= $oldInputs["cover"] ?? '' ?>" name="cover" id="cover">
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