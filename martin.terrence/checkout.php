
<?php
// GEMWHIZ - Demo Checkout

session_start();

require_once dirname(__DIR__, 3) . '/private_config/database.php';

// Make sure the cart exists.
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Get products from the shopping cart.
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

    $cart_items[] = $product;
}

include __DIR__ . '/parts/header.php';
?>

<section class="checkout">

    <h2>Checkout</h2>

    <?php if (empty($cart_items)): ?>

        <p>Your shopping cart is empty.</p>

        <a href="products.php" class="button">
            Continue Shopping
        </a>

    <?php else: ?>

        <p>
            Complete your information below to
            continue your GEMWHIZ shopping experience.
        </p>

        <form action="confirmation.php" method="POST">

            <fieldset>
                <legend>Customer Information</legend>

                <label for="fullname">Full Name</label>
                <input
                    type="text"
                    id="fullname"
                    name="fullname"
                    required
                >

                <label for="email">Email Address</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    required
                >
            </fieldset>

            <fieldset>
                <legend>Shipping Information</legend>

                <label for="address">Street Address</label>
                <input
                    type="text"
                    id="address"
                    name="address"
                    required
                >

                <label for="city">City</label>
                <input
                    type="text"
                    id="city"
                    name="city"
                    required
                >

                <label for="state">State</label>
                <input
                    type="text"
                    id="state"
                    name="state"
                    required
                >

                <label for="zipcode">ZIP Code</label>
                <input
                    type="text"
                    id="zipcode"
                    name="zipcode"
                    required
                >
            </fieldset>

            <div class="checkout-summary">

                <h3>Order Summary</h3>

                <?php foreach ($cart_items as $item): ?>

                    <p>
                        <?= htmlspecialchars($item['name']) ?>
                        —
                        Quantity:
                        <?= (int)$item['cart_quantity'] ?>
                        —
                        $<?= number_format(
                            $item['subtotal'],
                            2
                        ) ?>
                    </p>

                <?php endforeach; ?>

                <p>
                    Subtotal:
                    $<?= number_format($total, 2) ?>
                </p>

                <p>
                    Shipping: Not calculated
                </p>

                <p>
                    <strong>
                        Demo Total:
                        $<?= number_format($total, 2) ?>
                    </strong>
                </p>

            </div>

            <p>
                This is a demonstration checkout.
                No payment or real order will be processed.
                Please use fictional information only.
            </p>

            <button type="submit" class="button">
                View Demo Confirmation
            </button>

        </form>

        <p>
            <a href="cart.php">Back to Cart</a>
        </p>

    <?php endif; ?>

</section>

<?php
include __DIR__ . '/parts/footer.php';
$conn->close();
?>
