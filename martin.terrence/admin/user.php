
<?php
// Location of our JSON file
$jsonFile = __DIR__ . '/../data/users.json';

// Read and decode the JSON data
$jsonData = file_get_contents($jsonFile);
$users = json_decode($jsonData, true);

// Make sure we have an array
if (!is_array($users)) {
    $users = [];
}

// Get the selected user's ID from the URL
$userId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

// Find the matching user
$selectedUser = null;

foreach ($users as $user) {
    if (isset($user['id']) && (int)$user['id'] === $userId) {
        $selectedUser = $user;
        break;
    }
}

// Safely display text inside HTML
function escapeHtml($value) {
    return htmlspecialchars(
        (string)$value,
        ENT_QUOTES,
        'UTF-8'
    );
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>User Editor | GEMWHIZ</title>

    <link rel="stylesheet" href="../css/storetheme.css">
</head>

<body>

<main class="container">

    <h1>GEMWHIZ User Editor</h1>

    <p>
        <a href="index.php">Back to User List</a>
    </p>

    <?php if ($selectedUser === null): ?>

        <h2>User Not Found</h2>
        <p>Please select a valid user from the list.</p>

    <?php else: ?>

        <h2>
            Editing:
            <?php
            echo escapeHtml(
                $selectedUser['first_name'] . ' ' .
                $selectedUser['last_name']
            );
            ?>
        </h2>

        <form method="post" action="user.php">

            <input
                type="hidden"
                name="id"
                value="<?php echo escapeHtml($selectedUser['id']); ?>"
            >

            <fieldset>
                <legend>User Information</legend>

                <p>
                    <label for="first_name">First Name</label>
                    <input
                        type="text"
                        id="first_name"
                        name="first_name"
                        value="<?php echo escapeHtml($selectedUser['first_name']); ?>"
                        required
                    >
                </p>

                <p>
                    <label for="last_name">Last Name</label>
                    <input
                        type="text"
                        id="last_name"
                        name="last_name"
                        value="<?php echo escapeHtml($selectedUser['last_name']); ?>"
                        required
                    >
                </p>

                <p>
                    <label for="email">Email Address</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="<?php echo escapeHtml($selectedUser['email']); ?>"
                        required
                    >
                </p>

                <p>
                    <label for="role">User Role</label>
                    <select id="role" name="role">
                        <option value="Customer"
                            <?php echo $selectedUser['role'] === 'Customer' ? 'selected' : ''; ?>>
                            Customer
                        </option>

                        <option value="Administrator"
                            <?php echo $selectedUser['role'] === 'Administrator' ? 'selected' : ''; ?>>
                            Administrator
                        </option>
                    </select>
                </p>
            </fieldset>

            <p>
                <button type="button" disabled>
                    Save Changes (Part 2)
                </button>
            </p>

            <p>
                This is a demonstration editor.
                Changes are not saved to the JSON file.
            </p>

        </form>

    <?php endif; ?>

</main>

</body>
</html>
