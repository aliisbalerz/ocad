<?php
include "db.php";

// 1. Handle Add Staff Logic
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["action"]) && $_POST["action"] == "add") {
    $staff_id = mysqli_real_escape_string($conn, $_POST["staff_id"]);
    $name = mysqli_real_escape_string($conn, $_POST["name"]);
    $position = mysqli_real_escape_string($conn, $_POST["position"]);
    $department = mysqli_real_escape_string($conn, $_POST["department"]);
    $email = mysqli_real_escape_string($conn, $_POST["email"]);

    $sql = "INSERT INTO staff (staff_id, name, position, department, email) VALUES ('$staff_id', '$name', '$position', '$department', '$email')";
    mysqli_query($conn, $sql);
    header("Location: staff.php");
    exit();
}

// 2. Handle Edit Staff Logic
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["action"]) && $_POST["action"] == "edit") {
    $id = mysqli_real_escape_string($conn, $_POST["id"]);
    $staff_id = mysqli_real_escape_string($conn, $_POST["staff_id"]);
    $name = mysqli_real_escape_string($conn, $_POST["name"]);
    $position = mysqli_real_escape_string($conn, $_POST["position"]);
    $department = mysqli_real_escape_string($conn, $_POST["department"]);
    $email = mysqli_real_escape_string($conn, $_POST["email"]);

    $sql = "UPDATE staff SET staff_id='$staff_id', name='$name', position='$position', department='$department', email='$email' WHERE id='$id'";
    mysqli_query($conn, $sql);
    header("Location: staff.php");
    exit();
}

// 3. Handle Delete Staff Logic
if (isset($_GET["action"]) && $_GET["action"] == "delete" && isset($_GET["id"])) {
    $id = mysqli_real_escape_string($conn, $_GET["id"]);
    $sql = "DELETE FROM staff WHERE id='$id'";
    mysqli_query($conn, $sql);
    header("Location: staff.php");
    exit();
}

$search = "";
if (isset($_GET["search"])) {
    $search = $_GET["search"];
}

$sql = "SELECT * FROM staff
        WHERE staff_id LIKE '%$search%'
        OR name LIKE '%$search%'
        OR position LIKE '%$search%'
        ORDER BY id DESC";

$result = mysqli_query($conn, $sql);
$total_users = mysqli_num_rows($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OCAD - User Accounts</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="dashboard-body">

<div class="dashboard-layout">
    
    <!-- Sidebar -->
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
            <a href="dashboard.php" class="menu-item">Dashboard</a>
            <a href="students.php" class="menu-item">Members</a>
            
            <p class="menu-label">REPORTS</p>
            <a href="#" class="menu-item">Reports</a>
            
            <p class="menu-label">ADMIN</p>
            <a href="staff.php" class="menu-item active">User accounts</a>
        </div>

        <div class="sidebar-footer">
            <div class="user-profile">
                <div class="avatar">S</div>
                <div class="user-info">
                    <strong>OCAD Staff</strong>
                    <span>Staff</span>
                </div>
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        
        <!-- Topbar -->
        <header class="topbar">
            <div class="breadcrumbs">
                MSU-TCTO OCAD <span class="divider">/</span> <strong>User accounts</strong>
            </div>
            
            <div class="topbar-actions">
                <form method="GET" class="search-form">
                    <input 
                        type="text" 
                        name="search" 
                        placeholder="Search staff..." 
                        value="<?php echo htmlspecialchars($search); ?>"
                    >
                </form>
                <button class="btn-primary" onclick="openModal('addModal')">+ Add user</button>
            </div>
        </header>

        <!-- Page Content -->
        <div class="page-content user-accounts-layout">
            
            <!-- Left Column: User Cards -->
            <div class="main-column">
                <div class="section-header">
                    <h3>System users</h3>
                    <span class="count"><?php echo $total_users; ?> accounts</span>
                </div>

                <div class="user-cards-grid">
                    <?php
                    if ($total_users > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                    <div class="user-card">
                        <div class="card-header">
                            <div class="card-avatar">
                                <?php echo strtoupper(substr($row["name"], 0, 1)); ?>
                            </div>
                            <div class="card-title">
                                <h4><?php echo htmlspecialchars($row["name"]); ?></h4>
                                <span><?php echo htmlspecialchars($row["staff_id"]); ?></span>
                            </div>
                            <span class="role-badge">Staff</span>
                        </div>
                        
                        <div class="card-body">
                            <p><strong>Position:</strong> <?php echo htmlspecialchars($row["position"]); ?></p>
                            <p><strong>Dept:</strong> <?php echo htmlspecialchars($row["department"]); ?></p>
                            <p><strong>Email:</strong> <?php echo htmlspecialchars($row["email"]); ?></p>
                        </div>

                        <div class="card-actions">
                            <button class="btn-outline" style="cursor:pointer;" 
                                onclick="openEditModal('<?php echo $row['id']; ?>', '<?php echo htmlspecialchars($row['staff_id'], ENT_QUOTES); ?>', '<?php echo htmlspecialchars($row['name'], ENT_QUOTES); ?>', '<?php echo htmlspecialchars($row['position'], ENT_QUOTES); ?>', '<?php echo htmlspecialchars($row['department'], ENT_QUOTES); ?>', '<?php echo htmlspecialchars($row['email'], ENT_QUOTES); ?>')">
                                Edit
                            </button>
                            <a href="staff.php?action=delete&id=<?php echo $row['id']; ?>" class="btn-outline danger" onclick="return confirm('Delete this staff member?');">Delete</a>
                        </div>
                    </div>
                    <?php
                        }
                    } else {
                        echo "<p>No staff found.</p>";
                    }
                    ?>
                </div>
            </div>

            <!-- Right Column: Sidebar Widgets -->
            <div class="side-column">
                <div class="widget card-panel">
                    <h4>SYSTEM INFO</h4>
                    <ul class="info-list">
                        <li><span>System version</span> <strong>v1.0.0</strong></li>
                        <li><span>Academic year</span> <strong>2024–2025</strong></li>
                        <li><span>Semester</span> <strong>2nd Sem</strong></li>
                        <li><span>Total users</span> <strong><?php echo $total_users; ?></strong></li>
                    </ul>
                </div>

                <div class="widget card-panel">
                    <h4>QUICK ACTIONS</h4>
                    <ul class="action-list">
                        <li><a href="#" onclick="openModal('addModal'); return false;">Add new user &rarr;</a></li>
                        <li><a href="index.php">Log out &rarr;</a></li>
                    </ul>
                </div>
            </div>

        </div>
    </main>
