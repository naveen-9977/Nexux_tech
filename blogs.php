<?php include 'includes/db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Blogs | NEXUS</title>
    <style>
        /* Reuse the same Master CSS for consistency */
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&family=Orbitron:wght@500;700&display=swap');
        :root { --bg-dark: #0a0e17; --bg-card: rgba(23, 32, 51, 0.7); --primary: #00f2ff; --text-main: #e2e8f0; --gradient: linear-gradient(135deg, #00f2ff 0%, #7000ff 100%); }
        
        body { font-family: 'Inter', sans-serif; background: var(--bg-dark); color: var(--text-main); margin:0; padding:0; min-height:100vh; }
        a { text-decoration:none; transition:0.3s; }
        
        .navbar { position:sticky; top:0; background:rgba(10,14,23,0.95); backdrop-filter:blur(12px); padding:1rem 0; border-bottom:1px solid rgba(255,255,255,0.1); z-index:100;}
        .nav-inner { max-width:92%; margin:0 auto; display:flex; justify-content:space-between; align-items:center; }
        .logo { font-family:'Orbitron'; font-size:1.5rem; font-weight:700; color:white; }
        .back-btn { color:#94a3b8; font-weight:600; }
        .back-btn:hover { color:var(--primary); }

        .container { max-width:92%; max-width:1400px; margin:40px auto; padding:0 20px; }
        
        .page-header { text-align:center; margin-bottom:50px; }
        .page-header h1 { font-family:'Orbitron'; font-size:2.5rem; color:white; margin-bottom:10px; }
        
        .grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 30px; }
        
        .card { background:var(--bg-card); border:1px solid rgba(255,255,255,0.05); border-radius:16px; overflow:hidden; display:flex; flex-direction:column; transition:0.3s; }
        .card:hover { transform:translateY(-8px); border-color:rgba(0,242,255,0.3); }
        .card img { width:100%; height:200px; object-fit:cover; }
        .card-body { padding:25px; flex:1; display:flex; flex-direction:column; }
        .card h2 { font-size:1.3rem; color:white; margin:10px 0; }
        .read-more { color:var(--primary); font-weight:bold; margin-top:auto; }
    </style>
</head>
<body>

    <nav class="navbar">
        <div class="nav-inner">
            <a href="index.php" class="logo">NEXUS<span style="color:var(--primary)">.BLOGS</span></a>
            <a href="index.php" class="back-btn">&larr; Back to Home</a>
        </div>
    </nav>

    <div class="container">
        <div class="page-header">
            <h1>Tech Blog Archive</h1>
            <p style="color:#94a3b8;">Explore our complete collection of articles.</p>
        </div>

        <div class="grid">
            <?php
            // Select ALL news
            $sql = "SELECT * FROM news ORDER BY created_at DESC";
            $result = $conn->query($sql);
            if($result->num_rows > 0){
                while($row = $result->fetch_assoc()){
                    $img = !empty($row['image']) ? 'assets/uploads/'.$row['image'] : 'https://via.placeholder.com/300';
            ?>
            <article class="card">
                <img src="<?php echo $img; ?>">
                <div class="card-body">
                    <small style="color:var(--primary)"><?php echo date("M d, Y", strtotime($row['created_at'])); ?></small>
                    <h2><?php echo htmlspecialchars($row['title']); ?></h2>
                    <p style="color:#94a3b8; font-size:0.9rem; margin-bottom:20px;"><?php echo substr(strip_tags($row['content']), 0, 100); ?>...</p>
                    <a href="news.php?id=<?php echo $row['id']; ?>" class="read-more">Read Article</a>
                </div>
            </article>
            <?php }} ?>
        </div>
    </div>

</body>
</html>