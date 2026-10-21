
<?php include __DIR__ . '/parts/header.php'; ?>

<section class="checkout">

    <h2>Checkout</h2>

    <p>
        Complete your information below to
        continue your GEMWHIZ shopping experience.
    </p>

    <form action="confirmation.php" method="get">

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

            <p>Carnelian Copper Pendant (Sample)</p>
            <p>Subtotal: Coming Soon</p>
            <p>Shipping: Coming Soon</p>
            <p>Total: Coming Soon</p>
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

</section>

<?php include __DIR__ . '/parts/footer.php'; ?>
