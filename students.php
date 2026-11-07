<?php
include "db.php";

// 1. Handle Add Student Logic
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["action"]) && $_POST["action"] == "add") {
    $name = mysqli_real_escape_string($conn, $_POST["first_name"] . ' ' . $_POST["last_name"]);
    $student_id = mysqli_real_escape_string($conn, $_POST["student_id"]);
    $course = mysqli_real_escape_string($conn, $_POST["course"]);
    $year_level = mysqli_real_escape_string($conn, $_POST["year_level"]);

    $sql = "INSERT INTO students (student_id, name, course, year_level, merits, demerits) VALUES ('$student_id', '$name', '$course', '$year_level', 0, 0)";
    mysqli_query($conn, $sql);
    header("Location: students.php");
    exit();
}

// 2. Handle Edit Student Logic
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["action"]) && $_POST["action"] == "edit") {
    $id = mysqli_real_escape_string($conn, $_POST["id"]);
    $name = mysqli_real_escape_string($conn, $_POST["first_name"] . ' ' . $_POST["last_name"]);
    $student_id = mysqli_real_escape_string($conn, $_POST["student_id"]);
    $course = mysqli_real_escape_string($conn, $_POST["course"]);
    $year_level = mysqli_real_escape_string($conn, $_POST["year_level"]);

    $sql = "UPDATE students SET student_id='$student_id', name='$name', course='$course', year_level='$year_level' WHERE id='$id'";
    mysqli_query($conn, $sql);
    header("Location: students.php");
    exit();
}

// 3. Handle Delete Student Logic
if (isset($_GET["action"]) && $_GET["action"] == "delete" && isset($_GET["id"])) {
    $id = mysqli_real_escape_string($conn, $_GET["id"]);
    $sql = "DELETE FROM students WHERE id='$id'";
    mysqli_query($conn, $sql);
    header("Location: students.php");
    exit();
}

// 4. Handle Merit / Demerit Increment Logic
if (isset($_GET["action"]) && ($_GET["action"] == "add_merit" || $_GET["action"] == "add_demerit") && isset($_GET["id"])) {
    $id = mysqli_real_escape_string($conn, $_GET["id"]);
    $column = ($_GET["action"] == "add_merit") ? "merits" : "demerits";
    $sql = "UPDATE students SET $column = $column + 1 WHERE id='$id'";
    mysqli_query($conn, $sql);
    header("Location: students.php");
    exit();
}

// Search and fetch records
$search = isset($_GET["search"]) ? $_GET["search"] : "";
$sql = "SELECT * FROM students 
        WHERE student_id LIKE '%$search%'
        OR name LIKE '%$search%'
        OR course LIKE '%$search%'
        ORDER BY id DESC";
