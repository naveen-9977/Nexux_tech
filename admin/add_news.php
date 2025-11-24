<?php
session_start();
include '../includes/db.php';

// 1. Security Check
if (!isset($_SESSION['admin'])) { header("Location: login.php"); exit; }

// 2. Handle Form Submission
if (isset($_POST['submit'])) {
    $title = htmlspecialchars($_POST['title']);
    $content = htmlspecialchars($_POST['content']);
    $image = $_FILES['image']['name'];
    
    // Upload Image logic
    if($image) {
        // Ensure the 'uploads' folder exists in assets
        $target_dir = "../assets/uploads/";
        if (!is_dir($target_dir)) { mkdir($target_dir, 0777, true); }
        
        $target_file = $target_dir . basename($image);
        move_uploaded_file($_FILES['image']['tmp_name'], $target_file);
    }

    // Insert into DB
    $stmt = $conn->prepare("INSERT INTO news (title, content, image) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $title, $content, $image);
    
    if ($stmt->execute()) {
        // Redirect to Dashboard on success
        header("Location: index.php"); 
        exit;
    } else {
        $error = "Database Error: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Article | NEXUS ADMIN</title>
    
    <style>
        /* --- EMBEDDED MASTER CSS --- */
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&family=Orbitron:wght@500;700&display=swap');

        :root {
            --bg-dark: #0a0e17;
            --primary: #00f2ff;
            --secondary: #7000ff;
            --text-main: #e2e8f0;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-dark);
            background-image: 
                radial-gradient(circle at 5% 10%, rgba(112, 0, 255, 0.15) 0%, transparent 40%),
                radial-gradient(circle at 95% 90%, rgba(0, 242, 255, 0.15) 0%, transparent 40%);
            color: var(--text-main);
            min-height: 100vh;
        }

        /* NAVBAR */
        .navbar {
            background: rgba(10, 14, 23, 0.9);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            padding: 1rem 0;
            position: sticky;
            top: 0;
            z-index: 100;
        }
        .nav-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .logo {
            font-family: 'Orbitron', sans-serif;
            font-size: 1.5rem;
            font-weight: 700;
            color: white;
            text-decoration: none;
        }
        .nav-links a {
            color: #94a3b8;
            text-decoration: none;
            margin-left: 20px;
            font-size: 0.9rem;
            transition: 0.3s;
        }
        .nav-links a:hover { color: var(--primary); }

        /* FORM CONTAINER */
        .container { max-width: 800px; margin: 50px auto; padding: 0 20px; }
        
        .form-card {
            background: rgba(23, 32, 51, 0.6);
            backdrop-filter: blur(15px);
            padding: 40px;
            border-radius: 16px;
            border: 1px solid rgba(255,255,255,0.05);
            box-shadow: 0 20px 50px rgba(0,0,0,0.3);
        }

        h2.section-title {
            font-family: 'Orbitron', sans-serif;
            text-align: center;
            margin-bottom: 30px;
            color: white;
            font-size: 1.8rem;
            letter-spacing: 1px;
        }

        /* INPUTS */
        label {
            display: block;
            margin-bottom: 8px;
            color: var(--primary);
            font-weight: 600;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        input[type="text"], textarea, input[type="file"] {
            width: 100%;
            background: rgba(0,0,0,0.3);
            border: 1px solid rgba(255,255,255,0.1);
            padding: 15px;
            color: white;
            border-radius: 8px;
            margin-bottom: 25px;
            font-family: 'Inter', sans-serif;
            font-size: 1rem;
            transition: 0.3s;
            outline: none;
        }

        input[type="text"]:focus, textarea:focus {
            border-color: var(--primary);
            box-shadow: 0 0 15px rgba(0, 242, 255, 0.2);
            background: rgba(0,0,0,0.5);
        }

        textarea { resize: vertical; min-height: 250px; line-height: 1.6; }

        /* FILE INPUT STYLE */
        input[type="file"] {
            padding: 10px;
            background: rgba(255,255,255,0.05);
            cursor: pointer;
        }

        /* BUTTON */
        .btn-submit {
            background: linear-gradient(135deg, #00f2ff 0%, #7000ff 100%);
            color: white;
            border: none;
            padding: 15px 40px;
            border-radius: 50px;
            font-weight: bold;
            cursor: pointer;
            font-size: 1rem;
            transition: 0.3s;
            width: 100%;
            font-family: 'Orbitron', sans-serif;
            letter-spacing: 1px;
        }

        .btn-submit:hover {
            box-shadow: 0 0 30px rgba(112, 0, 255, 0.5);
            transform: translateY(-2px);
        }
        
        .error-msg {
            color: #ff4444;
            background: rgba(255, 68, 68, 0.1);
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
            border: 1px solid #ff4444;
        }
    </style>
</head>
<body>

    <!-- NAVBAR -->
    <nav class="navbar">
        <div class="nav-container">
            <a href="index.php" class="logo">NEXUS<span style="color:var(--primary)">.ADMIN</span></a>
            <div class="nav-links">
                <a href="index.php">&larr; Cancel & Return</a>
            </div>
        </div>
    </nav>

    <!-- FORM SECTION -->
    <div class="container">
        <div class="form-card">
            <h2 class="section-title">Create New Transmission</h2>
            
            <?php if(isset($error)): ?>
                <div class="error-msg"><?php echo $error; ?></div>
            <?php endif; ?>

            <form method="POST" enctype="multipart/form-data">
                <!-- Title -->
                <label>Article Headline</label>
                <input type="text" name="title" placeholder="E.g., AI Takeover: The New Era" required autocomplete="off">
                
                <!-- Content -->
                <label>Full Report</label>
                <textarea name="content" placeholder="Type your detailed article content here..." required></textarea>
                
                <!-- Image -->
                <label>Visual Attachment</label>
                <input type="file" name="image" accept="image/*">
                
                <!-- Submit -->
                <button type="submit" name="submit" class="btn-submit">PUBLISH TO NETWORK</button>
            </form>
        </div>
    </div>

</body>
</html>