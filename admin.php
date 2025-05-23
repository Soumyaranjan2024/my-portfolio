<?php
require 'auth.php';

if (!isAdminLoggedIn()) {
    header('Location: login.php');
    exit;
}

require 'database.php';

// Handle CRUD operations
require 'admin_operations.php';

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Soumya's Portfolio</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* Admin styles */
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }

        .admin-container {
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 250px;
            background-color: #2c2b3d;
            color: white;
            padding: 20px 0;
        }

        .sidebar-header {
            padding: 0 20px 20px;
            border-bottom: 1px solid #444;
        }

        .sidebar-menu {
            list-style: none;
            padding: 0;
        }

        .sidebar-menu li a {
            display: block;
            padding: 12px 20px;
            color: white;
            text-decoration: none;
            transition: all 0.3s;
        }

        .sidebar-menu li a:hover {
            background-color: #6c63ff;
        }

        .sidebar-menu li a.active {
            background-color: #6c63ff;
        }

        .sidebar-menu li a i {
            margin-right: 10px;
        }

        .main-content {
            flex: 1;
            padding: 20px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
            background-color: white;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .card {
            background-color: white;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th,
        table td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        table th {
            background-color: #f9f9f9;
        }

        .btn {
            padding: 8px 15px;
            border-radius: 4px;
            cursor: pointer;
            border: none;
            font-size: 14px;
        }

        .btn-primary {
            background-color: #6c63ff;
            color: white;
        }

        .btn-danger {
            background-color: #dc3545;
            color: white;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
        }

        .form-group input,
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-family: 'Poppins', sans-serif;
        }

        .form-group textarea {
            height: 100px;
        }
    </style>
</head>

<body>
    <div class="admin-container">
        <div class="sidebar">
            <div class="sidebar-header">
                <h2>Admin Panel</h2>
                <p>Welcome, <?php echo $_SESSION['admin_username']; ?></p>
            </div>
            <ul class="sidebar-menu">
                <li><a href="admin.php?section=dashboard"
                        class="<?php echo (!isset($_GET['section']) || $_GET['section'] == 'dashboard') ? 'active' : ''; ?>"><i
                            class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                <li><a href="admin.php?section=projects"
                        class="<?php echo (isset($_GET['section']) && $_GET['section'] == 'projects') ? 'active' : ''; ?>"><i
                            class="fas fa-project-diagram"></i> Projects</a></li>
                <li><a href="admin.php?section=skills"
                        class="<?php echo (isset($_GET['section']) && $_GET['section'] == 'skills') ? 'active' : ''; ?>"><i
                            class="fas fa-code"></i> Skills</a></li>
                <li><a href="admin.php?section=messages"
                        class="<?php echo (isset($_GET['section']) && $_GET['section'] == 'messages') ? 'active' : ''; ?>"><i
                            class="fas fa-envelope"></i> Messages</a></li>
                <li><a href="?logout=1"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
            </ul>
        </div>
        <div class="main-content">
            <div class="header">
                <h2><?php echo ucfirst(isset($_GET['section']) ? $_GET['section'] : 'dashboard'); ?></h2>
                <a href="../index.php" target="_blank" class="btn btn-primary">View Portfolio</a>
            </div>

            <?php
            $section = isset($_GET['section']) ? $_GET['section'] : 'dashboard';

            switch ($section) {
                case 'dashboard':
                    include 'admin_dashboard.php';
                    break;
                case 'projects':
                    include 'admin_projects.php';
                    break;
                case 'skills':
                    include 'admin_skills.php';
                    break;
                case 'messages':
                    include 'admin_messages.php';
                    break;
                default:
                    include 'admin_dashboard.php';
            }
            ?>
        </div>
    </div>
</body>

</html>