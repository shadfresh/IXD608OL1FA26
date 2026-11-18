
<?php
// GEMWHIZ - Demo Order Confirmation

session_start();

require_once dirname(__DIR__, 3) . '/private_config/database.php';

// Only process a submitted checkout form.
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: checkout.php");
    exit;
}

// Get customer information from the form.
$fullname = trim($_POST['fullname'] ?? '');
$email = trim($_POST['email'] ?? '');
$address = trim($_POST['address'] ?? '');
$city = trim($_POST['city'] ?? '');
$state = trim($_POST['state'] ?? '');
$zipcode = trim($_POST['zipcode'] ?? '');

// Make sure the form was completed.
if (
    $fullname === '' ||
    $email === '' ||
    !filter_var($email, FILTER_VALIDATE_EMAIL) ||
    $address === '' ||
    $city === '' ||
    $state === '' ||
    $zipcode === ''
) {
    header("Location: checkout.php");
    exit;
}

// Make sure the shopping cart exists.
if (
    !isset($_SESSION['cart']) ||
    empty($_SESSION['cart'])
) {
    header("Location: cart.php");
    exit;
}

// Get the products from the shopping cart.
$order_items = [];
$total = 0;

foreach ($_SESSION['cart'] as $id => $quantity) {

    $id = (int)$id;

    $stmt = $conn->prepare(
        "SELECT id, name, price, quantity
         FROM products WHERE id = ?"
    );

    $stmt->bind_param("i", $id);
    $stmt->execute();

    $product = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if (!$product || (int)$product['quantity'] <= 0) {
        continue;
    }

    $quantity = min(
        (int)$quantity,
        (int)$product['quantity']
    );

    if ($quantity <= 0) {
        continue;
    }

    $subtotal = (float)$product['price'] * $quantity;
    $total += $subtotal;

    $product['cart_quantity'] = $quantity;
    $product['subtotal'] = $subtotal;

    $order_items[] = $product;
}

// Return to cart if there are no valid items.
if (empty($order_items)) {
    header("Location: cart.php");
    exit;
}

// Save the demo confirmation in the session.
$_SESSION['demo_order'] = [
    'fullname' => $fullname,
    'items' => $order_items,
    'total' => $total
];

// Clear the shopping cart after checkout.
$_SESSION['cart'] = [];

include __DIR__ . '/parts/header.php';
?>

<section class="order-confirmation">

    <h2>Order Confirmation</h2>

    <div class="confirmation-message">

        <h3>
            Thank You for Exploring GEMWHIZ!
        </h3>

        <p>
            Thank you,
            <?= htmlspecialchars($fullname, ENT_QUOTES, 'UTF-8') ?>!
        </p>

        <p>
            You have successfully completed the
            demonstration checkout.
        </p>

        <p>
            This is a sample checkout experience.
            No actual order has been placed,
            and no payment has been processed.
        </p>

    </div>

    <div class="order-details">

        <h3>Demo Order Summary</h3>

        <p>Collection: Fall Alchemy</p>

        <?php foreach ($order_items as $item): ?>

            <p>
                Product:
                <?= htmlspecialchars(
                    $item['name'],
                    ENT_QUOTES,
                    'UTF-8'
                ) ?>
            </p>

            <p>
                Quantity:
                <?= (int)$item['cart_quantity'] ?>
            </p>

            <p>
                Subtotal:
                $<?= number_format(
                    (float)$item['subtotal'],
                    2
                ) ?>
            </p>

        <?php endforeach; ?>

        <p>
            <strong>
                Demo Total:
                $<?= number_format($total, 2) ?>
            </strong>
        </p>

        <p>
            Shipping and taxes are not included.
        </p>

    </div>

    <div class="confirmation-actions">

        <a href="products.php" class="button">
            Continue Shopping
        </a>

        <a href="index.php" class="button">
            Return Home
        </a>

    </div>

</section>

<?php
include __DIR__ . '/parts/footer.php';
$conn->close();
?>
