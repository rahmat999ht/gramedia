<?php

session_start(); // Mulai session
require_once("../../koneksi.php");
error_reporting(0);

function addBook($connection, $image, $title, $author, $price, $stock, $id_category)
{
    $query = "INSERT INTO books (image, title, author, price, stock, id_category) 
              VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($connection, $query);
    if (!$stmt) {
        echo "<script>alert('Prepare statement failed: " . mysqli_error($connection) . "');</script>";
        return false;
    }

    mysqli_stmt_bind_param($stmt, "sssdis", $image, $title, $author, $price, $stock, $id_category);

    if (mysqli_stmt_execute($stmt)) {
        return true; // Data berhasil ditambahkan
    } else {
        echo "<script>alert('Error: " . mysqli_stmt_error($stmt) . "');</script>";
        return false; // Gagal menambahkan data
    }

    mysqli_stmt_close($stmt);
}

function updateBook($connection, $bookId, $image, $title, $author, $price, $stock, $id_category, $oldImagePath = null)
{
    if ($image && $oldImagePath && file_exists($oldImagePath)) {
        unlink($oldImagePath); // Hapus file gambar lama
    }

    $query = "UPDATE books 
              SET title = ?, author = ?, price = ?, stock = ?, id_category = ?";

    if ($image) {
        $query .= ", image = ?";
    }

    $query .= " WHERE id_book = ?";
    $stmt = mysqli_prepare($connection, $query);
    if (!$stmt) {
        echo "<script>alert('Prepare statement failed: " . mysqli_error($connection) . "');</script>";
        return false;
    }

    if ($image) {
        mysqli_stmt_bind_param($stmt, "ssdissi", $title, $author, $price, $stock, $id_category, $image, $bookId);
    } else {
        mysqli_stmt_bind_param($stmt, "ssdisi", $title, $author, $price, $stock, $id_category, $bookId);
    }

    if (mysqli_stmt_execute($stmt)) {
        return true; // Data berhasil diperbarui
    } else {
        echo "<script>alert('Error: " . mysqli_stmt_error($stmt) . "');</script>";
        return false; // Gagal memperbarui data
    }

    mysqli_stmt_close($stmt);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bookId = $_POST['id'] ?? null;
    $title = $_POST['title'] ?? null;
    $author = $_POST['author'] ?? null;
    $price = $_POST['price'] ?? null;
    $stock = $_POST['stock'] ?? null;
    $id_category = $_POST['id_category'] ?? null;

    if (empty($title) || empty($author) || empty($price) || empty($stock) || empty($id_category)) {
        echo "<script>alert('ukuran file terlalu besar'); window.history.back();</script>";
        exit;
    }

    $uploadDir = '../../images/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    $image = null;
    if (!empty($_FILES['image']['tmp_name']) && is_uploaded_file($_FILES['image']['tmp_name'])) {
        $fileType = mime_content_type($_FILES['image']['tmp_name']);
        $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];

        if (in_array($fileType, $allowedTypes)) {
            $imageName = uniqid() . '-' . basename($_FILES['image']['name']);
            $imagePath = $uploadDir . $imageName;

            if (move_uploaded_file($_FILES['image']['tmp_name'], $imagePath)) {
                $image = $imageName;
            } else {
                echo "<script>alert('Failed to upload the image.'); window.history.back();</script>";
                exit;
            }
        } else {
            echo "<script>alert('Invalid file type. Only JPG, PNG, and GIF are allowed.'); window.history.back();</script>";
            exit;
        }
    }

    if (empty($bookId)) {
        $isAdded = addBook($koneksi, $image, $title, $author, $price, $stock, $id_category);
        if ($isAdded) {
            echo "<script>alert('Book added successfully!'); window.location.href = '../tables-buku.php';</script>";
            exit;
        } else {
            echo "<script>alert('Failed to add book.'); window.history.back();</script>";
        }
    } else {
        $query = "SELECT image FROM books WHERE id_book = ?";
        $stmt = mysqli_prepare($koneksi, $query);
        mysqli_stmt_bind_param($stmt, "i", $bookId);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $oldImage);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);

        $oldImagePath = $uploadDir . $oldImage;

        $isUpdated = updateBook($koneksi, $bookId, $image, $title, $author, $price, $stock, $id_category, $oldImagePath);
        if ($isUpdated) {
            echo "<script>alert('Book updated successfully!'); window.location.href = '../tables-buku.php';</script>";
            exit;
        } else {
            echo "<script>alert('Failed to update book.'); window.history.back();</script>";
        }
    }
}
