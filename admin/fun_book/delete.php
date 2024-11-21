<?php

session_start(); // Mulai session
require_once("../../koneksi.php");
error_reporting(0);

function deleteBook($koneksi, $bookId)
{
    // Cek koneksi database
    if (!$koneksi) {
        die(json_encode(['success' => false, 'message' => 'Database connection failed.']));
    }

    // Ambil nama file gambar sebelum data dihapus
    $queryGetImage = "SELECT image FROM books WHERE id_book = ?";
    $stmtGetImage = mysqli_prepare($koneksi, $queryGetImage);
    if (!$stmtGetImage) {
        die("Prepare statement failed: " . mysqli_error($koneksi));
    }

    mysqli_stmt_bind_param($stmtGetImage, "i", $bookId);
    mysqli_stmt_execute($stmtGetImage);
    mysqli_stmt_bind_result($stmtGetImage, $image);
    mysqli_stmt_fetch($stmtGetImage);
    mysqli_stmt_close($stmtGetImage);

    // Hapus file gambar jika ada
    $uploadDir = '../../images/'; // Folder tempat menyimpan gambar
    $imagePath = $uploadDir . $image;
    if ($image && file_exists($imagePath)) {
        unlink($imagePath); // Hapus file gambar
    }

    // Query untuk menghapus buku berdasarkan ID
    $queryDelete = "DELETE FROM books WHERE id_book = ?";
    $stmtDelete = mysqli_prepare($koneksi, $queryDelete);
    if (!$stmtDelete) {
        die("Prepare statement failed: " . mysqli_error($koneksi));
    }

    // Bind parameter ID ke statement
    mysqli_stmt_bind_param($stmtDelete, "i", $bookId);

    // Eksekusi statement
    if (mysqli_stmt_execute($stmtDelete)) {
        mysqli_stmt_close($stmtDelete);
        return true; // Data berhasil dihapus
    } else {
        echo "Error: " . mysqli_stmt_error($stmtDelete);
        mysqli_stmt_close($stmtDelete);
        return false; // Gagal menghapus data
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true); // Dekode data JSON

    if (isset($data['action']) && $data['action'] === 'delete') {
        $bookId = $data['id'] ?? null; // Ambil ID buku dari request

        if ($bookId) {
            $isDeleted = deleteBook($koneksi, $bookId);

            if ($isDeleted) {
                echo json_encode(['success' => true, 'message' => 'Book and its image deleted successfully!']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to delete book and its image.']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid book ID.']);
        }
        exit;
    }
}
