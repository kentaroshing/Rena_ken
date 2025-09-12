<div class="container">
    <h1>Students</h1>
    <a href="<?= site_url('students/create') ?>" class="btn-add">Add Student</a>
    <table>
        <thead>
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
            <tr class="fade-in">
                <td><?= htmlspecialchars($student['id']) ?></td>
                <td><?= htmlspecialchars($student['first_name']) ?></td>
                <td><?= htmlspecialchars($student['last_name']) ?></td>
                <td><?= htmlspecialchars($student['email']) ?></td>
                <td>
                    <a href="<?= site_url('students/edit/'.$student['id']) ?>" class="btn-edit">Edit</a>
                    <a href="<?= site_url('students/delete/'.$student['id']) ?>" onclick="return confirm('Are you sure you want to elete?')" class="btn-delete">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<style>
body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: #e6f2e6;
    margin: 0;
    padding: 20px;
}

.container {
    max-width: 900px;
    margin: 0 auto;
    background: #fff;
    padding: 30px 40px;
    border-radius: 16px;
    box-shadow: 0 8px 24px rgba(0, 128, 0, 0.15);
    animation: fadeInContainer 0.8s ease forwards;
}

h1 {
    color: #2f6f2f;
    font-weight: 700;
    font-size: 2.4rem;
    margin-bottom: 20px;
    text-align: center;
}

.btn-add {
    display: inline-block;
    margin-bottom: 20px;
    padding: 12px 24px;
    background: linear-gradient(135deg, #a8d5a8, #4caf50);
    color: white;
    font-weight: 700;
    border-radius: 14px;
    text-decoration: none;
    box-shadow: 0 6px 12px rgba(76, 175, 80, 0.4);
    transition: background 0.3s ease, box-shadow 0.3s ease;
}

.btn-add:hover {
    background: linear-gradient(135deg, #4caf50, #388e3c);
    box-shadow: 0 8px 16px rgba(56, 142, 60, 0.6);
}

table {
    width: 100%;
    border-collapse: collapse;
    font-size: 1rem;
}

th, td {
    padding: 12px 15px;
    border-bottom: 1px solid #ddd;
    text-align: left;
}

th {
    background-color: #a8d5a8;
    color: #2f4f2f;
    font-weight: 700;
}

tr:hover {
    background-color: #e0f0e0;
}

.btn-edit, .btn-delete {
    padding: 6px 12px;
    border-radius: 12px;
    color: white;
    font-weight: 600;
    text-decoration: none;
    transition: background 0.3s ease;
}

.btn-edit {
    background-color: #4caf50;
}

.btn-edit:hover {
    background-color: #388e3c;
}

.btn-delete {
    background-color: #d9534f;
}

.btn-delete:hover {
    background-color: #c9302c;
}

@keyframes fadeInContainer {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.fade-in {
    animation: fadeInRow 0.6s ease forwards;
}

@keyframes fadeInRow {
    from {
        opacity: 0;
        transform: translateX(-20px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}
</style>
