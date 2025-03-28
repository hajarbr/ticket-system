<link rel="stylesheet" href="<?= base_url('application/views/assets/css/custom.css') ?>">
<div class="container mt-5">
    <h1><?= $title ?? 'Tickets' ?></h1>

    <?php if ($this->session->userdata('role') === 'admin'): ?>
        <form method="get" action="<?= site_url('tickets/filter_and_search') ?>" class="mb-3">
            <div class="row">
                <!-- Search by Title -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="title" class="form-label">Search by Title:</label>
                        <input type="text" name="title" id="title" class="form-control" placeholder="Enter ticket title" value="<?= isset($_GET['title']) ? htmlspecialchars($_GET['title']) : '' ?>">
                    </div>
                </div>

                <!-- Filter by Status -->
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="status_id" class="form-label">Filter by Status:</label>
                        <select name="status_id" id="status_id" class="form-control">
                            <option value="">All</option>
                            <option value="1" <?= isset($_GET['status_id']) && $_GET['status_id'] == '1' ? 'selected' : '' ?>>Open</option>
                            <option value="2" <?= isset($_GET['status_id']) && $_GET['status_id'] == '2' ? 'selected' : '' ?>>In Progress</option>
                            <option value="3" <?= isset($_GET['status_id']) && $_GET['status_id'] == '3' ? 'selected' : '' ?>>Closed</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-2 d-flex align-items-end mt-24">
                    <button type="submit" class="btn btn-primary btn-block">Filter</button>
                </div>
            </div>
        </form>
    <?php endif; ?>

    <?php if ($this->session->userdata('role') === 'user'): ?>
        <div class="d-flex justify-content-between mb-3">
            <a href="<?= site_url('add') ?>" class="btn btn-success">
                <i class="fa fa-plus"></i> <span>Ajouter un Ticket</span>
            </a>
        </div>
    <?php endif; ?>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Status</th>
                <th>Assigned User</th>
                <th>Is Closed</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($tickets) && is_array($tickets)): ?>
                <?php foreach ($tickets as $ticket): ?>
                    <tr>
                        <td><?= $ticket->id ?></td>
                        <td><?= htmlspecialchars($ticket->title) ?></td>
                        <td><?= htmlspecialchars($ticket->status_name) ?></td>
                        <td><?= htmlspecialchars($ticket->firstname . ' ' . $ticket->lastname) ?></td>
                        <td><?= $ticket->is_closed ? 'Yes' : 'No' ?></td>
                        <td>
                            <?php if ($this->session->userdata('role') === 'admin'): ?>
                                <a href="<?= site_url('tickets/respond/' . $ticket->id) ?>" class="btn btn-info btn-sm">Respond</a>
                                <a href="<?= site_url('tickets/change_status/' . $ticket->id) ?>" class="btn btn-warning btn-sm">Change Status</a>
                                <a href="<?= site_url('tickets/close/' . $ticket->id) ?>" class="btn btn-danger btn-sm">Close</a>
                            <?php endif; ?>

                            <?php if ($this->session->userdata('role') === 'user'): ?>
                                <a href="<?= site_url('respond/' . $ticket->id) ?>" class="btn btn-info btn-sm"><i class="fa fa-reply"></i> Répondre</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" class="text-center">No tickets available.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>