<form action="" method="post">
    <div class="form-group">
        <label for="title">Title</label>
        <input type="text" name="title" id="title" class="form-control" value="<?= $ticket->title ?>" required>
    </div>
    <div class="form-group">
        <label for="description">Description</label>
        <textarea name="description" id="description" class="form-control" required><?= $ticket->description ?></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Save Changes</button>
</form>