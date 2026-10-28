
<?php
// Read our JSON file
$jsonFile = __DIR__ . '/../data/users.json';
$jsonData = file_get_contents($jsonFile);

// Convert JSON into a PHP array
$users = json_decode($jsonData, true);

if (!is_array($users)) {
    $users = [];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>User Administration | GEMWHIZ</title>

    <link rel="stylesheet"
          href="../css/storetheme.css">
</head>

<body>

<main class="container">

    <h1>GEMWHIZ User Administration</h1>

    <p>
        Select a user to view and edit their information.
    </p>

    <h2>User List</h2>

    <?php if (empty($users)): ?>

        <p>No users found.</p>

    <?php else: ?>

        <ul>
            <?php foreach ($users as $user): ?>

                <li>
                    <a href="user.php?id=<?php
                        echo urlencode($user['id']);
                    ?>">
                        <?php
                        echo htmlspecialchars(
                            $user['first_name'] . ' ' .
                            $user['last_name'],
                            ENT_QUOTES,
                            'UTF-8'
                        );
                        ?>
                    </a>

                    — <?php echo htmlspecialchars(
                        $user['role'],
                        ENT_QUOTES,
                        'UTF-8'
                    ); ?>
                </li>

            <?php endforeach; ?>
        </ul>

    <?php endif; ?>

    <p>
        <a href="../index.php">
            Return to GEMWHIZ
        </a>
    </p>

</main>

</body>
</html>
s