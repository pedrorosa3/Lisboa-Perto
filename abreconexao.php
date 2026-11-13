<?php
  // Lê as variáveis de ambiente do ficheiro .env (na mesma pasta)
  $envFile = __DIR__ . '/.env';
  if (!is_readable($envFile)) {
    die("Ficheiro .env não encontrado. Copia o .env.example para .env e preenche os dados da BD.");
  }
  $env = [];
  foreach (file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $linha) {
    $linha = trim($linha);
    if ($linha === '' || $linha[0] === '#' || strpos($linha, '=') === false) {
      continue;
    }
    list($chave, $valor) = explode('=', $linha, 2);
    $env[trim($chave)] = trim(trim($valor), "\"'");
  }

  $servername = $env['DB_HOST'] ?? 'localhost';
  $username = $env['DB_USER'] ?? 'root';
  $password = $env['DB_PASS'] ?? '';
  $dbname = $env['DB_NAME'] ?? '';
  // Cria a ligação à BD
  $conn = new mysqli($servername, $username, $password, $dbname);
  // Verifica a ligação à BD
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }
  //echo "Conexão efectuada<br>";
?>
