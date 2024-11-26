<!-- Header -->
<header id="header">
    <div class="inner">
        <!-- Logo -->
        <a href="index.php" class="logo">
            <span class="fa fa-book"></span> <span class="title">Gramedia</span>
        </a>

        <!-- Nav -->
        <nav>
            <ul>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <!-- Cek jika session user_id ada -->
                    <li class="pe-3">
                        <a href="#" class="akun">
                            <h3>Welcome,</h3>
                            <h3>
                                <?php echo htmlspecialchars($_SESSION['user_username']); ?>
                            </h3>
                            <!-- Tampilkan username -->
                        </a>
                    </li>
                <?php else: ?>
                    <!-- Jika belum login -->
                    <li>
                        <a
                            href="#"
                            class="akun"
                            data-toggle="modal"
                            data-target="#registerModal"
                            data-whatever="@getbootstrap">
                            <h3>Register</h3>
                        </a>
                    </li>
                    <li>
                        <a
                            href="#"
                            class="akun"
                            data-toggle="modal"
                            data-target="#loginModal"
                            data-whatever="@getbootstrap">
                            <h3>Login</h3>
                        </a>
                    </li>
                <?php endif; ?>
                <li><a href="#menu">Menu</a></li>
            </ul>
        </nav>
    </div>
</header>