<?php
$skill_categories = $pdo->query("SELECT * FROM skill_categories ORDER BY display_order ASC")->fetchAll();
?>
<div class="card">
    <h3>Add New Skill</h3>
    <form method="POST">
        <div class="form-group">
            <label for="category_id">Category</label>
            <select id="category_id" name="category_id" required>
                <?php foreach ($skill_categories as $cat): ?>
                    <option value="<?php echo $cat['id']; ?>"><?php echo htmlspecialchars($cat['name']); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="name">Skill Name</label>
            <input type="text" id="name" name="name" required>
        </div>
        <div class="form-group">
            <label for="proficiency">Proficiency (1-100)</label>
            <input type="number" id="proficiency" name="proficiency" min="1" max="100" required>
        </div>
        <button type="submit" name="add_skill" class="btn btn-primary">Add Skill</button>
    </form>
</div>

<div class="card">
    <h3>All Skills</h3>
    <?php if (isset($skill_success)): ?>
        <div style="color: green; margin-bottom: 15px;"><?php echo $skill_success; ?></div>
    <?php endif; ?>
    <table>
        <thead>
            <tr>
                <th>Category</th>
                <th>Name</th>
                <th>Proficiency</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $skills_with_cat = $pdo->query("SELECT s.*, c.name as cat_name FROM skills s LEFT JOIN skill_categories c ON s.category_id = c.id ORDER BY c.display_order, s.name")->fetchAll();
            foreach ($skills_with_cat as $skill): 
            ?>
                <tr>
                    <td><?php echo htmlspecialchars($skill['cat_name'] ?? 'Uncategorized'); ?></td>
                    <td><?php echo htmlspecialchars($skill['name']); ?></td>
                    <td><?php echo htmlspecialchars($skill['proficiency']); ?>%</td>
                    <td>
                        <a href="admin.php?section=skills&edit=<?php echo $skill['id']; ?>" class="btn btn-primary">Edit</a>
                        <form method="POST" style="display: inline;">
                            <input type="hidden" name="id" value="<?php echo $skill['id']; ?>">
                            <button type="submit" name="delete_skill" class="btn btn-danger"
                                onclick="return confirm('Are you sure you want to delete this skill?')">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php if (isset($_GET['edit'])):
    $edit_id = $_GET['edit'];
    $edit_skill = $pdo->prepare("SELECT * FROM skills WHERE id = ?");
    $edit_skill->execute([$edit_id]);
    $skill = $edit_skill->fetch();
    if ($skill):
        ?>
        <div class="card">
            <h3>Edit Skill</h3>
            <form method="POST">
                <input type="hidden" name="id" value="<?php echo $skill['id']; ?>">
                <div class="form-group">
                    <label for="edit_category_id">Category</label>
                    <select id="edit_category_id" name="category_id" required>
                        <?php foreach ($skill_categories as $cat): ?>
                            <option value="<?php echo $cat['id']; ?>" <?php echo $skill['category_id'] == $cat['id'] ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($cat['name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="edit_name">Skill Name</label>
                    <input type="text" id="edit_name" name="name" value="<?php echo htmlspecialchars($skill['name']); ?>"
                        required>
                </div>
                <div class="form-group">
                    <label for="edit_proficiency">Proficiency (1-100)</label>
                    <input type="number" id="edit_proficiency" name="proficiency" min="1" max="100"
                        value="<?php echo htmlspecialchars($skill['proficiency']); ?>" required>
                </div>
                <button type="submit" name="update_skill" class="btn btn-primary">Update Skill</button>
            </form>
        </div>
    <?php endif; endif; ?>