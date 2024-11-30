<?php
session_start();
require_once("../koneksi.php"); // Menghubungkan ke database
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require '../vendor/autoload.php';

function register($email, $username, $password, $confirmPassword)
{
    global $koneksi;

    // Validasi password
    if ($password !== $confirmPassword) {
        echo '<script>alert("Password tidak sama."); window.location.href="../index.php";</script>';
        return;
    }

    $hashedPassword = md5($password);

    // Cek apakah username atau email sudah terdaftar
    $query = "SELECT * FROM users WHERE username = ? OR email = ?";
    $stmt = mysqli_prepare($koneksi, $query);
    mysqli_stmt_bind_param($stmt, "ss", $username, $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        echo '<script>alert("Username atau email sudah terdaftar."); window.location.href="../index.php";</script>';
        return;
    }

    // Generate verification token
    $verificationToken = bin2hex(random_bytes(32));

    // Konfigurasi PHPMailer
    $mail = new PHPMailer(true);
    try {
        // Server settings
        $mail->SMTPDebug = SMTP::DEBUG_OFF;
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'rahmat999ht@gmail.com'; // SMTP username
        $mail->Password   = 'hpdhamsiwkgygdey'; // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port       = 465;

        // Recipients
        $mail->setFrom('gramedia@gmail.com', 'Verifikasi');
        $mail->addAddress($email, $username);

        // Isi email
        $mail->isHTML(true);
        $mail->Subject = 'Email Verification Gramedia';
        $verificationLink = "http://localhost:8000/function/verify_email.php?token=" . $verificationToken;
        $mail->Body = "Hi $username, please verify your email by clicking the link: <a href='$verificationLink'>$verificationLink</a>";

        // Kirim email
        if ($mail->send()) {
            // Jika email berhasil dikirim, simpan data ke database
            $insertQuery = "INSERT INTO users (username, password, email, verification_token, email_verified) VALUES (?, ?, ?, ?, 0)";
            $insertStmt = mysqli_prepare($koneksi, $insertQuery);
            mysqli_stmt_bind_param($insertStmt, "ssss", $username, $hashedPassword, $email, $verificationToken);

            if (mysqli_stmt_execute($insertStmt)) {
                echo '<script>alert("Registration successful! Please check your email for verification."); window.location.href="../index.php";</script>';
                exit();
            } else {
                echo '<script>alert("Terjadi kesalahan saat menyimpan data: ' . mysqli_error($koneksi) . '"); window.location.href="../index.php";</script>';
                return;
            }
        } else {
            echo '<script>alert("Failed to send verification email."); window.location.href="../index.php";</script>';
        }
    } catch (Exception $e) {
        echo '<script>alert("Mailer Error: ' . $mail->ErrorInfo . '"); window.location.href="../index.php";</script>';
    }
}

// Penggunaan fungsi register
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    register($email, $username, $password, $confirmPassword);
}
?>
