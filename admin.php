<!-- READ -->
<!-- shows exsisting managers in a table for users to edit or delete-->
<div>
    <?php
    // connects to database
    require "connect.php"; 

    //create query 
    $sql = "SELECT * FROM registrations ORDER BY created_at DESC";

    //prepare
    $stmt = $pdo->prepare($sql);

    //execute 
    $stmt->execute();

    //retrieve all rows returned by a SQL query at once
    $managers = $stmt->fetchAll();
    ?>
<!-- Table to display managers  -->
    <div>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Email</th>
                </tr>
            </thead>
            <tbody>
                <!-- loop through -->
                <?php foreach ($managers as $managers): ?>
                    <tr>
                        <td><?= htmlspecialchars($managers["first_name"] . " " . $managers["last_name"]) ?></td>
                        <td><?= htmlspecialchars($managers["phone"]) ?></td>
                        <td><?= htmlspecialchars($managers["email"]) ?></td>
                        <td class="text-end">
                            <!-- button to edit info directs to edit.php -->
                            <a href="edit.php?id=<?= $managers["id"] ?>">Edit</a>
                            <!-- button to delete member direct to delete.php -->
                            <a href="delete.php?id=<?= $managers["id"] ?>"
                                onclick="return confirm('Delete this member?');">
                                Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>