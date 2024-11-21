<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">
        <!-- Dashboard Menu -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="index.php">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li>
        <!-- End Dashboard Nav -->

        <!-- Buku Menu (Hanya untuk Admin) -->
        <?php if ($_SESSION['admin_role'] == 'admin' || $_SESSION['admin_role'] == 'atasan'): ?>
            <li class="nav-item">
                <a class="nav-link collapsed" href="tables-buku.php">
                    <i class="bi bi-book"></i>
                    <span>Buku</span>
                </a>
            </li>
        <?php endif; ?>
        <!-- End Buku Nav -->

        <!-- Kategori Menu (Hanya untuk Admin) -->
        <?php if ($_SESSION['admin_role'] == 'admin'): ?>
            <li class="nav-item">
                <a class="nav-link collapsed" href="tables-kategori.php">
                    <i class="bi bi-tags"></i>
                    <span>Kategori</span>
                </a>
            </li>
        <?php endif; ?>
        <!-- End Kategori Nav -->

        <!-- Pesanan Menu -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="tables-pesanan.php">
                <i class="bi bi-cart"></i>
                <span>Pesanan</span>
            </a>
        </li>
        <!-- End Pesanan Nav -->

        <!-- Transaksi Menu (Hanya untuk Atasan dan Kasir) -->
        <?php if ($_SESSION['admin_role'] == 'kasir' || $_SESSION['admin_role'] == 'atasan'): ?>
            <li class="nav-item">
                <a class="nav-link collapsed" href="tables-transaksi.php">
                    <i class="bi bi-credit-card"></i>
                    <span>Transaksi</span>
                </a>
            </li>
        <?php endif; ?>
        <!-- End Transaksi Nav -->

        <!-- Pengguna Menu -->
        <?php if ($_SESSION['admin_role'] == 'admin'): ?>
            <li class="nav-item">
                <a class="nav-link collapsed" href="tables-pengguna.php">
                    <i class="bi bi-person-circle"></i>
                    <span>Pengguna</span>
                </a>
            </li>
        <?php endif; ?>

        <!-- End Pengguna Nav -->
    </ul>
</aside>
<!-- End Sidebar -->