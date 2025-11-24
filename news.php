<?php 
include 'includes/db.php'; 
$id = $_GET['id'] ?? 0;

// 1. Handle Comment Submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit_comment'])) {
    $name = htmlspecialchars($_POST['username']);
    $comment = htmlspecialchars($_POST['comment']);
    
    // Basic validation
    if(!empty($name) && !empty($comment)){
        $stmt = $conn->prepare("INSERT INTO comments (news_id, username, comment) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $id, $name, $comment);
        $stmt->execute();
        header("Location: news.php?id=$id"); 
        exit;
    }
}

// 2. Fetch Article Data
$stmt = $conn->prepare("SELECT * FROM news WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$news = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $news ? htmlspecialchars($news['title']) : 'Not Found'; ?> | NEXUS</title>
    
    <style>
        /* --- MASTER CSS (EMBEDDED) --- */
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&family=Orbitron:wght@500;700&display=swap');

        :root {
            --bg-dark: #0a0e17;
            --bg-glass: rgba(23, 32, 51, 0.6);
            --primary: #00f2ff;   /* Cyan Neon */
            --secondary: #7000ff; /* Purple Neon */
            --text-main: #e2e8f0;
            --text-muted: #94a3b8;
            --gradient: linear-gradient(135deg, #00f2ff 0%, #7000ff 100%);
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-dark);
            background-image: 
                radial-gradient(circle at 0% 0%, rgba(112, 0, 255, 0.15) 0%, transparent 50%),
                radial-gradient(circle at 100% 100%, rgba(0, 242, 255, 0.1) 0%, transparent 50%);
            color: var(--text-main);
            min-height: 100vh;
            line-height: 1.8;
        }

        /* NAVBAR */
        .navbar {
            background: rgba(10, 14, 23, 0.95);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            padding: 1rem 0;
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        .nav-container {
            max-width: 1000px;
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
        .nav-back {
            color: var(--text-muted);
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9rem;
            transition: 0.3s;
            display: flex;
            align-items: center;
        }
        .nav-back:hover { color: var(--primary); transform: translateX(-5px); }

        /* MAIN CONTAINER */
        .container { max-width: 900px; margin: 0 auto; padding: 40px 20px; }

        /* ARTICLE STYLES */
        .article-header { margin-bottom: 30px; text-align: center; }
        
        .article-title {
            font-family: 'Orbitron', sans-serif;
            font-size: 2.8rem;
            line-height: 1.2;
            margin-bottom: 15px;
            background: linear-gradient(to bottom, #ffffff, #cbd5e1);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .article-meta {
            color: var(--primary);
            font-size: 0.9rem;
            letter-spacing: 1px;
            text-transform: uppercase;
            font-weight: 600;
        }

        .hero-image-wrapper {
            position: relative;
            margin-bottom: 40px;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 20px 50px -10px rgba(0, 0, 0, 0.5);
            border: 1px solid rgba(255,255,255,0.1);
        }

        .hero-image {
            width: 100%;
            height: auto;
            display: block;
            /* Subtle zoom effect on load */
            animation: zoomIn 1.5s ease-out;
        }

        @keyframes zoomIn { from { transform: scale(1.05); } to { transform: scale(1); } }

        .article-body {
            font-size: 1.15rem;
            color: #cbd5e1;
            white-space: pre-line; /* Keeps paragraph breaks */
            margin-bottom: 60px;
        }

        /* COMMENTS SECTION */
        .comments-section {
            background: var(--bg-glass);
            border-top: 1px solid rgba(255, 255, 255, 0.08);
            padding: 40px;
            border-radius: 20px;
            backdrop-filter: blur(10px);
        }

        .section-heading {
            font-family: 'Orbitron', sans-serif;
            font-size: 1.5rem;
            color: white;
            margin-bottom: 25px;
            border-left: 4px solid var(--secondary);
            padding-left: 15px;
        }

        /* FORM */
        .form-group { margin-bottom: 20px; }
        
        .form-input {
            width: 100%;
            background: rgba(0, 0, 0, 0.4);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: white;
            padding: 15px;
            border-radius: 8px;
            font-family: 'Inter', sans-serif;
            font-size: 1rem;
            transition: 0.3s;
            outline: none;
        }
        .form-input:focus {
            border-color: var(--primary);
            background: rgba(0, 0, 0, 0.6);
            box-shadow: 0 0 15px rgba(0, 242, 255, 0.1);
        }

        .btn-submit {
            background: var(--gradient);
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 50px;
            font-weight: bold;
            cursor: pointer;
            text-transform: uppercase;
            transition: 0.3s;
            font-size: 0.9rem;
        }
        .btn-submit:hover { transform: translateY(-2px); box-shadow: 0 0 20px rgba(0, 242, 255, 0.4); }

        /* COMMENT LIST */
        .comment-list { margin-top: 40px; }
        
        .comment-item {
            padding: 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            animation: fadeIn 0.5s ease;
        }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }

        .comment-user { color: var(--primary); font-weight: bold; font-size: 1.05rem; }
        .comment-date { color: #64748b; font-size: 0.8rem; margin-left: 10px; }
        .comment-text { margin-top: 8px; color: #e2e8f0; line-height: 1.6; }
        
        /* 404 STYLE */
        .not-found { text-align: center; padding: 100px 0; }
        .not-found h1 { font-size: 4rem; color: var(--text-muted); font-family: 'Orbitron'; }
    </style>
</head>
<body>

    <nav class="navbar">
        <div class="nav-container">
            <a href="index.php" class="logo">NEXUS<span style="color:var(--primary)">.TECH</span></a>
            <a href="index.php" class="nav-back">&larr; Back to Hub</a>
        </div>
    </nav>

    <div class="container">
        <?php if($news): ?>
            
            <header class="article-header">
                <div class="article-meta">
                    Published on <?php echo date("F j, Y", strtotime($news['created_at'])); ?>
                </div>
                <h1 class="article-title"><?php echo htmlspecialchars($news['title']); ?></h1>
            </header>

            <?php if($news['image']): ?>
                <div class="hero-image-wrapper">
                    <img src="assets/uploads/<?php echo $news['image']; ?>" class="hero-image" alt="Article Image">
                </div>
            <?php endif; ?>

            <article class="article-body">
                <?php echo htmlspecialchars($news['content']); ?>
            </article>

            <div class="comments-section">
                <h3 class="section-heading">Join the Discussion</h3>
                
                <form method="POST">
                    <div class="form-group">
                        <input type="text" name="username" class="form-input" placeholder="Enter your alias..." required autocomplete="off">
                    </div>
                    <div class="form-group">
                        <textarea name="comment" class="form-input" rows="3" placeholder="Share your insights..." required></textarea>
                    </div>
                    <button type="submit" name="submit_comment" class="btn-submit">Post Comment</button>
                </form>

                <div class="comment-list">
                    <?php
                    $c_stmt = $conn->prepare("SELECT * FROM comments WHERE news_id = ? ORDER BY id DESC");
                    $c_stmt->bind_param("i", $id);
                    $c_stmt->execute();
                    $comments = $c_stmt->get_result();
                    
                    if($comments->num_rows > 0) {
                        while($c = $comments->fetch_assoc()){
                            echo '<div class="comment-item">';
                            echo '<div><span class="comment-user">'.htmlspecialchars($c['username']).'</span>';
                            echo '<span class="comment-date">'.date("M d, H:i", strtotime($c['created_at'])).'</span></div>';
                            echo '<div class="comment-text">'.htmlspecialchars($c['comment']).'</div>';
                            echo '</div>';
                        }
                    } else {
                        echo '<p style="color:#64748b; margin-top:20px;">No comments yet. Be the first to initiate discussion.</p>';
                    }
                    ?>
                </div>
            </div>

        <?php else: ?>
            <div class="not-found">
                <h1>404</h1>
                <p>Signal Lost. This article does not exist in the database.</p>
                <a href="index.php" class="btn-submit" style="text-decoration:none; display:inline-block; margin-top:20px;">Return Home</a>
            </div>
        <?php endif; ?>
    </div>

</body>
</html>