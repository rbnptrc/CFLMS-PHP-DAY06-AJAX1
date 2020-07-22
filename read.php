<?php 
    require_once 'db_conn6.php';

    $sql = "SELECT * FROM user";
    $res = $connect->query($sql);
?>

<table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Position</th>
                    </tr>
                </thead>
                <?php
                while ($row = $res->fetch_assoc()) : ?>
                    <tr>
                        <td><?= $row['userId']; ?></td>
                        <td><?= $row['userName']; ?></td>
                        <td><?= $row['position']; ?></td>
                        <td>
                            <a href="update.php?update=<?= $row['userId']; ?>" class="btn btn-info" name="update">Update</a>

                            <a href="delete.php?delete=<?= $row['userId']; ?>" class="btn btn-danger" name="delete">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </table>