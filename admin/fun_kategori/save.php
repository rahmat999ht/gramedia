<?php

session_start(); // Mulai session
require_once("../../koneksi.php");
error_reporting(0);

function addCategory($connection, $categoryName)
{
    $query = "INSERT INTO categories (name) VALUES (?)";
    $stmt = mysqli_prepare($connection, $query);
    if (!$stmt) {
        echo "<script>alert('Prepare statement failed: " . mysqli_error($connection) . "');</script>";
        return false;
    }

    mysqli_stmt_bind_param($stmt, "s", $categoryName);

    if (mysqli_stmt_execute($stmt)) {
        return true; // Data berhasil ditambahkan
    } else {
        echo "<script>alert('Error: " . mysqli_stmt_error($stmt) . "');</script>";
        return false; // Gagal menambahkan data
    }

    mysqli_stmt_close($stmt);
}

function updateCategory($connection, $categoryId, $categoryName)
{
    $query = "UPDATE categories SET name = ? WHERE id_category = ?";
    $stmt = mysqli_prepare($connection, $query);
    if (!$stmt) {
        echo "<script>alert('Prepare statement failed: " . mysqli_error($connection) . "');</script>";
        return false;
    }

    mysqli_stmt_bind_param($stmt, "si", $categoryName, $categoryId);

    if (mysqli_stmt_execute($stmt)) {
        return true; // Data berhasil diperbarui
    } else {
        echo "<script>alert('Error: " . mysqli_stmt_error($stmt) . "');</script>";
        return false; // Gagal memperbarui data
    }

    mysqli_stmt_close($stmt);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $categoryId = $_POST['id'] ?? null;
    $categoryName = $_POST['category_name'] ?? null;

    if (empty($categoryName)) {
        echo "<script>alert('Category name is required!'); window.history.back();</script>";
        exit;
    }

    if (empty($categoryId)) {
        // Menambahkan kategori baru
        $isAdded = addCategory($koneksi, $categoryName);
        if ($isAdded) {
            echo "<script>alert('Category added successfully!'); window.location.href = '../tables-kategori.php';</script>";
            exit;
        } else {
            echo "<script>alert('Failed to add category.'); window.history.back();</script>";
        }
    } else {
        // Memperbarui kategori
        $query = "SELECT * FROM categories WHERE id_category = ?";
        $stmt = mysqli_prepare($koneksi, $query);
        mysqli_stmt_bind_param($stmt, "i", $categoryId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if (mysqli_num_rows($result) > 0) {
            // Kategori ditemukan, lakukan update
            $isUpdated = updateCategory($koneksi, $categoryId, $categoryName);
            if ($isUpdated) {
                echo "<script>alert('Category updated successfully!'); window.location.href = '../tables-kategori.php';</script>";
                exit;
            } else {
                echo "<script>alert('Failed to update category.'); window.history.back();</script>";
            }
        } else {
            echo "<script>alert('Category not found!'); window.history.back();</script>";
        }
    }
}
?>
