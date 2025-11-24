<?php
session_start();
include '../includes/db.php';

// 1. Security Check
if (!isset($_SESSION['admin'])) { header("Location: login.php"); exit; }

// 2. Logic to Delete an ARTICLE (Optional, but useful)
if (isset($_GET['del_news'])) {
    $id = intval($_GET['del_news']);
    $conn->query("DELETE FROM news WHERE id=$id");
    header("Location: index.php");
    exit;
}

// 3. Stats
$news_count = $conn->query("SELECT COUNT(*) as count FROM news")->fetch_assoc()['count'];
$comment_count = $conn->query("SELECT COUNT(*) as count FROM comments")->fetch_assoc()['count'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard | NEXUS ADMIN</title>
    <style>
        /* --- MASTER CSS --- */
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&family=Orbitron:wght@500;700&display=swap');
        :root { --bg: #0a0e17; --glass: rgba(23, 32, 51, 0.6); --primary: #00f2ff; --text: #e2e8f0; --danger: #ff3333; }
        * { box-sizing: border-box; margin:0; padding:0; }
        body { font-family: 'Inter', sans-serif; background: var(--bg); color: var(--text); padding-bottom:50px; }
        
        /* Navbar */
        .navbar { background: rgba(10,14,23,0.9); border-bottom: 1px solid rgba(255,255,255,0.1); padding: 1rem 0; }
        .nav-inner { max-width: 1200px; margin: 0 auto; padding: 0 20px; display: flex; justify-content: space-between; align-items: center; }
        .logo { font-family: 'Orbitron'; font-weight: 700; font-size: 1.5rem; color: white; text-decoration: none; }
        .logout { color: var(--danger); text-decoration: none; font-weight: 600; }

        /* Layout */
        .container { max-width: 1200px; margin: 40px auto; padding: 0 20px; }
        
        /* Stats */
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 50px; }
        .stat-card { background: var(--glass); border: 1px solid rgba(255,255,255,0.05); padding: 25px; border-radius: 16px; display: flex; flex-direction: column; }
        .stat-num { font-family: 'Orbitron'; font-size: 2.5rem; color: white; }
        .stat-label { color: #94a3b8; font-size: 0.9rem; text-transform: uppercase; }
        
        .btn-add { background: linear-gradient(135deg, #00f2ff, #7000ff); color: white; text-decoration: none; padding: 0 30px; border-radius: 50px; display: flex; align-items: center; justify-content: center; font-weight: bold; box-shadow: 0 0 15px rgba(0,242,255,0.3); }

        /* Article List */
        .section-title { font-family: 'Orbitron'; margin-bottom: 20px; font-size: 1.5rem; }
        .news-list { display: grid; gap: 15px; }
        .news-item {
            background: rgba(255,255,255,0.03);
            padding: 20px;
            border-radius: 12px;
            border: 1px solid rgba(255,255,255,0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: 0.2s;
        }
        .news-item:hover { background: rgba(255,255,255,0.06); border-color: var(--primary); }
        .news-info h3 { font-size: 1.1rem; color: white; margin-bottom: 5px; }
        .news-info span { color: #64748b; font-size: 0.85rem; }
        
        .actions { display: flex; gap: 10px; }
        .btn { padding: 8px 20px; border-radius: 6px; text-decoration: none; font-size: 0.85rem; font-weight: 600; border: 1px solid transparent; }
        .btn-view { background: rgba(0, 242, 255, 0.1); color: var(--primary); border-color: var(--primary); }
        .btn-view:hover { background: var(--primary); color: black; }
        .btn-del { background: rgba(255, 51, 51, 0.1); color: var(--danger); border-color: var(--danger); }
        .btn-del:hover { background: var(--danger); color: white; }
    </style>
</head>
<body>

    <nav class="navbar">
        <div class="nav-inner">
            <a href="#" class="logo">NEXUS<span style="color:var(--primary)">.ADMIN</span></a>
            <div>
                <a href="../index.php" target="_blank" style="color:#94a3b8; text-decoration:none; margin-right:20px;">View Site</a>
                <a href="logout.php" class="logout">Log Out</a>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="stats-grid">
            <div class="stat-card">
                <span class="stat-num"><?php echo $news_count; ?></span>
                <span class="stat-label">Articles</span>
            </div>
            <div class="stat-card">
                <span class="stat-num"><?php echo $comment_count; ?></span>
                <span class="stat-label">Comments</span>
            </div>
            <a href="add_news.php" class="btn-add">+ NEW ARTICLE</a>
        </div>

        <h2 class="section-title">Manage Articles</h2>
        <div class="news-list">
            <?php
            $sql = "SELECT * FROM news ORDER BY created_at DESC";
            $result = $conn->query($sql);

            if($result->num_rows > 0){
                while($row = $result->fetch_assoc()){
            ?>
                <div class="news-item">
                    <div class="news-info">
                        <h3><?php echo htmlspecialchars($row['title']); ?></h3>
                        <span>Published: <?php echo date("M d, Y", strtotime($row['created_at'])); ?></span>
                    </div>
                    <div class="actions">
                        <a href="view_news.php?id=<?php echo $row['id']; ?>" class="btn btn-view">VIEW & MANAGE</a>
                        
                        <a href="index.php?del_news=<?php echo $row['id']; ?>" class="btn btn-del" onclick="return confirm('Warning: This will delete the article AND all its comments.');">DELETE</a>
                    </div>
                </div>
            <?php
                }
            } else {
                echo "<p style='color:#64748b'>No articles posted yet.</p>";
            }
            ?>
        </div>
    </div>

</body>
</html>