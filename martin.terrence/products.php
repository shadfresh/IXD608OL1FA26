
<?php
// GEMWHIZ - Product List
// Connect to the private MySQL database configuration.

require_once dirname(__DIR__, 3) . '/private_config/database.php';

// Retrieve all products from the database.
$sql = "SELECT * FROM products ORDER BY id ASC";
$result = $conn->query($sql);

// Include the website header.
include __DIR__ . '/parts/header.php';
?>

<section class="shop-intro">
    <h2>Shop GEMWHIZ</h2>
    <p>
        Explore handcrafted gemstone jewelry inspired
        by nature, creativity, and magic.
    </p>
</section>

<section class="product-collection">
    <h2>Fall Alchemy Collection</h2>

    <div class="product-grid">

        <?php if ($result && $result->num_rows > 0): ?>

            <?php while ($product = $result->fetch_assoc()): ?>

                <article class="product-card">

                    <div class="product-image">
                        <p>Professional Photo Coming Soon</p>
                    </div>

                    <h3>
                        <?php echo htmlspecialchars($product['name']); ?>
                    </h3>

                    <p class="product-description">
                        <?php echo htmlspecialchars($product['description']); ?>
                    </p>

                    <p class="product-price">
                        $<?php echo number_format((float)$product['price'], 2); ?>
                    </p>

                    <a
                        href="product.php?id=<?php echo (int)$product['id']; ?>"
                        class="button"
                    >
                        View Product
                    </a>

                </article>

            <?php endwhile; ?>

        <?php else: ?>

            <p>No products available at this time.</p>

        <?php endif; ?>

    </div>
</section>

<?php
include __DIR__ . '/parts/footer.php';
$conn->close();
?>