</div>

<!-- Add User Modal -->
<div id="addModal" class="modal-overlay">
    <div class="modal-card">
        <h3>Add new user</h3>
        <form action="staff.php" method="POST">
            <input type="hidden" name="action" value="add">
            <div class="form-row">
                <div class="input-group"><label>Staff ID</label><input type="text" name="staff_id" required></div>
                <div class="input-group"><label>Full Name</label><input type="text" name="name" required></div>
            </div>
            <div class="form-row">
                <div class="input-group"><label>Position</label><input type="text" name="position" required></div>
                <div class="input-group"><label>Department</label><input type="text" name="department" required></div>
            </div>
            <div class="form-row">
                <div class="input-group" style="width:100%;"><label>Email</label><input type="email" name="email" required></div>
            </div>
            <div class="modal-actions">
                <button type="button" class="btn-secondary" onclick="closeModal('addModal')">Cancel</button>
                <button type="submit" class="btn-primary">Save user</button>
            </div>
        </form>
    </div>
</div>

<!-- Edit User Modal -->
<div id="editModal" class="modal-overlay">
    <div class="modal-card">
        <h3>Edit user account</h3>
        <form action="staff.php" method="POST">
            <input type="hidden" name="action" value="edit">
            <input type="hidden" name="id" id="edit_id">
            <div class="form-row">
                <div class="input-group"><label>Staff ID</label><input type="text" name="staff_id" id="edit_staff_id" required></div>
                <div class="input-group"><label>Full Name</label><input type="text" name="name" id="edit_name" required></div>
            </div>
            <div class="form-row">
                <div class="input-group"><label>Position</label><input type="text" name="position" id="edit_position" required></div>
                <div class="input-group"><label>Department</label><input type="text" name="department" id="edit_department" required></div>
            </div>
            <div class="form-row">
                <div class="input-group" style="width:100%;"><label>Email</label><input type="email" name="email" id="edit_email" required></div>
            </div>
            <div class="modal-actions">
                <button type="button" class="btn-secondary" onclick="closeModal('editModal')">Cancel</button>
                <button type="submit" class="btn-primary">Save changes</button>
            </div>
        </form>
    </div>
</div>

<script>
function openModal(id) { document.getElementById(id).style.display = 'flex'; }
function closeModal(id) { document.getElementById(id).style.display = 'none'; }
function openEditModal(id, staff_id, name, position, department, email) {
    document.getElementById('edit_id').value = id;
    document.getElementById('edit_staff_id').value = staff_id;
    document.getElementById('edit_name').value = name;
    document.getElementById('edit_position').value = position;
    document.getElementById('edit_department').value = department;
    document.getElementById('edit_email').value = email;
    openModal('editModal');
}
</script>

</body>
</html>