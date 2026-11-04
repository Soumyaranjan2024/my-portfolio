<?php
require_once 'database.php';
$personal_info = $pdo->query("SELECT * FROM personal_info LIMIT 1")->fetch();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Me - Soumya Portfolio</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Raleway:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .about-page {
            padding: 120px 0 80px;
        }

        .about-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 40px;
            text-align: center;
            max-width: 900px;
            margin: 0 auto;
        }

        .about-image {
            display: flex;
            justify-content: center;
        }

        .about-image img {
            border-radius: 50%;
            box-shadow: var(--box-shadow);
            width: 250px;
            height: 250px;
            object-fit: cover;
            border: 5px solid var(--primary-color);
        }

        .about-text h2 {
            font-size: 2.5rem;
            margin-bottom: 20px;
        }

        .about-text p {
            font-size: 1.1rem;
            margin-bottom: 20px;
            color: var(--text-color);
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-top: 40px;
        }

        .stat-item {
            text-align: center;
            padding: 20px;
            background: var(--light-color);
            border-radius: 12px;
            transition: var(--transition);
        }

        .stat-item:hover {
            background: #fff;
            box-shadow: var(--box-shadow);
            transform: translateY(-5px);
        }

        .stat-item h3 {
            font-size: 2rem;
            color: var(--primary-color);
            margin-bottom: 5px;
        }

        .stat-item p {
            font-size: 0.9rem;
            margin-bottom: 0;
            color: var(--gray-color);
        }

        @media (max-width: 768px) {
            .about-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 480px) {
            .about-page {
                padding: 100px 0 60px;
            }

            .about-text h2 {
                font-size: 1.9rem;
            }

            .about-text p {
                font-size: 1rem;
            }

            .about-image img {
                width: 180px;
                height: 180px;
            }

            .stats-grid {
                gap: 10px;
                margin-top: 30px;
            }

            .stat-item {
                padding: 14px 6px;
            }

            .stat-item h3 {
                font-size: 1.4rem;
            }

            .stat-item p {
                font-size: 0.75rem;
            }
        }
    </style>
</head>

<body>
    <?php include 'header.php'; ?>

    <section class="about-page reveal">
        <div class="container">
            <div class="about-grid">
                <div class="about-image">
                    <img src="<?php echo htmlspecialchars($personal_info['about_image'] ?? 'uploads/projects/me.jpg'); ?>" alt="<?php echo htmlspecialchars($personal_info['full_name'] ?? 'Soumya Ranjan Padhi'); ?>">
                </div>
                <div class="about-text">
                    <h2><?php echo htmlspecialchars($personal_info['full_name'] ?? 'Soumya Ranjan Padhi'); ?></h2>
                    <?php if (isset($personal_info['summary']) && !empty($personal_info['summary'])): ?>
                        <?php
                        $summary_paragraphs = explode("\n", $personal_info['summary']);
                        foreach ($summary_paragraphs as $para) {
                            if (trim($para)) {
                                echo "<p>" . htmlspecialchars(trim($para)) . "</p>";
                            }
                        }
                        ?>
                    <?php else: ?>
                        <p>I am Soumya Ranjan Padhi, a dedicated student and web enthusiast currently pursuing my studies at GIET University. My journey in the digital world began with a curiosity for how things work under the hood, which quickly evolved into a passion for building clean, responsive, and user-centric web applications.</p>
                        <p>I specialize in bridging the gap between design and development, ensuring that every project I touch not only looks beautiful but also performs flawlessly. With a strong foundation in PHP, MySQL, and modern JavaScript, I love solving complex problems and learning new technologies every day.</p>
                    <?php endif; ?>

                    <div class="stats-grid">
                        <div class="stat-item">
                            <h3>2+</h3>
                            <p>Years Experience</p>
                        </div>
                        <div class="stat-item">
                            <h3>20+</h3>
                            <p>Projects Done</p>
                        </div>
                        <div class="stat-item">
                            <h3>15+</h3>
                            <p>Happy Clients</p>
                        </div>
                    </div>

                    <div style="margin-top: 40px;">
                        <a href="<?php echo htmlspecialchars($personal_info['cv_pdf'] ?? 'images/soumya ranjan padhi cv.pdf'); ?>" class="btn btn-primary" download>Download CV</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php include 'footer.php'; ?>
</body>

</html>