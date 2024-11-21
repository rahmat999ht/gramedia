<?php
require_once("../../koneksi.php");
header('Content-Type: application/json');

// Cek apakah request POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data JSON
    $data = json_decode(file_get_contents('php://input'), true);

    if ($data['action'] === 'delete') {
        $categoryId = intval($data['id']); // Pastikan ID yang diterima adalah integer untuk keamanan

        // Query untuk menghapus kategori berdasarkan ID
        $query = "DELETE FROM categories WHERE id_category = $categoryId";

        if (mysqli_query($koneksi, $query)) {
            echo json_encode([
                'success' => true,
                'message' => 'Kategori berhasil dihapus.'  // Message using alert
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menghapus kategori.'  // Message using alert
            ]);
        }
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Request tidak valid.'  // Message using alert
        ]);
    }
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Metode request tidak valid.'  // Message using alert
    ]);
}
?>
