<?php
include "db.php";

$students_result = mysqli_query($conn, "SELECT COUNT(*) as total FROM students");
$students_count = mysqli_fetch_assoc($students_result)['total'];

$staff_result = mysqli_query($conn, "SELECT COUNT(*) as total FROM staff");
$staff_count = mysqli_fetch_assoc($staff_result)['total'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OCAD - Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="dashboard-body">

<div class="dashboard-layout">
    
    <aside class="sidebar">
        <div class="sidebar-header">
            <div class="logo-box">
                <span>MSU</span>
                <span>TCTO</span>
            </div>
            <div class="header-text">
                <h2>Office of Cultural Affairs & Development</h2>
                <p>Creating Opportunities · Transforming Lives</p>
            </div>
        </div>

        <div class="sidebar-menu">
            <p class="menu-label">MENU</p>
            <a href="dashboard.php" class="menu-item active">Dashboard</a>
            <a href="students.php" class="menu-item">Members</a>
            
            <p class="menu-label">REPORTS</p>
            <a href="#" class="menu-item">Reports</a>
            
            <p class="menu-label">ADMIN</p>
            <a href="staff.php" class="menu-item">User accounts</a>
        </div>

        <div class="sidebar-footer" style="display: flex; flex-direction: column; gap: 12px;">
            <div class="user-profile">
                <div class="avatar">S</div>
                <div class="user-info">
                    <strong>OCAD Staff</strong>
                    <span>Staff</span>
                </div>
            </div>
            <a href="index.php" style="display: block; text-align: center; background: rgba(255, 255, 255, 0.1); color: #fff; padding: 8px; border-radius: 6px; text-decoration: none; font-size: 0.85rem; font-weight: 500; transition: background 0.2s;">Log out</a>
        </div>
    </aside>

    <main class="main-content">
        <header class="topbar">
            <div class="breadcrumbs">
                MSU-TCTO OCAD <span class="divider">/</span> <strong>Dashboard</strong>
            </div>
            <div class="topbar-actions">
                <button class="btn-primary" onclick="location.href='students.php'">+ Manage Members</button>
            </div>
        </header>

        <div class="page-content">
            <div class="card-panel" style="margin-bottom: 24px; background: linear-gradient(135deg, #7a0000, #4a0000); color: white;">
                <h2>Welcome to OCAD Management System</h2>
                <p style="margin-top: 8px; opacity: 0.9;">Here is an overview of the cultural affairs records, members, and user accounts system.</p>
            </div>

            <div class="stats-grid" style="margin-bottom: 24px;">
                <div class="stat-card">
                    <span>TOTAL MEMBERS</span>
                    <h2><?php echo $students_count; ?></h2>
                </div>
                <div class="stat-card">
                    <span>SYSTEM STAFF</span>
                    <h2><?php echo $staff_count; ?></h2>
                </div>
                <div class="stat-card">
                    <span>ACTIVE SEMESTER</span>
                    <h2 style="font-size: 1.5rem; margin-top: 5px;">2nd Sem</h2>
                </div>
                <div class="stat-card">
                    <span>ACADEMIC YEAR</span>
                    <h2 style="font-size: 1.5rem; margin-top: 5px;">2024–2025</h2>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px;">
                <div class="card-panel" style="display: flex; flex-direction: column; justify-content: space-between;">
                    <div>
                        <h3 style="margin-bottom: 10px; color: #7a0000;">Members Management</h3>
                        <p style="color: #666; font-size: 0.95rem; margin-bottom: 20px;">View, add, edit, or delete student member records registered under OCAD.</p>
                    </div>
                    <a href="students.php" class="btn-primary" style="text-align: center; text-decoration: none; display: block;">Go to Members &rarr;</a>
                </div>

                <div class="card-panel" style="display: flex; flex-direction: column; justify-content: space-between;">
                    <div>
                        <h3 style="margin-bottom: 10px; color: #7a0000;">Staff User Accounts</h3>
                        <p style="color: #666; font-size: 0.95rem; margin-bottom: 20px;">Manage administrative accounts, update staff positions, and handle credentials.</p>
                    </div>
                    <a href="staff.php" class="btn-primary" style="text-align: center; text-decoration: none; display: block;">Go to User Accounts &rarr;</a>
                </div>
            </div>
        </div>
    </main>
</div>

</body>
</html>