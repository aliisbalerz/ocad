<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OCAD Management System - Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="login-body">

<div class="login-card">
    
    <div class="login-header">
        <div class="logo-box">
            <span>MSU</span>
            <span>TCTO</span>
        </div>
        <div class="header-text">
            <h2>Office of Cultural Affairs & Development</h2>
            <p>Creating Opportunities · Transforming Lives</p>
        </div>
    </div>

    <div class="welcome-section">
        <h1>Welcome back</h1>
        <p>Sign in to access the profiling system</p>
    </div>

    <form action="dashboard.php" method="POST" class="login-form">
        <div class="input-group">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" placeholder="admin" required>
        </div>
        
        <div class="input-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="••••••••" required>
        </div>

        <div class="input-group">
            <label for="role">Role</label>
            <select id="role" name="role">
                <option value="staff">OCAD Staff</option>
                <option value="admin">Administrator</option>
                <option value="student">Student</option>
            </select>
        </div>

        <button type="submit" class="login-btn">Sign in</button>
    </form>

    <div class="login-footer">
        MSU-TCTO · Tawi-Tawi · Academic Year 2024–2025
    </div>

</div>

</body>
</html>