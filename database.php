<?php
$host = 'localhost';
$dbname = 'portfolio_db';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Create tables if they don't exist
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS projects (
            id INT AUTO_INCREMENT PRIMARY KEY,
            title VARCHAR(255) NOT NULL,
            description TEXT NOT NULL,
            image_url VARCHAR(255),
            category VARCHAR(50) NOT NULL,
            tags TEXT,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        );
        
        CREATE TABLE IF NOT EXISTS skills (
            id INT AUTO_INCREMENT PRIMARY KEY,
            category VARCHAR(50) NOT NULL,
            name VARCHAR(100) NOT NULL,
            proficiency INT NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        );
        
        CREATE TABLE IF NOT EXISTS messages (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100) NOT NULL,
            email VARCHAR(100) NOT NULL,
            subject VARCHAR(255),
            message TEXT NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            is_read BOOLEAN DEFAULT FALSE
        );
        
        CREATE TABLE IF NOT EXISTS admin (
            id INT AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(50) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL
        );
    ");

    // Insert default admin if not exists
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM admin WHERE username = 'soumya'");
    $stmt->execute();
    if ($stmt->fetchColumn() == 0) {
        $hashedPassword = password_hash('soumya123', PASSWORD_DEFAULT);
        $pdo->prepare("INSERT INTO admin (username, password) VALUES ('soumya', ?)")
            ->execute([$hashedPassword]);
    }

} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>