$result = mysqli_query($conn, $sql);
$total_members = mysqli_num_rows($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>OCAD - Member Records</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="dashboard-body">

<div class="dashboard-layout">
    
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-header">
            <div class="logo-box"><span>MSU</span><span>TCTO</span></div>
            <div class="header-text">
                <h2>Office of Cultural Affairs & Development</h2>
                <p>Creating Opportunities · Transforming Lives</p>
            </div>
        </div>
        <div class="sidebar-menu">
            <p class="menu-label">MENU</p>
            <a href="dashboard.php" class="menu-item">Dashboard</a>
            <a href="students.php" class="menu-item active">Members</a>
            <p class="menu-label">REPORTS</p>
            <a href="#" class="menu-item">Reports</a>
            <p class="menu-label">ADMIN</p>
            <a href="staff.php" class="menu-item">User accounts</a>
        </div>
        <div class="sidebar-footer">
            <div class="user-profile">
                <div class="avatar">S</div>
                <div class="user-info"><strong>OCAD Staff</strong><span>Staff</span></div>
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        <header class="topbar">
            <div class="breadcrumbs">MSU-TCTO OCAD <span class="divider">/</span> <strong>Member records</strong></div>
            <div class="topbar-actions">
                <form method="GET" class="search-form">
                    <input type="text" name="search" placeholder="Search members..." value="<?php echo htmlspecialchars($search); ?>">
                </form>
                <button class="btn-primary" onclick="openModal('addModal')">+ Add member</button>
            </div>
        </header>

        <div class="page-content">
            <div class="stats-grid">
                <div class="stat-card"><span>TOTAL</span><h2><?php echo $total_members; ?></h2></div>
                <div class="stat-card"><span>ACTIVE</span><h2 class="text-green">132</h2></div>
                <div class="stat-card"><span>ON NOTICE</span><h2 class="text-orange">9</h2></div>
                <div class="stat-card"><span>SUSPENDED</span><h2 class="text-red">4</h2></div>
            </div>

            <div class="content-grid">
                <div class="main-table-container">
                    <div class="table-filters">
                        <span class="filter-title">All members (Merits & Demerits System)</span>
                    </div>
                    <table class="modern-table">
                        <thead>
                            <tr>
                                <th>MEMBER</th>
                                <th>PROGRAM / YEAR</th>
                                <th>STANDING (MERITS / DEMERITS)</th>
                                <th>QUICK ACTIONS</th>
                                <th>ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($total_members > 0) { 
                                while ($row = mysqli_fetch_assoc($result)) { 
                                    $initials = strtoupper(substr($row["name"], 0, 2));
                                    $name_parts = explode(" ", $row["name"], 2);
                                    $fname = $name_parts[0];
                                    $lname = isset($name_parts[1]) ? $name_parts[1] : "";
                            ?>
                            <tr>
                                <td>
                                    <div class="member-cell">
                                        <div class="member-avatar"><?php echo $initials; ?></div>
                                        <div>
                                            <strong><?php echo htmlspecialchars($row["name"]); ?></strong>
                                            <span><?php echo htmlspecialchars($row["student_id"]); ?></span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <?php echo htmlspecialchars($row["course"]); ?><br>
                                    <small style="color:#888;"><?php echo htmlspecialchars($row["year_level"]); ?></small>
                                </td>
                                <td>
                                    <span style="color: #10b981; font-weight: bold;">+<?php echo $row["merits"]; ?> Merit</span> / 
                                    <span style="color: #ef4444; font-weight: bold;"><?php echo $row["demerits"]; ?> Demerit</span>
                                </td>
                                <td>
                                    <div style="display: flex; gap: 6px; align-items: center; white-space: nowrap;">
                                        <a href="students.php?action=add_merit&id=<?php echo $row['id']; ?>" class="btn-outline" style="padding: 4px 8px; font-size:12px; color:#10b981; border-color:#10b981; text-decoration:none; border-radius: 4px;">+ Merit</a>
                                        <a href="students.php?action=add_demerit&id=<?php echo $row['id']; ?>" class="btn-outline" style="padding: 4px 8px; font-size:12px; color:#ef4444; border-color:#ef4444; text-decoration:none; border-radius: 4px;">+ Demerit</a>
                                    </div>
                                </td>
                                <td>
                                    <div style="display: flex; gap: 10px; align-items: center; white-space: nowrap;">
                                        <button type="button" style="background:none; border:none; cursor:pointer; color:#3b82f6; font-weight: 500; padding: 0;" 
                                            onclick="openEditModal('<?php echo $row['id']; ?>', '<?php echo $fname; ?>', '<?php echo $lname; ?>', '<?php echo $row['student_id']; ?>', '<?php echo $row['course']; ?>', '<?php echo $row['year_level']; ?>')">
                                            Edit
                                        </button>
                                        <a href="students.php?action=delete&id=<?php echo $row['id']; ?>" style="color:#ef4444; text-decoration:none; font-weight: 500;" onclick="return confirm('Delete member?');">Delete</a>
                                    </div>
                                </td>
                            </tr>
                            <?php } } else { ?>
                            <tr><td colspan="5" style="text-align: center; padding: 20px;">No members found.</td></tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
</div>

<!-- Add Member Modal -->
<div id="addModal" class="modal-overlay">
    <div class="modal-card">
        <h3>Add new member</h3>
        <form action="students.php" method="POST">
            <input type="hidden" name="action" value="add">
            <div class="form-row">
                <div class="input-group"><label>First name</label><input type="text" name="first_name" required></div>
                <div class="input-group"><label>Last name</label><input type="text" name="last_name" required></div>
            </div>
            <div class="form-row">
                <div class="input-group"><label>Student ID</label><input type="text" name="student_id" required></div>
                <div class="input-group"><label>Program</label>
                    <select name="course"><option value="BSIT">BSIT</option><option value="BSCS">BSCS</option><option value="BSEd">BSEd</option></select>
                </div>
            </div>
            <div class="form-row">
                <div class="input-group"><label>Year level</label>
                    <select name="year_level"><option value="1st Year">1st Year</option><option value="2nd Year">2nd Year</option><option value="3rd Year">3rd Year</option><option value="4th Year">4th Year</option></select>
                </div>
            </div>
            <div class="modal-actions">
                <button type="button" class="btn-secondary" onclick="closeModal('addModal')">Cancel</button>
                <button type="submit" class="btn-primary">Save member</button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Member Modal -->
<div id="editModal" class="modal-overlay">
    <div class="modal-card">
        <h3>Edit member profile</h3>
        <form action="students.php" method="POST">
            <input type="hidden" name="action" value="edit">
            <input type="hidden" name="id" id="edit_id">
            <div class="form-row">
                <div class="input-group"><label>First name</label><input type="text" name="first_name" id="edit_first_name" required></div>
                <div class="input-group"><label>Last name</label><input type="text" name="last_name" id="edit_last_name" required></div>
            </div>
            <div class="form-row">
                <div class="input-group"><label>Student ID</label><input type="text" name="student_id" id="edit_student_id" required></div>
                <div class="input-group"><label>Program</label>
                    <select name="course" id="edit_course"><option value="BSIT">BSIT</option><option value="BSCS">BSCS</option><option value="BSEd">BSEd</option></select>
                </div>
            </div>
            <div class="form-row">
                <div class="input-group"><label>Year level</label>
                    <select name="year_level" id="edit_year_level"><option value="1st Year">1st Year</option><option value="2nd Year">2nd Year</option><option value="3rd Year">3rd Year</option><option value="4th Year">4th Year</option></select>
                </div>
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
function openEditModal(id, fname, lname, student_id, course, year_level) {
    document.getElementById('edit_id').value = id;
    document.getElementById('edit_first_name').value = fname;
    document.getElementById('edit_last_name').value = lname;
    document.getElementById('edit_student_id').value = student_id;
    document.getElementById('edit_course').value = course;
    document.getElementById('edit_year_level').value = year_level;
    openModal('editModal');
}
</script>

</body>
</html>