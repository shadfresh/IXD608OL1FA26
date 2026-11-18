
<?php
// GEMWHIZ — Product Collection
// Connect to the existing MySQL database.
require_once dirname(__DIR__, 3) . '/private_config/database.php';

// Retrieve all products.
$sql = "SELECT * FROM products ORDER BY id ASC";
$result = $conn->query($sql);

// Load the website header.
include __DIR__ . '/parts/header.php';
?>

<section class="shop-intro">
    <h2>Shop GEMWHIZ</h2>
    <p>
        Explore handcrafted gemstone jewelry inspired by
        nature, creativity, and magic.
    </p>
</section>

<section class="product-collection">
    <h2>Fall Alchemy Collection</h2>

    <div class="product-grid">

        <?php if ($result && $result->num_rows > 0): ?>

            <?php while ($product = $result->fetch_assoc()): ?>

                <article class="product-card">

                    <div class="product-image">
                        <?php if (!empty($product['image'])): ?>

                            <img
                                src="img/<?= rawurlencode(basename($product['image'])) ?>"
                                alt="<?= htmlspecialchars($product['name'], ENT_QUOTES, 'UTF-8') ?>"
                                loading="lazy"
                                style="width:100%; height:240px; object-fit:contain;"
                            >

                        <?php else: ?>

                            <p>Photo Coming Soon</p>

                        <?php endif; ?>
                    </div>

                    <h3>
                        <?= htmlspecialchars($product['name'], ENT_QUOTES, 'UTF-8') ?>
                    </h3>

                    <p>
                        <?= htmlspecialchars($product['description'], ENT_QUOTES, 'UTF-8') ?>
                    </p>

                    <p class="product-price">
                        $<?= number_format((float)$product['price'], 2) ?>
                    </p>

                    <a
                        href="product.php?id=<?= (int)$product['id'] ?>"
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
// Load the website footer.
include __DIR__ . '/parts/footer.php';

// Close the database connection.
$conn->close();
?>

