
<?php
// GEMWHIZ - Shopping Cart

session_start();

require_once dirname(__DIR__, 3) . '/private_config/database.php';

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Add a product to the cart.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $product_id = filter_input(
        INPUT_POST,
        'product_id',
        FILTER_VALIDATE_INT
    );

    $quantity = filter_input(
        INPUT_POST,
        'quantity',
        FILTER_VALIDATE_INT
    );

    if (isset($_POST['remove_id'])) {
        $remove_id = filter_input(
            INPUT_POST,
            'remove_id',
            FILTER_VALIDATE_INT
        );

        if ($remove_id) {
            unset($_SESSION['cart'][$remove_id]);
        }

    } elseif ($product_id && $quantity && $quantity > 0) {

        // Check that the product exists and is in stock.
        $stmt = $conn->prepare(
            "SELECT quantity FROM products WHERE id = ?"
        );

        $stmt->bind_param("i", $product_id);
        $stmt->execute();

        $result = $stmt->get_result();
        $product = $result->fetch_assoc();
        $stmt->close();

        if ($product && (int)$product['quantity'] > 0) {
            $current = $_SESSION['cart'][$product_id] ?? 0;

            $_SESSION['cart'][$product_id] = min(
                $current + $quantity,
                (int)$product['quantity']
            );
        }
    }

    // Prevent form resubmission on refresh.
    header("Location: cart.php");
    exit;
}

// Retrieve cart products from the database.
$cart_items = [];
$total = 0;

foreach ($_SESSION['cart'] as $id => $quantity) {

    $id = (int)$id;

    $stmt = $conn->prepare(
        "SELECT id, name, price, quantity
         FROM products WHERE id = ?"
    );

    $stmt->bind_param("i", $id);
    $stmt->execute();

    $result = $stmt->get_result();
    $product = $result->fetch_assoc();
    $stmt->close();

    if (!$product || (int)$product['quantity'] <= 0) {
        unset($_SESSION['cart'][$id]);
        continue;
    }

    $quantity = min(
        (int)$quantity,
        (int)$product['quantity']
    );

    $_SESSION['cart'][$id] = $quantity;

    $subtotal = (float)$product['price'] * $quantity;
    $total += $subtotal;

    $product['cart_quantity'] = $quantity;
    $product['subtotal'] = $subtotal;

    $cart_items[] = $product;
}

include __DIR__ . '/parts/header.php';
?>

<section class="cart-page">

    <h1>Your Shopping Cart</h1>

    <?php if (empty($cart_items)): ?>

        <p>Your cart is currently empty.</p>

        <a href="products.php" class="button">
            Continue Shopping
        </a>

    <?php else: ?>

        <div class="cart-items">

            <?php foreach ($cart_items as $item): ?>

                <article class="cart-item">

                    <h2>
                        <?= htmlspecialchars($item['name']) ?>
                    </h2>

                    <p>
                        Price:
                        $<?= number_format((float)$item['price'], 2) ?>
                    </p>

                    <p>
                        Quantity:
                        <?= (int)$item['cart_quantity'] ?>
                    </p>

                    <p>
                        Subtotal:
                        $<?= number_format($item['subtotal'], 2) ?>
                    </p>

                    <form action="cart.php" method="POST">

                        <input
                            type="hidden"
                            name="remove_id"
                            value="<?= (int)$item['id'] ?>"
                        >

                        <button type="submit" class="button">
                            Remove Item
                        </button>

                    </form>

                </article>

            <?php endforeach; ?>

        </div>

        <div class="cart-summary">

            <h2>
                Total: $<?= number_format($total, 2) ?>
            </h2>

            <p>
                Shipping and taxes are not included.
            </p>

            <a href="products.php" class="button">
                Continue Shopping
            </a>

        </div>

    <?php endif; ?>

</section>

<?php
include __DIR__ . '/parts/footer.php';
$conn->close();
?>
