<?php
require_once 'database.php';
header('Content-Type: application/json');

if (isset($_GET['username'])) {
    $username = trim($_GET['username']);

    try {
        $connessione = new PDO("mysql:host=$host;dbname=$db", $user, $password);
        $connessione->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Conta quante volte compare questo username nella tabella credenziali
        $sql = "SELECT COUNT(*) FROM credenziali WHERE username = ?";
        $stmt = $connessione->prepare($sql);
        $stmt->execute([$username]);
        $count = $stmt->fetchColumn();

        // Se count è 0, è disponibile (true), altrimenti è occupato (false)
        echo json_encode(['available' => $count == 0]);

    } catch (PDOException $e) {
        echo json_encode(['error' => 'Database error']);
    }
} else {
    echo json_encode(['error' => 'Nessun username fornito']);
}
?>