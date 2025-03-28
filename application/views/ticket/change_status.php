<form action="" method="post">
    <div class="form-group">
        <label for="status_id">Status</label>
        <select name="status_id" id="status_id" class="form-control">
            <option value="1" <?= $ticket->status_id == 1 ? 'selected' : '' ?>>Open</option>
            <option value="2" <?= $ticket->status_id == 2 ? 'selected' : '' ?>>In Progress</option>
            <option value="3" <?= $ticket->status_id == 3 ? 'selected' : '' ?>>Closed</option>
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Update Status</button>
</form>