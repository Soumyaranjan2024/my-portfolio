<?php
// Category Management
$skill_categories = $pdo->query("SELECT * FROM skill_categories ORDER BY display_order ASC")->fetchAll();
$project_categories = $pdo->query("SELECT * FROM project_categories ORDER BY display_order ASC")->fetchAll();
?>

<div class="category-admin-container">
    <?php if (isset($cat_success)): ?>
        <div class="alert alert-success">✅ <?php echo $cat_success; ?></div>
    <?php endif; ?>

    <!-- Skill Categories -->
    <div class="card">
        <h3>🛠️ Skill Categories</h3>
        <form action="" method="POST">
            <input type="text" name="name" placeholder="New skill category" required>
            <input type="number" name="display_order" value="0">
            <button type="submit" name="add_skill_category" class="btn btn-primary">Add</button>
        </form>
        <table>
            <tbody>
                <?php foreach ($skill_categories as $cat): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($cat['name']); ?></td>
                        <td>
                            <form action="" method="POST" style="display:inline;">
                                <input type="hidden" name="id" value="<?php echo $cat['id']; ?>">
                                <button type="submit" name="delete_skill_category" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Project Categories -->
    <div class="card">
        <h3>📁 Project Categories</h3>
        <form action="" method="POST">
            <input type="text" name="name" placeholder="New project category" required>
            <input type="text" name="slug" placeholder="new-project-slug" required>
            <input type="number" name="display_order" value="0">
            <button type="submit" name="add_project_category" class="btn btn-primary">Add</button>
        </form>
        <table>
            <tbody>
                <?php foreach ($project_categories as $cat): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($cat['name']); ?></td>
                        <td><code><?php echo htmlspecialchars($cat['slug']); ?></code></td>
                        <td>
                            <form action="" method="POST" style="display:inline;">
                                <input type="hidden" name="id" value="<?php echo $cat['id']; ?>">
                                <button type="submit" name="delete_project_category" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
