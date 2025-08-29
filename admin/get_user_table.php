<?php
require_once '../config.php';
$active_threshold = 5;
$users = [];
$sql_users = "SELECT id, firstName, lastName, email, status, last_login, role, last_activity FROM users ORDER BY id ASC";
if ($result = $conn->query($sql_users)) {
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
}
$conn->close();

$threshold_time = strtotime("-$active_threshold seconds");
foreach ($users as $user) {
    $is_online = !empty($user['last_activity']) && strtotime($user['last_activity']) >= $threshold_time;
    $statusBadgeClass = $is_online ? 'bg-success' : 'bg-secondary';
    $statusText = $is_online ? 'Online' : 'Offline';
    $lastActivityDisplay = !empty($user['last_activity']) ? date("M d, Y h:i A", strtotime($user['last_activity'])) : 'Never';
    echo "<tr id='user-row-" . htmlspecialchars($user['id']) . "'>";
    echo "<td>" . htmlspecialchars($user['id']) . "</td>";
    echo "<td>" . htmlspecialchars($user['firstName']) . "</td>";
    echo "<td>" . htmlspecialchars($user['lastName']) . "</td>";
    echo "<td>" . htmlspecialchars($user['email']) . "</td>";
    echo "<td><span class=\"badge " . $statusBadgeClass . "\">" . $statusText . "</span></td>";
    echo "<td>" . $lastActivityDisplay . "</td>";
    echo '<td>
            <button class="btn btn-sm btn-info me-1 edit-btn" data-bs-toggle="modal" data-bs-target="#editUserModal" data-user-id="' . htmlspecialchars($user['id']) . '">Edit</button>
            <button class="btn btn-sm btn-danger delete-btn" data-bs-toggle="modal" data-bs-target="#deleteConfirmModal" data-user-id="' . htmlspecialchars($user['id']) . '">Delete</button>
          </td>';
    echo "</tr>";
}
?>