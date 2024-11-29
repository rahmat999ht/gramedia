<?php

function finishOrder($userId, $cartId, $selectedCartIds, $koneksi, $name, $phone, $address, $city, $state, $zip)
{
    // Mulai transaksi
    if (!$koneksi->begin_transaction()) {
        error_log("Error memulai transaksi: " . $koneksi->error);
        return false;
    }

    try {
        // Periksa apakah user dan cart valid
        $queryCart = "SELECT * FROM cart WHERE id_cart = ? AND id_user = ?";
        $stmtCart = $koneksi->prepare($queryCart);
        if (!$stmtCart) {
            throw new Exception("Gagal mempersiapkan query cart: " . $koneksi->error);
        }

        $stmtCart->bind_param("ii", $cartId, $userId);
        $stmtCart->execute();
        $cartResult = $stmtCart->get_result();

        if ($cartResult->num_rows == 0) {
            throw new Exception("Keranjang tidak ditemukan untuk pengguna ini.");
        }

        // Ambil item keranjang
        $queryCartItems = "SELECT ci.id_item, ci.id_book, ci.quantity, b.price, b.stock 
                           FROM cart_items ci 
                           JOIN books b ON ci.id_book = b.id_book 
                           WHERE ci.id_cart = ?";
        $stmtCartItems = $koneksi->prepare($queryCartItems);
        if (!$stmtCartItems) {
            throw new Exception("Gagal mempersiapkan query item keranjang: " . $koneksi->error);
        }

        $stmtCartItems->bind_param("i", $cartId);
        $stmtCartItems->execute();
        $cartItems = $stmtCartItems->get_result();

        if ($cartItems->num_rows == 0) {
            throw new Exception("Keranjang kosong.");
        }

        // Buat order
        $orderDate = date("Y-m-d H:i:s");
        $queryOrder = "INSERT INTO orders (id_user, order_date) VALUES (?, ?)";
        $stmtOrder = $koneksi->prepare($queryOrder);
        if (!$stmtOrder) {
            throw new Exception("Gagal mempersiapkan query order: " . $koneksi->error);
        }

        $stmtOrder->bind_param("is", $userId, $orderDate);
        if (!$stmtOrder->execute()) {
            throw new Exception("Gagal membuat order: " . $stmtOrder->error);
        }

        $orderId = $koneksi->insert_id;  // Simpan ID order

        // Proses order details dan stok
        $totalAmount = 0;
        $queryOrderDetails = "INSERT INTO order_details (id_order, id_book, quantity, name, phone, address, city, state, zip) 
                              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmtOrderDetails = $koneksi->prepare($queryOrderDetails);
        if (!$stmtOrderDetails) {
            throw new Exception("Gagal mempersiapkan query order details: " . $koneksi->error);
        }

        while ($row = $cartItems->fetch_assoc()) {
            $idBook = $row['id_book'];
            $quantity = $row['quantity'];
            $price = $row['price'];
            $stock = $row['stock'];

            if ($stock < $quantity) {
                throw new Exception("Stok tidak mencukupi untuk buku ID: $idBook");
            }

            $totalAmount += $price * $quantity;
            $stmtOrderDetails->bind_param("iiiisssss", $orderId, $idBook, $quantity, $name, $phone, $address, $city, $state, $zip);
            if (!$stmtOrderDetails->execute()) {
                throw new Exception("Gagal menyimpan detail order untuk buku ID: $idBook");
            }

            // Kurangi stok
            $queryUpdateStock = "UPDATE books SET stock = stock - ? WHERE id_book = ?";
            $stmtUpdateStock = $koneksi->prepare($queryUpdateStock);
            if (!$stmtUpdateStock) {
                throw new Exception("Gagal mempersiapkan query update stok: " . $koneksi->error);
            }

            $stmtUpdateStock->bind_param("ii", $quantity, $idBook);
            if (!$stmtUpdateStock->execute()) {
                throw new Exception("Gagal mengurangi stok buku ID: $idBook");
            }
        }

        // Buat invoice
        $invoiceDate = date("Y-m-d H:i:s");
        $queryInvoice = "INSERT INTO invoices (id_order, invoice_date, total_amount) VALUES (?, ?, ?)";
        $stmtInvoice = $koneksi->prepare($queryInvoice);
        if (!$stmtInvoice) {
            throw new Exception("Gagal mempersiapkan query invoice: " . $koneksi->error);
        }

        $stmtInvoice->bind_param("isd", $orderId, $invoiceDate, $totalAmount);
        if (!$stmtInvoice->execute()) {
            throw new Exception("Gagal membuat invoice.");
        }

        // Hapus item dari keranjang hanya untuk cartItemId yang dipilih
        if (empty($selectedCartIds)) {
            throw new Exception("Tidak ada item yang dipilih untuk dihapus.");
        }

        $queryDeleteCartItem = "DELETE FROM cart_items WHERE id_cart = ? AND id_item = ?";
        $stmtDeleteCartItem = $koneksi->prepare($queryDeleteCartItem);
        if (!$stmtDeleteCartItem) {
            throw new Exception("Gagal mempersiapkan query hapus item keranjang: " . $koneksi->error);
        }

        foreach ($selectedCartIds as $cartItemId) {
            $stmtDeleteCartItem->bind_param("ii", $cartId, $cartItemId);
            if (!$stmtDeleteCartItem->execute()) {
                throw new Exception("Gagal menghapus item keranjang dengan ID cart_item: $cartItemId");
            }
        }

        // Commit transaksi
        if (!$koneksi->commit()) {
            throw new Exception("Gagal melakukan commit transaksi.");
        }

        return $orderId; // Kembalikan order_id
    } catch (Exception $e) {
        $koneksi->rollback();
        error_log("Error: " . $e->getMessage());
        return false;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    session_start();
    require_once("../koneksi.php");

    $cart_id = $_POST['id_cart'];
    $selectedCartIds = isset($_POST['id_cart_item']) ? explode(',', $_POST['id_cart_item']) : [];
    $user_id = $_SESSION['user_id'] ?? null;

    // Ambil data dari form
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $zip = $_POST['zip'];

    if (empty($user_id) || empty($selectedCartIds)) {
        echo '<script>alert("Tidak ada data untuk diproses."); window.history.back();</script>';
        exit;
    }

    $orderId = finishOrder($user_id, $cart_id, $selectedCartIds, $koneksi, $name, $phone, $address, $city, $state, $zip);
    if (!$orderId) {
        echo '<script>alert("Terjadi kesalahan dalam pemesanan."); window.history.back();</script>';
        exit;
    }

    // Redirect ke halaman order_complete.php dengan membawa order_id
    echo '<script>
            alert("Pesanan berhasil!");
            window.location.href = "order_complete.php?order_id=' . $orderId . '";
          </script>';
}
