<?php
// Projects CRUD
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_project'])) {
        $title = $_POST['title'];
        $description = $_POST['description'];
        $category = $_POST['category'];
        $tags = $_POST['tags'];
        $live_link = $_POST['live_link'] ?? '';
        $github_link = $_POST['github_link'] ?? '';

        // Handle image upload
        $image_url = '';
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = 'uploads/projects/';
            $absoluteDir = __DIR__ . '/' . $uploadDir; // Fixed to use project root
            if (!is_dir($absoluteDir)) {
                mkdir($absoluteDir, 0755, true);
            }
            $filename = uniqid() . '_' . basename($_FILES['image']['name']);
            $targetPath = $absoluteDir . $filename;
            if (move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
                $image_url = $uploadDir . $filename;
            }
        }

        $stmt = $pdo->prepare("INSERT INTO projects (title, description, image_url, category, tags, live_link, github_link) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$title, $description, $image_url, $category, $tags, $live_link, $github_link]);
        $project_success = "Project added successfully!";
    }

    if (isset($_POST['update_project'])) {
        $id = $_POST['id'];
        $title = $_POST['title'];
        $description = $_POST['description'];
        $category = $_POST['category'];
        $tags = $_POST['tags'];
        $live_link = $_POST['live_link'] ?? '';
        $github_link = $_POST['github_link'] ?? '';

        // Handle image update
        $image_url = $_POST['current_image'];
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = 'uploads/projects/';
            $absoluteDir = __DIR__ . '/' . $uploadDir;
            if (!is_dir($absoluteDir)) {
                mkdir($absoluteDir, 0755, true);
            }
            $filename = uniqid() . '_' . basename($_FILES['image']['name']);
            $targetPath = $absoluteDir . $filename;
            if (move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
                // Delete old image if exists
                if ($image_url && file_exists(__DIR__ . '/' . $image_url)) {
                    unlink(__DIR__ . '/' . $image_url);
                }
                $image_url = $uploadDir . $filename;
            }
        }

        $stmt = $pdo->prepare("UPDATE projects SET title = ?, description = ?, image_url = ?, category = ?, tags = ?, live_link = ?, github_link = ? WHERE id = ?");
        $stmt->execute([$title, $description, $image_url, $category, $tags, $live_link, $github_link, $id]);
        $project_success = "Project updated successfully!";
    }

    if (isset($_POST['delete_project'])) {
        $id = $_POST['id'];

        // Delete image if exists
        $stmt = $pdo->prepare("SELECT image_url FROM projects WHERE id = ?");
        $stmt->execute([$id]);
        $project = $stmt->fetch();
        if ($project && $project['image_url'] && file_exists(__DIR__ . '/' . $project['image_url'])) {
            unlink(__DIR__ . '/' . $project['image_url']);
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

    // Blog CRUD
    if (isset($_POST['add_blog'])) {
        $title = $_POST['title'];
        $content = $_POST['content'];
        $excerpt = $_POST['excerpt'];
        $status = $_POST['status'];
        $author = $_SESSION['username'] ?? 'Admin';
        
        // Generate slug
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title)));
        
        // Handle image upload
        $featured_image = '';
        if (isset($_FILES['featured_image']) && $_FILES['featured_image']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = 'uploads/blog/';
            $absoluteDir = __DIR__ . '/' . $uploadDir;
            if (!is_dir($absoluteDir)) {
                mkdir($absoluteDir, 0755, true);
            }
            $filename = uniqid() . '_' . basename($_FILES['featured_image']['name']);
            $targetPath = $absoluteDir . $filename;
            if (move_uploaded_file($_FILES['featured_image']['tmp_name'], $targetPath)) {
                $featured_image = $uploadDir . $filename;
            }
        }

        $stmt = $pdo->prepare("INSERT INTO blog_posts (title, slug, content, excerpt, featured_image, author, status) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$title, $slug, $content, $excerpt, $featured_image, $author, $status]);
        $blog_success = "Blog post created successfully!";
    }

    if (isset($_POST['update_blog'])) {
        $id = $_POST['id'];
        $title = $_POST['title'];
        $content = $_POST['content'];
        $excerpt = $_POST['excerpt'];
        $status = $_POST['status'];
        
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title)));

        // Handle image update
        $featured_image = $_POST['current_image'];
        if (isset($_FILES['featured_image']) && $_FILES['featured_image']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = 'uploads/blog/';
            $absoluteDir = __DIR__ . '/' . $uploadDir;
            if (!is_dir($absoluteDir)) {
                mkdir($absoluteDir, 0755, true);
            }
            $filename = uniqid() . '_' . basename($_FILES['featured_image']['name']);
            $targetPath = $absoluteDir . $filename;
            if (move_uploaded_file($_FILES['featured_image']['tmp_name'], $targetPath)) {
                if ($featured_image && file_exists(__DIR__ . '/' . $featured_image)) {
                    unlink(__DIR__ . '/' . $featured_image);
                }
                $featured_image = $uploadDir . $filename;
            }
        }

        $stmt = $pdo->prepare("UPDATE blog_posts SET title = ?, slug = ?, content = ?, excerpt = ?, featured_image = ?, status = ? WHERE id = ?");
        $stmt->execute([$title, $slug, $content, $excerpt, $featured_image, $status, $id]);
        $blog_success = "Blog post updated successfully!";
    }

    if (isset($_POST['delete_blog'])) {
        $id = $_POST['id'];
        $stmt = $pdo->prepare("SELECT featured_image FROM blog_posts WHERE id = ?");
        $stmt->execute([$id]);
        $post = $stmt->fetch();
        if ($post && $post['featured_image'] && file_exists(__DIR__ . '/' . $post['featured_image'])) {
            unlink(__DIR__ . '/' . $post['featured_image']);
        }

        $stmt = $pdo->prepare("DELETE FROM blog_posts WHERE id = ?");
        $stmt->execute([$id]);
        $blog_success = "Blog post deleted successfully!";
    }

    // Services CRUD
    if (isset($_POST['add_service'])) {
        $title = $_POST['title'];
        $icon = $_POST['icon'];
        $description = $_POST['description'];
        $order_num = (int)$_POST['order_num'];

        $stmt = $pdo->prepare("INSERT INTO services (title, icon, description, order_num) VALUES (?, ?, ?, ?)");
        $stmt->execute([$title, $icon, $description, $order_num]);
        $service_success = "Service added successfully!";
    }

    if (isset($_POST['update_service'])) {
        $id = $_POST['id'];
        $title = $_POST['title'];
        $icon = $_POST['icon'];
        $description = $_POST['description'];
        $order_num = (int)$_POST['order_num'];

        $stmt = $pdo->prepare("UPDATE services SET title = ?, icon = ?, description = ?, order_num = ? WHERE id = ?");
        $stmt->execute([$title, $icon, $description, $order_num, $id]);
        $service_success = "Service updated successfully!";
    }

    if (isset($_POST['delete_service'])) {
        $id = $_POST['id'];
        $stmt = $pdo->prepare("DELETE FROM services WHERE id = ?");
        $stmt->execute([$id]);
        $service_success = "Service deleted successfully!";
    }

    // Journey CRUD
    if (isset($_POST['add_journey'])) {
        $year_range = $_POST['year_range'];
        $title = $_POST['title'];
        $company = $_POST['company'];
        $description = $_POST['description'];
        $position_side = $_POST['position_side'];
        $order_num = (int)$_POST['order_num'];

        $stmt = $pdo->prepare("INSERT INTO journey (year_range, title, company, description, position_side, order_num) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$year_range, $title, $company, $description, $position_side, $order_num]);
        $journey_success = "Journey milestone added successfully!";
    }

    if (isset($_POST['update_journey'])) {
        $id = $_POST['id'];
        $year_range = $_POST['year_range'];
        $title = $_POST['title'];
        $company = $_POST['company'];
        $description = $_POST['description'];
        $position_side = $_POST['position_side'];
        $order_num = (int)$_POST['order_num'];

        $stmt = $pdo->prepare("UPDATE journey SET year_range = ?, title = ?, company = ?, description = ?, position_side = ?, order_num = ? WHERE id = ?");
        $stmt->execute([$year_range, $title, $company, $description, $position_side, $order_num, $id]);
        $journey_success = "Journey milestone updated successfully!";
    }

    if (isset($_POST['delete_journey'])) {
        $id = $_POST['id'];
        $stmt = $pdo->prepare("DELETE FROM journey WHERE id = ?");
        $stmt->execute([$id]);
        $journey_success = "Journey milestone deleted successfully!";
    }

    // CV Personal Info
    if (isset($_POST['update_personal_info'])) {
        $id = $_POST['id'] ?? null;
        $full_name = htmlspecialchars(trim($_POST['full_name']));
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $phone = htmlspecialchars(trim($_POST['phone']));
        $address = htmlspecialchars(trim($_POST['address']));
        $website = filter_var($_POST['website'], FILTER_SANITIZE_URL);
        $linkedin = filter_var($_POST['linkedin'], FILTER_SANITIZE_URL);
        $github = filter_var($_POST['github'], FILTER_SANITIZE_URL);
        $hero_quote = htmlspecialchars(trim($_POST['hero_quote'] ?? ''));
        $summary = htmlspecialchars(trim($_POST['summary']));

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $cv_error = "Invalid email address.";
        } else {
            // Handle image upload
        $profile_image = '';
        $about_image = '';
        $cv_pdf = '';
        if ($id) {
            $stmt = $pdo->prepare("SELECT profile_image, about_image, cv_pdf FROM personal_info WHERE id = ?");
            $stmt->execute([$id]);
            $row = $stmt->fetch();
            $profile_image = $row['profile_image'] ?: '';
            $about_image = $row['about_image'] ?: '';
            $cv_pdf = $row['cv_pdf'] ?: '';
        }

        if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === UPLOAD_ERR_OK) {
            $allowed = ['jpg', 'jpeg', 'png', 'gif'];
            $ext = strtolower(pathinfo($_FILES['profile_image']['name'], PATHINFO_EXTENSION));
            if (in_array($ext, $allowed)) {
                $uploadDir = 'uploads/profile/';
                $absoluteDir = __DIR__ . '/' . $uploadDir;
                if (!is_dir($absoluteDir)) mkdir($absoluteDir, 0755, true);
                $filename = 'hero_' . uniqid() . '.' . $ext;
                if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $absoluteDir . $filename)) {
                    if ($profile_image && file_exists(__DIR__ . '/' . $profile_image)) unlink(__DIR__ . '/' . $profile_image);
                    $profile_image = $uploadDir . $filename;
                }
            }
        }

        if (isset($_FILES['about_image']) && $_FILES['about_image']['error'] === UPLOAD_ERR_OK) {
            $allowed = ['jpg', 'jpeg', 'png', 'gif'];
            $ext = strtolower(pathinfo($_FILES['about_image']['name'], PATHINFO_EXTENSION));
            if (in_array($ext, $allowed)) {
                $uploadDir = 'uploads/profile/';
                $absoluteDir = __DIR__ . '/' . $uploadDir;
                if (!is_dir($absoluteDir)) mkdir($absoluteDir, 0755, true);
                $filename = 'about_' . uniqid() . '.' . $ext;
                if (move_uploaded_file($_FILES['about_image']['tmp_name'], $absoluteDir . $filename)) {
                    if ($about_image && file_exists(__DIR__ . '/' . $about_image)) unlink(__DIR__ . '/' . $about_image);
                    $about_image = $uploadDir . $filename;
                }
            }
        }

        // Handle CV PDF upload
        if (isset($_FILES['cv_pdf']) && $_FILES['cv_pdf']['error'] === UPLOAD_ERR_OK) {
            $ext = strtolower(pathinfo($_FILES['cv_pdf']['name'], PATHINFO_EXTENSION));
            if ($ext === 'pdf') {
                $uploadDir = 'uploads/cv/';
                $absoluteDir = __DIR__ . '/' . $uploadDir;
                if (!is_dir($absoluteDir)) mkdir($absoluteDir, 0755, true);
                $filename = uniqid() . '_' . basename($_FILES['cv_pdf']['name']);
                if (move_uploaded_file($_FILES['cv_pdf']['tmp_name'], $absoluteDir . $filename)) {
                    if ($cv_pdf && file_exists(__DIR__ . '/' . $cv_pdf)) unlink(__DIR__ . '/' . $cv_pdf);
                    $cv_pdf = $uploadDir . $filename;
                }
            }
        }

        if ($id) {
            $stmt = $pdo->prepare("UPDATE personal_info SET full_name = ?, email = ?, phone = ?, address = ?, website = ?, linkedin = ?, github = ?, hero_quote = ?, summary = ?, profile_image = ?, about_image = ?, cv_pdf = ? WHERE id = ?");
            $stmt->execute([$full_name, $email, $phone, $address, $website, $linkedin, $github, $hero_quote, $summary, $profile_image, $about_image, $cv_pdf, $id]);
        } else {
            $stmt = $pdo->prepare("INSERT INTO personal_info (full_name, email, phone, address, website, linkedin, github, hero_quote, summary, profile_image, about_image, cv_pdf) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$full_name, $email, $phone, $address, $website, $linkedin, $github, $hero_quote, $summary, $profile_image, $about_image, $cv_pdf]);
        }
            $cv_success = "Personal info updated successfully!";
        }
    }

    // CV Sections CRUD
    if (isset($_POST['add_section'])) {
        $name = htmlspecialchars(trim($_POST['name']));
        $slug = preg_replace('/[^a-z0-9-]/', '', strtolower(trim($_POST['slug'])));
        $order = (int)$_POST['display_order'];
        
        if (empty($name) || empty($slug)) {
            $cv_error = "Name and slug are required.";
        } else {
            $stmt = $pdo->prepare("INSERT INTO cv_sections (name, slug, display_order) VALUES (?, ?, ?)");
            $stmt->execute([$name, $slug, $order]);
            $cv_success = "Section added successfully!";
        }
    }

    if (isset($_POST['update_section'])) {
        $id = (int)$_POST['id'];
        $name = htmlspecialchars(trim($_POST['name']));
        $slug = preg_replace('/[^a-z0-9-]/', '', strtolower(trim($_POST['slug'])));
        $order = (int)$_POST['display_order'];
        
        if (empty($name) || empty($slug)) {
            $cv_error = "Name and slug are required.";
        } else {
            // Log history
            $stmt = $pdo->prepare("SELECT * FROM cv_sections WHERE id = ?");
            $stmt->execute([$id]);
            $old_data = $stmt->fetch();
            
            $stmt = $pdo->prepare("UPDATE cv_sections SET name = ?, slug = ?, display_order = ? WHERE id = ?");
            $stmt->execute([$name, $slug, $order, $id]);
            
            $stmt = $pdo->prepare("INSERT INTO cv_history (section_id, action_type, old_data, new_data, changed_by) VALUES (?, 'update', ?, ?, ?)");
            $stmt->execute([$id, json_encode($old_data), json_encode(['name' => $name, 'slug' => $slug, 'display_order' => $order]), $_SESSION['user']['id']]);
            
            $cv_success = "Section updated successfully!";
        }
    }

    if (isset($_POST['delete_section'])) {
        $id = (int)$_POST['id'];
        $stmt = $pdo->prepare("DELETE FROM cv_sections WHERE id = ?");
        $stmt->execute([$id]);
        $cv_success = "Section deleted successfully!";
    }

    // CV Items CRUD
    if (isset($_POST['add_item'])) {
        $section_id = (int)$_POST['section_id'];
        $title = htmlspecialchars(trim($_POST['title']));
        $subtitle = htmlspecialchars(trim($_POST['subtitle']));
        $date_range = htmlspecialchars(trim($_POST['date_range']));
        $location = htmlspecialchars(trim($_POST['location']));
        $description = htmlspecialchars(trim($_POST['description']));
        $order = (int)$_POST['display_order'];
        
        if (empty($title)) {
            $cv_error = "Title is required.";
        } else {
            $stmt = $pdo->prepare("INSERT INTO cv_items (section_id, title, subtitle, date_range, location, description, display_order) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$section_id, $title, $subtitle, $date_range, $location, $description, $order]);
            $cv_success = "CV Item added successfully!";
        }
    }

    if (isset($_POST['update_item'])) {
        $id = (int)$_POST['id'];
        $section_id = (int)$_POST['section_id'];
        $title = htmlspecialchars(trim($_POST['title']));
        $subtitle = htmlspecialchars(trim($_POST['subtitle']));
        $date_range = htmlspecialchars(trim($_POST['date_range']));
        $location = htmlspecialchars(trim($_POST['location']));
        $description = htmlspecialchars(trim($_POST['description']));
        $order = (int)$_POST['display_order'];
        
        if (empty($title)) {
            $cv_error = "Title is required.";
        } else {
            // Log history
            $stmt = $pdo->prepare("SELECT * FROM cv_items WHERE id = ?");
            $stmt->execute([$id]);
            $old_data = $stmt->fetch();
            
            $stmt = $pdo->prepare("UPDATE cv_items SET section_id = ?, title = ?, subtitle = ?, date_range = ?, location = ?, description = ?, display_order = ? WHERE id = ?");
            $stmt->execute([$section_id, $title, $subtitle, $date_range, $location, $description, $order, $id]);
            
            $stmt = $pdo->prepare("INSERT INTO cv_history (item_id, action_type, old_data, new_data, changed_by) VALUES (?, 'update', ?, ?, ?)");
            $stmt->execute([$id, json_encode($old_data), json_encode(['section_id' => $section_id, 'title' => $title, 'subtitle' => $subtitle, 'date_range' => $date_range, 'location' => $location, 'description' => $description, 'display_order' => $order]), $_SESSION['user']['id']]);
            
            $cv_success = "CV Item updated successfully!";
        }
    }

    if (isset($_POST['delete_item'])) {
        $id = $_POST['id'];
        $stmt = $pdo->prepare("DELETE FROM cv_items WHERE id = ?");
        $stmt->execute([$id]);
        $cv_success = "CV Item deleted successfully!";
    }

    // Rollback Logic
    if (isset($_POST['rollback'])) {
        $history_id = $_POST['history_id'];
        $stmt = $pdo->prepare("SELECT * FROM cv_history WHERE id = ?");
        $stmt->execute([$history_id]);
        $h = $stmt->fetch();
        
        if ($h) {
            $old_data = json_decode($h['old_data'], true);
            if ($h['item_id']) {
                $stmt = $pdo->prepare("UPDATE cv_items SET section_id = ?, title = ?, subtitle = ?, date_range = ?, location = ?, description = ?, display_order = ? WHERE id = ?");
                $stmt->execute([$old_data['section_id'], $old_data['title'], $old_data['subtitle'], $old_data['date_range'], $old_data['location'], $old_data['description'], $old_data['display_order'], $h['item_id']]);
            } else if ($h['section_id']) {
                $stmt = $pdo->prepare("UPDATE cv_sections SET name = ?, slug = ?, display_order = ? WHERE id = ?");
                $stmt->execute([$old_data['name'], $old_data['slug'], $old_data['display_order'], $h['section_id']]);
            }
            $cv_success = "Rollback successful!";
        }
    }

    // Category Management
    if (isset($_POST['add_skill_category'])) {
        $name = htmlspecialchars(trim($_POST['name']));
        $order = (int)$_POST['display_order'];
        $stmt = $pdo->prepare("INSERT INTO skill_categories (name, display_order) VALUES (?, ?)");
        $stmt->execute([$name, $order]);
        $cat_success = "Skill category added!";
    }
    if (isset($_POST['delete_skill_category'])) {
        $id = (int)$_POST['id'];
        $stmt = $pdo->prepare("DELETE FROM skill_categories WHERE id = ?");
        $stmt->execute([$id]);
        $cat_success = "Skill category deleted!";
    }
    if (isset($_POST['add_project_category'])) {
        $name = htmlspecialchars(trim($_POST['name']));
        $slug = htmlspecialchars(trim($_POST['slug']));
        $order = (int)$_POST['display_order'];
        $stmt = $pdo->prepare("INSERT INTO project_categories (name, slug, display_order) VALUES (?, ?, ?)");
        $stmt->execute([$name, $slug, $order]);
        $cat_success = "Project category added!";
    }
    if (isset($_POST['delete_project_category'])) {
        $id = (int)$_POST['id'];
        $stmt = $pdo->prepare("DELETE FROM project_categories WHERE id = ?");
        $stmt->execute([$id]);
        $cat_success = "Project category deleted!";
    }

    // Message Reply
    if (isset($_POST['reply_message'])) {
        $message_id = $_POST['message_id'];
        $reply_text = $_POST['reply_text'];

        if (!empty($reply_text)) {
            // Save reply to database
            $stmt = $pdo->prepare("INSERT INTO message_replies (message_id, reply_text) VALUES (?, ?)");
            $stmt->execute([$message_id, $reply_text]);

            // Mark original message as read
            $stmt = $pdo->prepare("UPDATE messages SET is_read = TRUE WHERE id = ?");
            $stmt->execute([$message_id]);

            // Send email to user (optional but recommended)
            $stmt = $pdo->prepare("SELECT email, name, subject FROM messages WHERE id = ?");
            $stmt->execute([$message_id]);
            $msg = $stmt->fetch();
            
            if ($msg) {
                require_once 'auto_reply.php';
                if (sendAdminReply($msg['email'], $msg['name'], $msg['subject'], $reply_text)) {
                    $message_success = "Reply sent and saved successfully!";
                } else {
                    $message_error = "Reply saved to database, but email delivery failed. Please check SMTP settings.";
                }
            }
        } else {
            $message_error = "Reply cannot be empty.";
        }
    }
}

// Get all services
$services_list = $pdo->query("SELECT * FROM services ORDER BY order_num ASC, created_at DESC")->fetchAll();

// Get all blog posts
$blog_posts = $pdo->query("SELECT * FROM blog_posts ORDER BY created_at DESC")->fetchAll();

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