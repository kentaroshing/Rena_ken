<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>School Student CRUD</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #e6f2e6;
            margin: 0;
            padding: 0;
        }
        header {
            background: linear-gradient(135deg, #a8d5a8, #4caf50);
            padding: 10px 20px;
            display: flex;
            align-items: center;
            box-shadow: 0 4px 8px rgba(0,128,0,0.2);
            animation: slideDown 0.5s ease forwards;
        }
        @keyframes slideDown {
            from { transform: translateY(-100%); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
        header img.logo {
            height: 50px;
            margin-right: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.3);
        }
        header h1 {
            color: white;
            font-weight: 700;
            font-size: 1.8rem;
            margin: 0;
            user-select: none;
        }
        nav {
            margin-left: auto;
        }
        nav a {
            color: white;
            text-decoration: none;
            margin-left: 20px;
            font-weight: 600;
            transition: color 0.3s ease;
        }
        nav a:hover {
            color: #d4f1d4;
        }
    </style>
</head>
<body>
<header>
    <?php if (file_exists('public/uploads/school_logo.png')): ?>
        <img src="<?= site_url('public/uploads/school_logo.png') ?>" alt="School Logo" class="logo" />
    <?php else: ?>
        <img src="<?= site_url('public/images/default_logo.png') ?>" alt="Default Logo" class="logo" />
    <?php endif; ?>
    <h1>School Student CRUD</h1>
    <nav>
        <a href="<?= site_url('students') ?>">Students</a>
        <a href="<?= site_url('logo/upload') ?>">Upload Logo</a>
    </nav>
</header>
</body>
</html>
