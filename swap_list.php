<?php
include "includes/auth.php";
include "includes/db.php";

$user_id = $_SESSION['user_id'];

// Fetch all swap requests sent by this user
$sql = "SELECT s.id, i.title, s.status, s.created_at 
        FROM swap_requests s 
        JOIN items i ON s.item_id = i.id 
        WHERE s.requester_id = $user_id 
        ORDER BY s.created_at DESC";

$result = $conn->query($sql);
?>

<h2>My Swap Requests</h2>
<?php if ($result->num_rows > 0): ?>
    <table border="1" cellpadding="10">
        <tr>
            <th>#</th>
            <th>Item Title</th>
            <th>Status</th>
            <th>Requested At</th>
        </tr>
        <?php while($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= htmlspecialchars($row['title']) ?></td>
            <td><?= ucfirst($row['status']) ?></td>
            <td><?= $row['created_at'] ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
<?php else: ?>
    <p>No swap requests made yet.</p>
<?php endif; ?>
