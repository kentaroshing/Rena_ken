<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Students List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
<div class="container mt-3">
    <form action="" method="get" class="col-sm-4 float-end d-flex mb-3">
        <input class="form-control me-2" name="q" type="text" placeholder="Search students..." value="<?= isset($q) ? html_escape($q) : ''; ?>">
        <button type="submit" class="btn btn-success">Search</button>
    </form>
    <h1>Students</h1>
    <a href="<?= site_url('students/create') ?>" class="btn btn-success mb-3">Add Student</a>
    <table class="table table-striped table-bordered">
        <thead class="table-success">
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach (html_escape($students) as $student): ?>
            <tr>
                <td><?= htmlspecialchars($student['id']) ?></td>
                <td><?= htmlspecialchars($student['first_name']) ?></td>
                <td><?= htmlspecialchars($student['last_name']) ?></td>
                <td><?= htmlspecialchars($student['email']) ?></td>
                <td>
                    <a href="<?= site_url('students/edit/'.$student['id']) ?>" class="btn btn-success btn-sm">Edit</a>
                    <a href="<?= site_url('students/delete/'.$student['id']) ?>" onclick="return confirm('Are you sure you want to delete?')" class="btn btn-danger btn-sm">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <?php if (isset($total_rows) && $total_rows > 5): ?>
    <div class="d-flex justify-content-center">
        <?= $page; ?>
    </div>
    <?php endif; ?>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+6bU5l5Y5n3z5+5h5+5h5+5h5+5h5" crossorigin="anonymous"></script>
</body>
</html>
