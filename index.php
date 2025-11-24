<?php include 'includes/db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NEXUS | Future Tech Portal</title>
    
    <style>
        /* --- MASTER CSS --- */
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&family=Orbitron:wght@500;700&display=swap');

        :root {
            /* DEFAULT (DARK MODE) VARIABLES */
            --bg-body: #0a0e17;
            --bg-card: rgba(23, 32, 51, 0.7);
            --bg-nav: rgba(10, 14, 23, 0.95);
            --primary: #00f2ff;
            --secondary: #7000ff;
            --text-main: #e2e8f0;
            --text-muted: #94a3b8;
            --border-color: rgba(255, 255, 255, 0.08);
            --hero-text-grad: linear-gradient(to right, #fff, #94a3b8);
            --site-width: 92%; 
            --site-max-width: 1400px;
        }

        /* --- LIGHT MODE OVERRIDES --- */
        body.light-mode {
            --bg-body: #f0f2f5;
            --bg-card: #ffffff;
            --bg-nav: rgba(255, 255, 255, 0.95);
            --primary: #007bff; /* Darker Blue for better visibility on white */
            --secondary: #6610f2;
            --text-main: #1e293b;
            --text-muted: #64748b;
            --border-color: rgba(0, 0, 0, 0.1);
            --hero-text-grad: linear-gradient(to right, #1e293b, #475569);
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-body);
            /* Subtle Tech Grid Background */
            background-image: 
                radial-gradient(circle at 15% 50%, rgba(0, 242, 255, 0.05) 0%, transparent 25%),
                radial-gradient(circle at 85% 30%, rgba(112, 0, 255, 0.05) 0%, transparent 25%);
            color: var(--text-main);
            min-height: 100vh;
            line-height: 1.6;
            overflow-x: hidden;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        /* UTILITIES */
        .layout-limiter { width: var(--site-width); max-width: var(--site-max-width); margin: 0 auto; }
        a { text-decoration: none; transition: 0.3s; }

        /* NAVBAR */
        .navbar {
            position: sticky; top: 0; z-index: 100;
            background: var(--bg-nav);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border-color);
            padding: 1rem 0;
            transition: background 0.3s;
        }
        .nav-container { display: flex; justify-content: space-between; align-items: center; }
        .logo { font-family: 'Orbitron'; font-size: 1.8rem; font-weight: 700; color: var(--text-main); letter-spacing: 1px; }
        .nav-links { display: flex; align-items: center; }
        .nav-links a { color: var(--text-main); margin-left: 2rem; font-size: 0.95rem; font-weight: 500; }
        .nav-links a:hover, .nav-links a.active { color: var(--primary); }
        
        .btn-login { border: 1px solid var(--primary); padding: 8px 20px; border-radius: 50px; color: var(--primary) !important; }
        .btn-login:hover { background: var(--primary); color: white !important; box-shadow: 0 0 15px rgba(0, 242, 255, 0.4); }

        /* THEME TOGGLE BUTTON */
        .theme-btn {
            background: transparent;
            border: 1px solid var(--border-color);
            color: var(--text-main);
            width: 40px; height: 40px;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            cursor: pointer;
            margin-left: 20px;
            transition: 0.3s;
        }
        .theme-btn:hover { background: var(--border-color); }

        /* HERO */
        .hero { text-align: center; padding: 80px 0 60px; }
        .hero h2 { font-family: 'Orbitron'; font-size: 3rem; background: var(--hero-text-grad); -webkit-background-clip: text; -webkit-text-fill-color: transparent; margin-bottom: 10px; }
        .hero p { color: var(--text-muted); font-size: 1.1rem; }

        /* --- MAIN 2-COLUMN LAYOUT --- */
        .main-grid {
            display: grid;
            grid-template-columns: 2.5fr 1fr; /* Left side is bigger, Right is sidebar */
            gap: 50px;
            padding-bottom: 60px;
        }

        /* LEFT COLUMN STYLES */
        .about-section {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 40px;
            margin-bottom: 40px;
            display: flex;
            gap: 30px;
            align-items: center;
            transition: background 0.3s;
        }
        .founder-img {
            width: 150px; height: 150px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid var(--primary);
            box-shadow: 0 0 20px rgba(0, 242, 255, 0.2);
        }
        .company-info h3 { font-family: 'Orbitron'; color: var(--text-main); font-size: 1.8rem; margin-bottom: 10px; }
        .founder-name { color: var(--primary); font-weight: bold; font-size: 1.1rem; display: block; margin-bottom: 10px; }

        .news-list-vertical { display: flex; flex-direction: column; gap: 25px; }
        .news-card-row {
            display: flex;
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            overflow: hidden;
            height: 200px;
            transition: 0.3s;
        }
        .news-card-row img { width: 35%; object-fit: cover; }
        .news-card-content { padding: 25px; flex: 1; display: flex; flex-direction: column; justify-content: center; }
        .news-card-row h2 { font-size: 1.4rem; margin-bottom: 10px; color: var(--text-main); }
        .news-card-row:hover { border-color: var(--primary); transform: translateX(5px); box-shadow: 0 10px 30px rgba(0,0,0,0.1); }

        /* RIGHT SIDEBAR STYLES */
        .sidebar { position: sticky; top: 100px; }
        .sidebar-box {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 30px;
        }
        .sidebar-title { font-family: 'Orbitron'; color: var(--text-main); margin-bottom: 20px; border-bottom: 2px solid var(--secondary); padding-bottom: 10px; }
        .recent-link {
            display: block;
            padding: 10px 0;
            border-bottom: 1px solid var(--border-color);
            color: var(--text-main);
            font-size: 0.95rem;
        }
        .recent-link:hover { color: var(--primary); padding-left: 5px; }
        .recent-date { font-size: 0.75rem; color: var(--text-muted); display: block; margin-top: 4px; }

        /* FOOTER */
        footer { background: #05070c; padding: 40px 0; margin-top: auto; border-top: 1px solid var(--border-color); text-align: center; font-size: 0.9rem; color: #64748b; }

        /* RESPONSIVE */
        @media (max-width: 900px) {
            .main-grid { grid-template-columns: 1fr; }
            .about-section { flex-direction: column; text-align: center; }
            .news-card-row { flex-direction: column; height: auto; }
            .news-card-row img { width: 100%; height: 200px; }
            .nav-container { flex-direction: column; gap: 15px; }
            .nav-links { display: flex; gap: 15px; flex-wrap: wrap; justify-content: center; }
            .nav-links a { margin: 0; }
            .theme-btn { position: absolute; top: 20px; right: 20px; margin: 0; } /* Fix button pos on mobile */
        }
    </style>
</head>
<body>

    <nav class="navbar">
        <div class="nav-container layout-limiter">
            <a href="index.php" class="logo">NEXUS<span style="color:var(--primary)">.TECH</span></a>
            <div class="nav-links">
                <a href="index.php" class="active">Home</a>
                <a href="blogs.php">Tech Blogs</a>
                <a href="#">Gadgets</a>
                <a href="admin/login.php" class="btn-login">Admin</a>
                
                <button class="theme-btn" id="theme-toggle" title="Switch Theme">
                    <svg id="sun-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:none;"><circle cx="12" cy="12" r="5"></circle><line x1="12" y1="1" x2="12" y2="3"></line><line x1="12" y1="21" x2="12" y2="23"></line><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line><line x1="1" y1="12" x2="3" y2="12"></line><line x1="21" y1="12" x2="23" y2="12"></line><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line></svg>
                    <svg id="moon-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path></svg>
                </button>
            </div>
        </div>
    </nav>

    <section class="hero">
        <div class="layout-limiter">
            <h2>WELCOME TO THE FUTURE</h2>
            <p>Connecting Raipur to the Global Digital Revolution.</p>
        </div>
    </section>

    <div class="layout-limiter main-grid">
        
        <div class="left-content">
            
            <div class="about-section">
                <img src="assets/uploads/founder.jpg" alt="Naveen Bhatpahari" class="founder-img" onerror="this.src='https://via.placeholder.com/150?text=NB'">
                
                <div class="company-info">
                    <h3>About NEXUS.TECH</h3>
                    <span class="founder-name">Founded by Naveen Bhatpahari</span>
                    <p style="color:var(--text-muted);">
                        Based in DDU Nagar, Raipur, NEXUS is a cutting-edge platform dedicated to decoding the complexities of modern technology. 
                        We bridge the gap between complex innovation and everyday understanding.
                    </p>
                </div>
            </div>

            <h3 style="font-family:'Orbitron'; color:var(--text-main); margin-bottom:20px;">Featured Stories</h3>

            <div class="news-list-vertical">
                <?php
                $sql = "SELECT * FROM news ORDER BY created_at DESC LIMIT 5";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        $img = !empty($row['image']) ? 'assets/uploads/'.$row['image'] : 'https://via.placeholder.com/300';
                ?>
                <a href="news.php?id=<?php echo $row['id']; ?>" class="news-card-row">
                    <img src="<?php echo $img; ?>">
                    <div class="news-card-content">
                        <h2><?php echo htmlspecialchars($row['title']); ?></h2>
                        <p style="color:var(--text-muted); font-size:0.9rem;"><?php echo substr(strip_tags($row['content']), 0, 150); ?>...</p>
                        <span style="color:var(--primary); font-size:0.8rem; margin-top:10px;">Read Article &rarr;</span>
                    </div>
                </a>
                <?php }} ?>
            </div>
            
            <div style="text-align:center; margin-top:30px;">
                <a href="blogs.php" class="btn-login">View All Blogs</a>
            </div>
        </div>

        <aside class="sidebar">
            
            <div class="sidebar-box">
                <h4 class="sidebar-title">Recent Added</h4>
                <?php
                $sideSql = "SELECT id, title, created_at FROM news ORDER BY created_at DESC LIMIT 8";
                $sideResult = $conn->query($sideSql);
                if($sideResult->num_rows > 0){
                    while($sRow = $sideResult->fetch_assoc()){
                ?>
                <a href="news.php?id=<?php echo $sRow['id']; ?>" class="recent-link">
                    <?php echo htmlspecialchars($sRow['title']); ?>
                    <span class="recent-date"><?php echo date("M d", strtotime($sRow['created_at'])); ?></span>
                </a>
                <?php }} ?>
            </div>

            <div class="sidebar-box">
                <h4 class="sidebar-title">Connect</h4>
                <p style="color:var(--text-muted); font-size:0.9rem; margin-bottom:15px;">Join Naveen Bhatpahari and the NEXUS community.</p>
                <a href="#" style="color:var(--primary);">@NEXUS.TECH</a>
            </div>

        </aside>

    </div>

    <footer>
        &copy; <?php echo date("Y"); ?> NEXUS Tech Portal | DDU Nagar, Raipur | Founder: Naveen Bhatpahari
    </footer>

    <script>
        const themeBtn = document.getElementById('theme-toggle');
        const sunIcon = document.getElementById('sun-icon');
        const moonIcon = document.getElementById('moon-icon');

        // 1. Check LocalStorage on Load
        if (localStorage.getItem('theme') === 'light') {
            document.body.classList.add('light-mode');
            sunIcon.style.display = 'block';
            moonIcon.style.display = 'none';
        } else {
            sunIcon.style.display = 'none';
            moonIcon.style.display = 'block';
        }

        // 2. Toggle Event
        themeBtn.addEventListener('click', () => {
            document.body.classList.toggle('light-mode');
            
            if (document.body.classList.contains('light-mode')) {
                localStorage.setItem('theme', 'light');
                sunIcon.style.display = 'block';
                moonIcon.style.display = 'none';
            } else {
                localStorage.setItem('theme', 'dark');
                sunIcon.style.display = 'none';
                moonIcon.style.display = 'block';
            }
        });
    </script>

</body>
</html>