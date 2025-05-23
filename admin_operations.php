<?php
// Projects CRUD
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_project'])) {
        $title = $_POST['title'];
        $description = $_POST['description'];
        $category = $_POST['category'];
        $tags = $_POST['tags'];

        // Handle image upload
        $image_url = '';
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = '../uploads/projects/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            $filename = basename($_FILES['image']['name']);
            $targetPath = $uploadDir . $filename;
            if (move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
                $image_url = '../uploads/projects/' . $filename;
            }
        }

        $stmt = $pdo->prepare("INSERT INTO projects (title, description, image_url, category, tags) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$title, $description, $image_url, $category, $tags]);
        $project_success = "Project added successfully!";
    }

    if (isset($_POST['update_project'])) {
        $id = $_POST['id'];
        $title = $_POST['title'];
        $description = $_POST['description'];
        $category = $_POST['category'];
        $tags = $_POST['tags'];

        // Handle image update
        $image_url = $_POST['current_image'];
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = '../uploads/projects/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            $filename = uniqid() . '_' . basename($_FILES['image']['name']);
            $targetPath = $uploadDir . $filename;
            if (move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
                // Delete old image if exists
                if ($image_url && file_exists('../' . $image_url)) {
                    unlink('../' . $image_url);
                }
                $image_url = '../uploads/projects/' . $filename;
            }
        }

        $stmt = $pdo->prepare("UPDATE projects SET title = ?, description = ?, image_url = ?, category = ?, tags = ? WHERE id = ?");
        $stmt->execute([$title, $description, $image_url, $category, $tags, $id]);
        $project_success = "Project updated successfully!";
    }

    if (isset($_POST['delete_project'])) {
        $id = $_POST['id'];

        // Delete image if exists
        $stmt = $pdo->prepare("SELECT image_url FROM projects WHERE id = ?");
        $stmt->execute([$id]);
        $project = $stmt->fetch();
        if ($project && $project['image_url'] && file_exists('../' . $project['image_url'])) {
            unlink('../' . $project['image_url']);
        }

        $stmt = $pdo->prepare("DELETE FROM projects WHERE id = ?");
        $stmt->execute([$id]);
        $project_success = "Project deleted successfully!";
    }

    // Skills CRUD
    if (isset($_POST['add_skill'])) {
        $category = $_POST['category'];
        $name = $_POST['name'];
        $proficiency = $_POST['proficiency'];

        $stmt = $pdo->prepare("INSERT INTO skills (category, name, proficiency) VALUES (?, ?, ?)");
        $stmt->execute([$category, $name, $proficiency]);
        $skill_success = "Skill added successfully!";
    }

    if (isset($_POST['update_skill'])) {
        $id = $_POST['id'];
        $category = $_POST['category'];
        $name = $_POST['name'];
        $proficiency = $_POST['proficiency'];

        $stmt = $pdo->prepare("UPDATE skills SET category = ?, name = ?, proficiency = ? WHERE id = ?");
        $stmt->execute([$category, $name, $proficiency, $id]);
        $skill_success = "Skill updated successfully!";
    }

    if (isset($_POST['delete_skill'])) {
        $id = $_POST['id'];

        $stmt = $pdo->prepare("DELETE FROM skills WHERE id = ?");
        $stmt->execute([$id]);
        $skill_success = "Skill deleted successfully!";
    }

    // Mark message as read
    if (isset($_POST['mark_as_read'])) {
        $id = $_POST['id'];

        $stmt = $pdo->prepare("UPDATE messages SET is_read = TRUE WHERE id = ?");
        $stmt->execute([$id]);
        $message_success = "Message marked as read!";
    }

    // Delete message
    if (isset($_POST['delete_message'])) {
        $id = $_POST['id'];

        $stmt = $pdo->prepare("DELETE FROM messages WHERE id = ?");
        $stmt->execute([$id]);
        $message_success = "Message deleted successfully!";
    }
}

// Get all projects
$projects = $pdo->query("SELECT * FROM projects ORDER BY created_at DESC")->fetchAll();

// Get all skills
$skills = $pdo->query("SELECT * FROM skills ORDER BY category, name")->fetchAll();

// Get all messages
$messages = $pdo->query("SELECT * FROM messages ORDER BY created_at DESC")->fetchAll();

// Get stats for dashboard
$total_projects = $pdo->query("SELECT COUNT(*) FROM projects")->fetchColumn();
$total_skills = $pdo->query("SELECT COUNT(*) FROM skills")->fetchColumn();
$total_messages = $pdo->query("SELECT COUNT(*) FROM messages")->fetchColumn();
$unread_messages = $pdo->query("SELECT COUNT(*) FROM messages WHERE is_read = FALSE")->fetchColumn();
?>