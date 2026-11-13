<?php
  // Configuração da BD: variáveis de ambiente (ex.: Docker) têm prioridade;
  // caso contrário, lê o ficheiro .env (na mesma pasta)
  $env = [];
  $envFile = __DIR__ . '/.env';
  if (is_readable($envFile)) {
    foreach (file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $linha) {
      $linha = trim($linha);
      if ($linha === '' || $linha[0] === '#' || strpos($linha, '=') === false) {
        continue;
      }
      list($chave, $valor) = explode('=', $linha, 2);
      $env[trim($chave)] = trim(trim($valor), "\"'");
    }
  }
  foreach (['DB_HOST', 'DB_USER', 'DB_PASS', 'DB_NAME'] as $chave) {
    if (getenv($chave) !== false) {
      $env[$chave] = getenv($chave);
    }
  }
  if (!isset($env['DB_NAME'])) {
    die("Configuração da BD em falta. Copia o .env.example para .env e preenche os dados da BD.");
  }

  $servername = $env['DB_HOST'] ?? 'localhost';
  $username = $env['DB_USER'] ?? 'root';
  $password = $env['DB_PASS'] ?? '';
  $dbname = $env['DB_NAME'];
  // Cria a ligação à BD
  $conn = new mysqli($servername, $username, $password, $dbname);
  // Verifica a ligação à BD
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }
  //echo "Conexão efectuada<br>";
?>
