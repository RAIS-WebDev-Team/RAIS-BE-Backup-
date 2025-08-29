<div class="content-card">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="mb-0">User Management</h2>
    </div>
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Last Activity</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="userTableBody">
                <?php
                if (isset($users) && is_array($users)) {
                    $threshold_time = strtotime("-$active_threshold minutes");
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
                }
                ?>
            </tbody>
        </table>
    </div>
</div>