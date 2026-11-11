
<?php
// GEMWHIZ - Individual Product Detail

require_once dirname(__DIR__, 3) . '/private_config/database.php';

// Get the product ID from the URL.
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

$product = null;

if ($id && $id > 0) {
    $stmt = $conn->prepare(
        "SELECT id, name, description, price, category, quantity
         FROM products
         WHERE id = ?"
    );

    $stmt->bind_param("i", $id);
    $stmt->execute();

    $result = $stmt->get_result();
    $product = $result->fetch_assoc();

    $stmt->close();
}

include __DIR__ . '/parts/header.php';
?>

<section class="product-detail">

    <?php if ($product): ?>

        <p>
            <a href="products.php">← Back to Shop</a>
        </p>

        <div class="product-detail-container">

            <div class="product-image">
                <p>Professional Photo Coming Soon</p>
            </div>

            <div class="product-info">

                <h1>
                    <?= htmlspecialchars($product['name']) ?>
                </h1>

                <p class="product-price">
                    $<?= number_format((float)$product['price'], 2) ?>
                </p>

                <p>
                    <?= htmlspecialchars($product['description']) ?>
                </p>

                <p>
                    <strong>Category:</strong>
                    <?= htmlspecialchars($product['category']) ?>
                </p>

                <p>
                    <strong>Availability:</strong>
                    <?= (int)$product['quantity'] > 0
                        ? 'In Stock'
                        : 'Out of Stock' ?>
                </p>

                <?php if ((int)$product['quantity'] > 0): ?>

                    <form action="cart.php" method="POST">

                        <input
                            type="hidden"
                            name="product_id"
                            value="<?= (int)$product['id'] ?>"
                        >

                        <label for="quantity">Quantity:</label>

                        <input
                            type="number"
                            id="quantity"
                            name="quantity"
                            value="1"
                            min="1"
                            max="<?= (int)$product['quantity'] ?>"
                            required
                        >

                        <button type="submit" class="button">
                            Add to Cart
                        </button>

                    </form>

                <?php else: ?>

                    <p>This item is currently unavailable.</p>

                <?php endif; ?>

            </div>

        </div>

    <?php else: ?>

        <h1>Product Not Found</h1>

        <p>
            Sorry, we couldn't find that gemstone.
        </p>

        <a href="products.php" class="button">
            Return to Shop
        </a>

    <?php endif; ?>

</section>

<?php
include __DIR__ . '/parts/footer.php';
$conn->close();
?>
