<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Agreements</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <style>
        .signature-box {
            border: 1px solid #000;
            width: 200px;
            height: 100px;
        }
    </style>
</head>

<body>

    <h2>All Agreements</h2>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Client Name</th>
                <th>Agreement Text</th>
                <th>Signature</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($agreements as $agreement): ?>
                <tr>
                    <td><?= $agreement->id ?></td>
                    <td><?= $agreement->client_name ?></td>
                    <td><?= $agreement->agreement_text ?></td>
                    <td>
                        <?php if ($agreement->signature): ?>
                            <div class="signature-box">
                                <img src="<?= $agreement->signature ?>" alt="Signature" class="img-fluid">
                            </div>
                        <?php else: ?>
                            No signature
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="<?= site_url('AgreementController/delete_agreement/' . $agreement->id) ?>" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</body>

</html>

<!-- show admin added deafault agreement to client -->