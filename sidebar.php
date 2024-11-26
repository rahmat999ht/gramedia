<!-- Menu -->
<nav id="menu">
    <h2>Menu</h2>
    <ul>
        <li><a href="index.php" class="active">Home</a></li>

        <li><a href="products.php">Products</a></li>

        <?php if (isset($_SESSION['user_id'])): ?>
            <li><a href="checkout.php">Checkout</a></li>
        <?php endif; ?>

        <li><a href="about.php">About Us</a></li>

        <!-- <li><a href="contact.php">Contact Us</a></li> -->
        <?php if (isset($_SESSION['user_id'])): ?>
            <li><a href="logout_user.php">Log-Out</a></li>
        <?php endif; ?>
    </ul>
</nav>