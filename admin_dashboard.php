<div class="card">
    <h3>Dashboard Overview</h3>
    <div
        style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-top: 20px;">
        <div class="card" style="text-align: center;">
            <h4>Projects</h4>
            <p style="font-size: 2rem; color: #6c63ff;"><?php echo $total_projects; ?></p>
        </div>
        <div class="card" style="text-align: center;">
            <h4>Skills</h4>
            <p style="font-size: 2rem; color: #6c63ff;"><?php echo $total_skills; ?></p>
        </div>
        <div class="card" style="text-align: center;">
            <h4>Messages</h4>
            <p style="font-size: 2rem; color: #6c63ff;"><?php echo $total_messages; ?></p>
        </div>
        <div class="card" style="text-align: center;">
            <h4>Unread Messages</h4>
            <p style="font-size: 2rem; color: #6c63ff;"><?php echo $unread_messages; ?></p>
        </div>
    </div>
</div>

<div class="card">
    <h3>Recent Messages</h3>
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Subject</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach (array_slice($messages, 0, 5) as $message): ?>
                <tr style="<?php echo $message['is_read'] ? '' : 'background-color: #f8f9fa; font-weight: 500;'; ?>">
                    <td><?php echo htmlspecialchars($message['name']); ?></td>
                    <td><?php echo htmlspecialchars($message['email']); ?></td>
                    <td><?php echo htmlspecialchars($message['subject'] ?: 'No Subject'); ?></td>
                    <td><?php echo date('M d, Y', strtotime($message['created_at'])); ?></td>
                    <td>
                        <a href="admin.php?section=messages&view=<?php echo $message['id']; ?>"
                            class="btn btn-primary">View</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div style="text-align: right; margin-top: 15px;">
        <a href="admin.php?section=messages" class="btn btn-primary">View All Messages</a>
    </div>
</div>