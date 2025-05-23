<?php
require 'database.php';

// Get projects from database
$projects = $pdo->query("SELECT * FROM projects ORDER BY created_at DESC")->fetchAll();

// Get skills from database
$skills = $pdo->query("SELECT * FROM skills ORDER BY category, name")->fetchAll();

// Group skills by category
$skillsByCategory = [];
foreach ($skills as $skill) {
    if (!isset($skillsByCategory[$skill['category']])) {
        $skillsByCategory[$skill['category']] = [];
    }
    $skillsByCategory[$skill['category']][] = $skill;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="Professional portfolio of Soumya Ranjan Padhi, a web developer and designer creating responsive and user-friendly websites.">
    <meta name="keywords"
        content="Soumya Ranjan Padhi, web developer, front-end developer, web designer, portfolio, UI/UX, responsive design">
    <meta name="author" content="Soumya Ranjan Padhi">

    <title>Soumya portfolio</title>

    <!-- Custom CSS -->
    <link rel="stylesheet" href="style.css">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Raleway:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body>
    <!-- Navigation -->
    <header>
        <nav class="navbar">
            <div class="container">
                <div class="logo">
                    <a href="#hero">its<span>Soumya</span></a>
                </div>
                <div class="menu-toggle" id="mobile-menu">
                    <span class="bar"></span>
                    <span class="bar"></span>
                    <span class="bar"></span>
                </div>
                <ul class="nav-menu">
                    <li><a href="#about" class="nav-link">About</a></li>
                    <li><a href="#skills" class="nav-link">Skills</a></li>
                    <li><a href="#projects" class="nav-link">Projects</a></li>
                    <li><a href="#contact" class="nav-link">Contact</a></li>
                </ul>
            </div>
        </nav>
    </header>

    <!-- Hero Section -->
    <section id="hero" class="hero">
        <div class="container">
            <div class="hero-content">
                <div class="hero-text">
                    <h1>Hi, I'm <span>Soumya Ranjan Padhi</span></h1>
                    <h2>Web Developer & Designer</h2>
                    <p>I craft responsive websites where technology meets creativity</p>
                    <div class="hero-btns">
                        <a href="#projects" class="btn btn-primary">View My Work</a>
                        <a href="#contact" class="btn btn-secondary">Contact Me</a>
                    </div>
                </div>
                <div class="hero-image">
                    <div class="profile-img">
                        <img src="uploads\project\my.jpg" alt="Profile Image"
                            style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="about section-padding">
        <div class="container">
            <div class="section-title">
                <h2>About Me</h2>
                <div class="underline"></div>
            </div>
            <div class="hero-image">
                <div class="profile-img">
                    <img src="uploads/projects/me.jpg" alt="Profile Image"
                        style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">
                </div>
            </div>
            <div class="about-content">
                <div class="about-text">
                    <p>Hi, I'm Soumya Ranjan Padhi, a passionate student at GIET University. I'm a code enthusiast who
                        loves exploring new technologies, solving problems, and constantly learning in the world of
                        programming and development. Whether it's building something from scratch or debugging tricky
                        code, I enjoy the process and the challenges it brings</p>
                    <p>I specialize in creating responsive websites...</p>
                    <p>When I'm not coding, you can find me exploring new design trends...</p>
                </div>

                <div class="about-details">
                    <div class="detail-item">
                        <h3>Name:</h3>
                        <p>Soumya Ranjan Padhi</p>
                    </div>
                    <div class="detail-item">
                        <h3>Email:</h3>
                        <p>soumyaranjanpadhi936@gmail.com</p>
                    </div>
                    <div class="detail-item">
                        <h3>Based in:</h3>
                        <p>Bhubaneswar, India</p>
                    </div>
                    <div class="detail-item">
                        <h3>Freelance:</h3>
                        <p>Available</p>
                    </div>

                    <a href="images/soumya-ranjan-padhi-cv.pdf" class="btn btn-primary"
                        download="Soumya_Ranjan_Padhi_CV.pdf">Download CV</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Skills Section - Now Dynamic -->
    <section id="skills" class="skills section-padding">
        <div class="container">
            <div class="section-title">
                <h2>My Skills</h2>
                <div class="underline"></div>
            </div>
            <div class="skills-content">
                <div class="skill-categories">
                    <?php foreach ($skillsByCategory as $category => $categorySkills): ?>
                        <div class="skill-category">
                            <h3><?php echo htmlspecialchars(ucfirst($category)); ?></h3>
                            <div class="skills-list">
                                <?php foreach ($categorySkills as $skill): ?>
                                    <div class="skill-item">
                                        <span class="skill-name"><?php echo htmlspecialchars($skill['name']); ?></span>
                                        <div class="skill-bar">
                                            <div class="skill-level" style="width: <?php echo $skill['proficiency']; ?>%"></div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </section>

    <!-- Projects Section - Now Dynamic -->
    <section id="projects" class="projects section-padding">
        <div class="container">
            <div class="section-title">
                <h2>My Projects</h2>
                <div class="underline"></div>
            </div>
            <div class="filter-buttons">
                <button class="filter-btn active" data-filter="all">All</button>
                <button class="filter-btn" data-filter="web">Web Design</button>
                <button class="filter-btn" data-filter="app">App Design</button>
                <button class="filter-btn" data-filter="ui">UI/UX</button>

            </div>
            <div class="projects-grid">
                <?php foreach ($projects as $project): ?>
                    <div class="project-item" data-category="<?php echo htmlspecialchars($project['category']); ?>">
                        <div class="project-img">
                            <img src="<?php echo htmlspecialchars($project['image_url']) ?: '/api/placeholder/600/400'; ?>"
                                alt="<?php echo htmlspecialchars($project['title']); ?>">
                        </div>
                        <div class="project-info">
                            <h3><?php echo htmlspecialchars($project['title']); ?></h3>
                            <p><?php echo htmlspecialchars($project['description']); ?></p>
                            <div class="project-tags">
                                <?php
                                $tags = explode(',', $project['tags']);
                                foreach ($tags as $tag):
                                    ?>
                                    <span><?php echo htmlspecialchars(trim($tag)); ?></span>
                                <?php endforeach; ?>
                            </div>
                            <a href="#" class="project-link">View Project</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="contact section-padding">
        <div class="container">
            <div class="section-title">
                <h2>Contact Me</h2>
                <div class="underline"></div>
            </div>
            <div class="contact-content">
                <div class="contact-info">
                    <h3>Let's Connect</h3>
                    <p>I'm always open to discussing new projects, creative ideas or opportunities to be part of your
                        vision.</p>
                    <div class="contact-details">
                        <div class="contact-item">
                            <i class="fas fa-map-marker-alt"></i>
                            <div>
                                <h4>Location</h4>
                                <p>bhubaneswar, india</p>
                            </div>
                        </div>
                        <div class="contact-item">
                            <i class="fas fa-envelope"></i>
                            <div>
                                <h4>Email</h4>
                                <p>soumyaranjanpadhi936@gmail.com</p>
                            </div>
                        </div>
                        <div class="contact-item">
                            <i class="fas fa-phone"></i>
                            <div>
                                <h4>Phone</h4>
                                <p>+91 7205574037</p>
                            </div>
                        </div>
                    </div>
                    <div class="social-links">
                        <a href="https://www.linkedin.com/in/soumya-ranjan-padhi-5b5a6a304?utm_source=share&utm_campaign=share_via&utm_content=profile&utm_medium=android_app"
                            aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                        <a href="https://github.com/Soumyaranjan2024" aria-label="GitHub"><i
                                class="fab fa-github"></i></a>
                        <a href="#" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                        <a href="https://www.instagram.com/s0umyya_?igsh=cHdqaTdvY3doczFv" aria-label="Instagram"><i
                                class="fab fa-instagram"></i></a>
                    </div>
                </div>
                <div class="contact-form">
                    <form id="contactForm" method="POST" action="submit_contact.php">
                        <div class="form-group">
                            <input type="text" id="name" name="name" placeholder="Your Name" required>
                        </div>
                        <div class="form-group">
                            <input type="email" id="email" name="email" placeholder="Your Email" required>
                        </div>
                        <div class="form-group">
                            <input type="text" id="subject" name="subject" placeholder="Subject">
                        </div>
                        <div class="form-group">
                            <textarea id="message" name="message" placeholder="Your Message" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Send Message</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="footer-content">
                <div class="footer-logo">
                    <a href="#hero">Soumya Ranjan Padhi<span></span></a>
                </div>
                <p>&copy; 2025 Soumya Ranjan Padhi All Rights Reserved.</p>
            </div>
        </div>
    </footer>

    <!-- JavaScript -->
    <script>
        // Mobile Menu Toggle
        document.getElementById('mobile-menu').addEventListener('click', function () {
            this.classList.toggle('active');
            document.querySelector('.nav-menu').classList.toggle('active');
        });

        // Smooth Scrolling
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();

                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });

                // Close mobile menu when a link is clicked
                document.querySelector('.nav-menu').classList.remove('active');
                document.getElementById('mobile-menu').classList.remove('active');
            });
        });

        // Project filtering
        const filterButtons = document.querySelectorAll('.filter-btn');
        const projectItems = document.querySelectorAll('.project-item');

        filterButtons.forEach(button => {
            button.addEventListener('click', () => {
                // Remove active class from all buttons
                filterButtons.forEach(btn => btn.classList.remove('active'));
                // Add active class to clicked button
                button.classList.add('active');

                const filterValue = button.getAttribute('data-filter');

                projectItems.forEach(item => {
                    if (filterValue === 'all' || item.getAttribute('data-category') === filterValue) {
                        item.style.display = 'block';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });
        });
    </script>
</body>

</html>