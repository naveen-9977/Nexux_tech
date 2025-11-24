<?php
session_start();
include '../includes/db.php';

if (!isset($_SESSION['admin'])) { header("Location: login.php"); exit; }
$id = $_GET['id'] ?? 0;

// 1. Logic to Delete a Comment
if (isset($_GET['del_comment'])) {
    $c_id = intval($_GET['del_comment']);
    $conn->query("DELETE FROM comments WHERE id=$c_id");
    header("Location: view_news.php?id=$id"); 
    exit;
}

// 2. Fetch Article Data
$stmt = $conn->prepare("SELECT * FROM news WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$news = $stmt->get_result()->fetch_assoc();

if(!$news) { die("Article not found."); }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage: <?php echo htmlspecialchars($news['title']); ?></title>
    <style>
        /* --- MASTER CSS --- */
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&family=Orbitron:wght@500;700&display=swap');
        :root { --bg: #0a0e17; --glass: rgba(23, 32, 51, 0.6); --primary: #00f2ff; --text: #e2e8f0; --danger: #ff3333; }
        body { font-family: 'Inter', sans-serif; background: var(--bg); color: var(--text); padding-bottom: 50px; margin:0; }
        
        .container { max-width: 900px; margin: 40px auto; padding: 0 20px; }
        .navbar { background: rgba(10,14,23,0.9); border-bottom: 1px solid rgba(255,255,255,0.1); padding: 1rem 0; }
        .nav-inner { max-width: 900px; margin: 0 auto; padding: 0 20px; }
        .back-link { color: #94a3b8; text-decoration: none; font-weight: 600; display: flex; align-items: center; }
        .back-link:hover { color: var(--primary); }

        /* Article Preview */
        .article-card { background: var(--glass); padding: 40px; border-radius: 16px; border: 1px solid rgba(255,255,255,0.05); margin-bottom: 40px; }
        .article-title { font-family: 'Orbitron'; font-size: 2rem; color: white; margin-bottom: 10px; }
        .article-meta { color: var(--primary); font-size: 0.9rem; margin-bottom: 20px; display: block; }
        
        /* NEW: Image Style */
        .article-preview-img {
            width: 100%;
            max-height: 400px;
            object-fit: cover;
            border-radius: 10px;
            border: 1px solid rgba(255,255,255,0.1);
            margin-bottom: 25px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
        }

        .article-content { color: #cbd5e1; line-height: 1.6; white-space: pre-line; max-height: 300px; overflow-y: auto; padding-right: 10px; border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 20px; }
        
        /* Comments Section */
        .section-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; border-left: 4px solid var(--primary); padding-left: 15px; }
        .section-title { font-family: 'Orbitron'; font-size: 1.5rem; color: white; }
        
        .comment-list { display: grid; gap: 15px; }
        .comment-item {
            background: rgba(255,255,255,0.03);
            padding: 20px;
            border-radius: 10px;
            border: 1px solid rgba(255,255,255,0.05);
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }
        .comment-item:hover { background: rgba(255,255,255,0.06); }
        .c-user { color: var(--primary); font-weight: bold; font-size: 1.05rem; display: block; margin-bottom: 5px; }
        .c-date { color: #64748b; font-size: 0.8rem; margin-left: 10px; font-weight: normal; }
        .c-text { color: #e2e8f0; line-height: 1.5; }

        .btn-del {
            background: transparent;
            border: 1px solid var(--danger);
            color: var(--danger);
            padding: 8px 16px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 0.8rem;
            font-weight: 600;
            white-space: nowrap;
            margin-left: 20px;
            transition: 0.2s;
        }
        .btn-del:hover { background: var(--danger); color: white; }
    </style>
</head>
<body>

    <nav class="navbar">
        <div class="nav-inner">
            <a href="index.php" class="back-link">&larr; Back to Dashboard</a>
        </div>
    </nav>

    <div class="container">
        
        <div class="article-card">
            <h1 class="article-title"><?php echo htmlspecialchars($news['title']); ?></h1>
            <span class="article-meta">Published: <?php echo $news['created_at']; ?></span>
            
            <?php if($news['image']): ?>
                <img src="../assets/uploads/<?php echo $news['image']; ?>" class="article-preview-img" alt="Article Preview">
            <?php endif; ?>

            <div class="article-content">
                <?php echo htmlspecialchars($news['content']); ?>
            </div>
        </div>

        <div class="section-header">
            <h2 class="section-title">Discussion Management</h2>
        </div>

        <div class="comment-list">
            <?php
            $c_stmt = $conn->prepare("SELECT * FROM comments WHERE news_id = ? ORDER BY id DESC");
            $c_stmt->bind_param("i", $id);
            $c_stmt->execute();
            $comments = $c_stmt->get_result();

            if($comments->num_rows > 0){
                while($c = $comments->fetch_assoc()){
            ?>
                <div class="comment-item">
                    <div>
                        <span class="c-user"><?php echo htmlspecialchars($c['username']); ?> <span class="c-date"><?php echo $c['created_at']; ?></span></span>
                        <p class="c-text"><?php echo htmlspecialchars($c['comment']); ?></p>
                    </div>
                    <a href="view_news.php?id=<?php echo $id; ?>&del_comment=<?php echo $c['id']; ?>" class="btn-del" onclick="return confirm('Permanently delete this comment?');">DELETE</a>
                </div>
            <?php
                }
            } else {
                echo "<div style='text-align:center; padding:30px; background:rgba(255,255,255,0.02); border-radius:10px; color:#64748b;'>No comments on this article yet.</div>";
            }
            ?>
        </div>
    </div>

</body>
</html>