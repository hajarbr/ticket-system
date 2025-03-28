<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Répondre au Ticket</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Répondre au Ticket</h1>
        <h3><?= htmlspecialchars($ticket->title) ?></h3>
        <p><?= nl2br(htmlspecialchars($ticket->description)) ?></p>

        <h4>Commentaires</h4>
        <?php if (!empty($comments)): ?>
            <ul class="list-group mb-3">
                <?php foreach ($comments as $comment): ?>
                    <li class="list-group-item">
                        <strong><?= htmlspecialchars($comment->firstname . ' ' . $comment->lastname) ?>:</strong>
                        <p><?= htmlspecialchars($comment->comment) ?></p>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>Aucun commentaire pour ce ticket.</p>
        <?php endif; ?>

        <h4>Ajouter un Commentaire</h4>
        <?php if ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger"><?= $this->session->flashdata('error') ?></div>
        <?php endif; ?>
        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success"><?= $this->session->flashdata('success') ?></div>
        <?php endif; ?>
        <form action="<?= site_url('respond/' . $ticket->id) ?>" method="post">
            <div class="mb-3">
                <label for="response" class="form-label">Commentaire</label>
                <textarea class="form-control" id="response" name="response" rows="5" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Envoyer</button>
        </form>
    </div>
</body>
</html>