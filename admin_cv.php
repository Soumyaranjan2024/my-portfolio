<?php
// CV Management Section
$personal_info = $pdo->query("SELECT * FROM personal_info LIMIT 1")->fetch();
?>

<div class="cv-admin-container">
    <!-- Status Messages -->
    <?php if (isset($cv_success)): ?>
        <div class="alert alert-success" style="background: #d4edda; color: #155724; padding: 15px; border-radius: 10px; margin-bottom: 20px;">
            <i class="fas fa-check-circle"></i> <?php echo $cv_success; ?>
        </div>
    <?php endif; ?>
    <?php if (isset($cv_error)): ?>
        <div class="alert alert-danger" style="background: #fee2e2; color: #991b1b; padding: 15px; border-radius: 10px; margin-bottom: 20px;">
            <i class="fas fa-exclamation-circle"></i> <?php echo $cv_error; ?>
        </div>
    <?php endif; ?>

    <!-- Personal Info & CV Upload Section -->
    <div class="card">
        <h3>👤 Personal Information & CV Upload</h3>
        <form action="" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $personal_info['id'] ?? ''; ?>">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div class="form-group">
                    <label>Full Name</label>
                    <input type="text" name="full_name" value="<?php echo htmlspecialchars($personal_info['full_name'] ?? ''); ?>" required>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" value="<?php echo htmlspecialchars($personal_info['email'] ?? ''); ?>" required>
                </div>
                <div class="form-group">
                    <label>Phone</label>
                    <input type="text" name="phone" value="<?php echo htmlspecialchars($personal_info['phone'] ?? ''); ?>">
                </div>
                <div class="form-group">
                    <label>Address</label>
                    <input type="text" name="address" value="<?php echo htmlspecialchars($personal_info['address'] ?? ''); ?>">
                </div>
                <div class="form-group">
                    <label>Website</label>
                    <input type="url" name="website" value="<?php echo htmlspecialchars($personal_info['website'] ?? ''); ?>">
                </div>
                <div class="form-group">
                    <label>LinkedIn</label>
                    <input type="url" name="linkedin" value="<?php echo htmlspecialchars($personal_info['linkedin'] ?? ''); ?>">
                </div>
                <div class="form-group">
                    <label>GitHub</label>
                    <input type="url" name="github" value="<?php echo htmlspecialchars($personal_info['github'] ?? ''); ?>">
                </div>
                <div class="form-group" style="grid-column: span 2;">
                    <label>Hero Quote / Tagline</label>
                    <input type="text" name="hero_quote" value="<?php echo htmlspecialchars($personal_info['hero_quote'] ?? ''); ?>" placeholder="e.g. Building the future of the web, one line at a time.">
                </div>
                <div class="form-group">
                    <label>Hero/Profile Photo</label>
                    <input type="file" name="profile_image" accept="image/*">
                    <?php if ($personal_info['profile_image'] ?? false): ?>
                        <div style="margin-top: 10px;">
                            <img src="<?php echo $personal_info['profile_image']; ?>" alt="Hero Photo" style="width: 80px; height: 80px; object-fit: cover; border-radius: 50%;">
                            <br><small>Current: <?php echo basename($personal_info['profile_image']); ?></small>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <label>About Section Photo</label>
                    <input type="file" name="about_image" accept="image/*">
                    <?php if ($personal_info['about_image'] ?? false): ?>
                        <div style="margin-top: 10px;">
                            <img src="<?php echo $personal_info['about_image']; ?>" alt="About Photo" style="width: 80px; height: 80px; object-fit: cover; border-radius: 50%;">
                            <br><small>Current: <?php echo basename($personal_info['about_image']); ?></small>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="form-group" style="margin-top: 20px;">
                <label>About Me Text (Full Section)</label>
                <textarea name="summary" rows="10" placeholder="Write your full about section content here. Each new line will be a new paragraph."><?php echo htmlspecialchars($personal_info['summary'] ?? ''); ?></textarea>
                <small style="color: #64748b;">This text will populate the 'About Me' section on the homepage and about page. New lines will be converted to paragraphs.</small>
            </div>
            
            <hr style="margin: 30px 0; border: 1px solid #f1f5f9;">

            <div>
                <h4>📄 Upload New CV</h4>
                <div class="form-group" style="margin-top: 15px;">
                    <label>CV PDF File</label>
                    <input type="file" name="cv_pdf" accept="application/pdf">
                    <?php if ($personal_info['cv_pdf'] ?? false): ?>
                        <p style="margin-top: 10px;">Current CV: <a href="<?php echo $personal_info['cv_pdf']; ?>" target="_blank" class="btn btn-secondary btn-sm"><i class="fas fa-file-pdf"></i> <?php echo basename($personal_info['cv_pdf']); ?></a></p>
                    <?php endif; ?>
                </div>
            </div>

            <button type="submit" name="update_personal_info" class="btn btn-primary" style="margin-top: 30px;">
                <i class="fas fa-save"></i> Save Changes
            </button>
        </form>
    </div>
</div>

<style>
    .cv-admin-container .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: #475569;
        font-size: 14px;
    }
    .cv-admin-container input[type="text"],
    .cv-admin-container input[type="email"],
    .cv-admin-container input[type="url"],
    .cv-admin-container textarea,
    .cv-admin-container select {
        width: 100%;
        padding: 12px;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        font-family: 'Inter', sans-serif;
        font-size: 14px;
        transition: border-color 0.3s ease;
    }
    .cv-admin-container input:focus, 
    .cv-admin-container textarea:focus,
    .cv-admin-container select:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }
</style>
