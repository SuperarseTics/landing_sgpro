<?php
// ==========================================================
// Script de reseteo de contraseñas - landing_sgpro
// Autor: ChatGPT (adaptado para Instituto Superarse)
// ==========================================================

// CONFIGURACIÓN DE CONEXIÓN
$host = 'localhost';
$user = 'root';
$pass = 'Superarse.2025'; // Ajusta según tu servidor local
$db   = 'landing_sgpro';

// CONECTAR A LA BASE DE DATOS
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// ==========================================================
// FORMULARIO SIMPLE
// ==========================================================
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
?>
    <form method="POST" style="max-width:400px;margin:40px auto;font-family:sans-serif;">
        <h3>🔐 Restablecer contraseña de usuario</h3>
        <label>Correo del usuario:</label><br>
        <input type="email" name="email" required style="width:100%;padding:8px;"><br><br>

        <label>Nueva contraseña:</label><br>
        <input type="text" name="new_password" required style="width:100%;padding:8px;"><br><br>

        <button type="submit" style="padding:10px 20px;">Actualizar</button>
    </form>
<?php
    exit;
}

// ==========================================================
// PROCESAR CAMBIO DE CONTRASEÑA
// ==========================================================
$email = trim($_POST['email']);
$new_password = trim($_POST['new_password']);

// Verificar que el usuario exista
$sql = "SELECT id FROM users WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("❌ No se encontró un usuario con ese correo.");
}

// Generar nuevo hash
$hash = password_hash($new_password, PASSWORD_BCRYPT);

// Actualizar contraseña
$update = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
$update->bind_param("ss", $hash, $email);
if ($update->execute()) {
    echo "✅ Contraseña actualizada correctamente para: <b>$email</b><br>";
    echo "➡️ Nueva contraseña: <b>$new_password</b>";
} else {
    echo "❌ Error al actualizar la contraseña.";
}

$conn->close();
?>
