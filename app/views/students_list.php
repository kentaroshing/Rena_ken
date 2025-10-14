<div class="container" style="background-color: #e6f4ea; padding: 20px; border-radius: 12px; max-width: 900px; margin: 20px auto; font-family: Arial, sans-serif;">
    <form id="searchForm" action="" method="get" class="col-sm-4 float-end d-flex" style="margin-bottom: 15px;">
    <?php if (isset($_GET['page']) && $_GET['page'] > 1): ?>
        <input type="hidden" name="page" value="<?php echo $_GET['page']; ?>">
    <?php endif; ?>
        <input id="searchInput" class="form-control me-2" name="q" type="text" placeholder="Search students..." value="<?= isset($q) ? html_escape($q) : ''; ?>" style="flex-grow: 1; padding: 8px 12px; border-radius: 8px; border: 1px solid #ccc; box-shadow: inset 0 1px 3px rgba(0,0,0,0.1);">
        <button type="submit" class="btn btn-primary" type="button" style="background-color: #4caf50; border: none; color: white; padding: 8px 16px; border-radius: 8px; margin-left: 8px; cursor: pointer;">Search</button>
    </form>
    <script>
        document.getElementById('searchInput').addEventListener('input', function() {
            const query = this.value.trim();
            if (query === '') {
                window.location.href = '<?= site_url('/') ?>';
            } else {
                const url = new URL(window.location.href);
                url.searchParams.set('q', query);
                url.searchParams.delete('page'); // Reset to first page on new search
                window.location.href = url.toString();
            }
        });
    </script>
    <h1 style="color: #2f4f2f; font-weight: 700; margin-bottom: 15px; text-align: center;">Students</h1>
    <?php if ($session->flashdata('error')): ?>
        <div style="color: red; margin-bottom: 15px; padding: 10px; border: 1px solid red; border-radius: 5px; background-color: #ffe6e6;">
            <?= $session->flashdata('error') ?>
        </div>
    <?php endif; ?>
    <?php if ($session->flashdata('success')): ?>
        <div style="color: green; margin-bottom: 15px; padding: 10px; border: 1px solid green; border-radius: 5px; background-color: #e6ffe6;">
            <?= $session->flashdata('success') ?>
        </div>
    <?php endif; ?>
    <a href="<?= site_url('logout') ?>" style="position: absolute; top: 20px; right: 20px; background-color: #d9534f; color: white; padding: 8px 16px; border-radius: 8px; text-decoration: none; font-weight: 600;">Logout</a>
    <?php if (isset($user_role) && $user_role == 'admin'): ?>
        <a href="<?= site_url('students/create') ?>" class="btn-add" style="background-color: #4caf50; color: white; padding: 10px 20px; border-radius: 8px; text-decoration: none; font-weight: 600; display: inline-block; margin-bottom: 15px;">Add Student</a>
    <?php endif; ?>
    <table style="width: 100%; border-collapse: collapse; background-color: white; border-radius: 12px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
        <thead>
            <tr style="background-color: #a8d5a8; color: #2f4f2f; font-weight: 700;">
                <th style="padding: 12px 15px; text-align: left;">ID</th>
                <th style="padding: 12px 15px; text-align: left;">First Name</th>
                <th style="padding: 12px 15px; text-align: left;">Last Name</th>
                <th style="padding: 12px 15px; text-align: left;">Email</th>
                <th style="padding: 12px 15px; text-align: left;">Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach (html_escape($students) as $student): ?>
            <tr class="fade-in" style="border-bottom: 1px solid #ddd;">
                <td style="padding: 12px 15px;"><?= htmlspecialchars($student['id']) ?></td>
                <td style="padding: 12px 15px;"><?= htmlspecialchars($student['first_name']) ?></td>
                <td style="padding: 12px 15px;"><?= htmlspecialchars($student['last_name']) ?></td>
                <td style="padding: 12px 15px;"><?= htmlspecialchars($student['email']) ?></td>
                <td style="padding: 12px 15px;">
                    <?php if (isset($user_role) && ($user_role == 'admin' || $student['email'] == $session->userdata('user_email'))): ?>
                        <a href="<?= site_url('students/edit/'.$student['id']) ?>" class="btn-edit" style="background-color: #4caf50; color: white; padding: 6px 12px; border-radius: 12px; font-weight: 600; text-decoration: none; margin-right: 8px;">Edit</a>
                    <?php endif; ?>
                    <?php if (isset($user_role) && $user_role == 'admin'): ?>
                        <a href="<?= site_url('students/delete/'.$student['id']) ?>" onclick="return confirm('Are you sure you want to delete?')" class="btn-delete" style="background-color: #d9534f; color: white; padding: 6px 12px; border-radius: 12px; font-weight: 600; text-decoration: none;">Delete</a>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

</div>
<?php if (isset($total_rows) && $total_rows > 5): ?>
<div class="pagination-container" style="background: #fff; padding: 20px 40px; margin: 20px auto; max-width: 900px; border-radius: 16px; box-shadow: 0 4px 12px rgba(0, 128, 0, 0.1); text-align: center;">
    <div class="pagination-info" style="margin-bottom: 15px; color: #2f6f2f; font-weight: 600;">
        <p style="margin: 0; font-size: 0.9rem;">Showing page <?php echo $current_page; ?> of <?php echo $last_page; ?>
        (Total: <?php echo $total_rows; ?> students)</p>
    </div>

    <div class="pagination-links" style="display: flex; justify-content: center; align-items: center; gap: 8px; flex-wrap: wrap;">
        <?php if ($current_page > 1): ?>
            <a href="?page=<?php echo $current_page - 1; ?><?php echo !empty($q) ? '&q=' . urlencode($q) : ''; ?>" class="btn btn-secondary" style="background: #6c757d; color: white; border-radius: 8px; padding: 8px 16px; text-decoration: none; font-weight: 600;">Previous</a>
        <?php endif; ?>

        <?php
        $start_page = max(1, $current_page - 2);
        $end_page = min($last_page, $current_page + 2);

        for ($i = $start_page; $i <= $end_page; $i++):
        ?>
            <a href="?page=<?php echo $i; ?><?php echo !empty($q) ? '&q=' . urlencode($q) : ''; ?>"
               class="btn <?php echo ($i == $current_page) ? 'btn-primary' : 'btn-outline-primary'; ?>"
               style="padding: 8px 16px; border-radius: 8px; text-decoration: none; font-weight: 600; <?php echo ($i == $current_page) ? 'background: linear-gradient(135deg, #a8d5a8, #4caf50); color: white; border: none;' : 'background: transparent; color: #4caf50; border: 2px solid #4caf50;'; ?>">
                <?php echo $i; ?>
            </a>
        <?php endfor; ?>

        <?php if ($current_page < $last_page): ?>
            <a href="?page=<?php echo $current_page + 1; ?><?php echo !empty($q) ? '&q=' . urlencode($q) : ''; ?>" class="btn btn-secondary" style="background: #6c757d; color: white; border-radius: 8px; padding: 8px 16px; text-decoration: none; font-weight: 600;">Next</a>
        <?php endif; ?>
    </div>
</div>
<?php endif; ?>
