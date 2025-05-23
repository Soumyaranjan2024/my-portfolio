<?php
require 'database.php';

$blog_posts = $pdo->query("SELECT * FROM blog_posts ORDER BY created_at DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog - Soumya's Portfolio</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <!-- Include your header from index.php -->
    <?php include 'header.php'; ?>

    <section class="blog-archive section-padding">
        <div class="container">
            <div class="section-title">
                <h2>Blog</h2>
                <div class="underline"></div>
            </div>
            <div class="blog-grid">
                <?php foreach ($blog_posts as $post): ?>
                    <div class="blog-post">
                        <?php if ($post['featured_image']): ?>
                            <div class="blog-image">
                                <img src="<?php echo htmlspecialchars($post['featured_image']); ?>"
                                    alt="<?php echo htmlspecialchars($post['title']); ?>">
                            </div>
                        <?php endif; ?>
                        <div class="blog-content">
                            <h3><a
                                    href="blog-post.php?slug=<?php echo $post['slug']; ?>"><?php echo htmlspecialchars($post['title']); ?></a>
                            </h3>
                            <div class="blog-meta">
                                <span><i class="fas fa-user"></i> <?php echo htmlspecialchars($post['author']); ?></span>
                                <span><i class="fas fa-calendar"></i>
                                    <?php echo date('M d, Y', strtotime($post['created_at'])); ?></span>
                            </div>
                            <p><?php echo htmlspecialchars($post['excerpt']); ?></p>
                            <a href="blog-post.php?slug=<?php echo $post['slug']; ?>" class="read-more">Read More</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Include your footer from index.php -->
    <?php include 'footer.php'; ?>
</body>

</html>