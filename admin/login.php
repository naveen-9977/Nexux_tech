<?php
session_start();
// Handle Login Logic
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Hardcoded credentials: admin / admin123
    if ($_POST['username'] == 'admin' && $_POST['password'] == 'admin123') {
        $_SESSION['admin'] = true;
        header("Location: index.php");
        exit;
    } else {
        $error = "ACCESS DENIED: Invalid Credentials";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>System Login | NEXUS</title>
    
    <style>
        /* IMPORT FONTS */
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&family=Orbitron:wght@500;700&display=swap');

        :root {
            --bg-dark: #0a0e17;
            --primary: #00f2ff;   /* Cyan */
            --secondary: #7000ff; /* Purple */
            --error: #ff3333;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-dark);
            /* Matching the Home Page Background */
            background-image: 
                radial-gradient(circle at 20% 20%, rgba(112, 0, 255, 0.2) 0%, transparent 40%),
                radial-gradient(circle at 80% 80%, rgba(0, 242, 255, 0.15) 0%, transparent 40%);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
        }

        /* LOGIN CARD DESIGN */
        .login-card {
            background: rgba(23, 32, 51, 0.6); /* See-through dark glass */
            backdrop-filter: blur(20px);       /* The Blur Effect */
            padding: 50px 40px;
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.08);
            width: 100%;
            max-width: 420px;
            box-shadow: 0 0 50px rgba(0, 0, 0, 0.5); /* Deep shadow */
            text-align: center;
            position: relative;
            transition: transform 0.3s ease;
        }

        .login-card:hover {
            border-color: rgba(0, 242, 255, 0.3); /* Glow border on hover */
            box-shadow: 0 0 60px rgba(0, 242, 255, 0.15);
        }

        /* TYPOGRAPHY */
        .login-card h2 {
            font-family: 'Orbitron', sans-serif;
            font-size: 2rem;
            margin-bottom: 10px;
            color: white;
            letter-spacing: 2px;
            text-transform: uppercase;
        }
        
        .subtitle {
            color: #94a3b8;
            font-size: 0.85rem;
            margin-bottom: 30px;
            display: block;
            letter-spacing: 1px;
        }

        /* INPUT FIELDS */
        .input-group { margin-bottom: 20px; text-align: left; }
        
        .input-group label {
            display: block;
            color: var(--primary);
            font-size: 0.75rem;
            margin-bottom: 8px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        input {
            width: 100%;
            padding: 15px;
            background: rgba(0, 0, 0, 0.4);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: white;
            border-radius: 8px;
            font-family: 'Inter', sans-serif;
            transition: 0.3s;
            outline: none;
        }

        input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 15px rgba(0, 242, 255, 0.2);
            background: rgba(0, 0, 0, 0.6);
        }

        /* BUTTONS */
        .btn-login {
            width: 100%;
            padding: 15px;
            margin-top: 10px;
            background: linear-gradient(135deg, #00f2ff 0%, #7000ff 100%);
            border: none;
            color: white;
            font-weight: bold;
            border-radius: 50px;
            cursor: pointer;
            transition: 0.3s;
            font-family: 'Orbitron', sans-serif;
            letter-spacing: 1px;
            font-size: 1rem;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 0 25px rgba(0, 242, 255, 0.6);
        }

        /* UTILITIES */
        .error-msg {
            background: rgba(255, 51, 51, 0.1);
            border: 1px solid var(--error);
            color: var(--error);
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 0.9rem;
        }

        .back-link {
            margin-top: 25px;
            display: block;
            color: #64748b;
            text-decoration: none;
            font-size: 0.8rem;
            transition: 0.3s;
        }
        .back-link:hover { color: var(--primary); }
    </style>
</head>
<body>

    <div class="login-card">
        <h2>NEXUS</h2>
        <span class="subtitle">ADMINISTRATION TERMINAL</span>

        <?php if(isset($error)): ?>
            <div class="error-msg"><?php echo $error; ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="input-group">
                <label>Operator ID</label>
                <input type="text" name="username" placeholder="Enter Username" autocomplete="off" required>
            </div>

            <div class="input-group">
                <label>Access Key</label>
                <input type="password" name="password" placeholder="Enter Password" required>
            </div>

            <button type="submit" class="btn-login">AUTHENTICATE</button>
        </form>

        <a href="../index.php" class="back-link">&larr; Return to Public Portal</a>
    </div>

</body>
</html>