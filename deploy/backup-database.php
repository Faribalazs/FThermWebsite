<?php

// CLI only. Credentials remain in a private temporary file on the server.
if (PHP_SAPI !== 'cli' || $argc !== 3) {
    exit(1);
}

require $argv[1].'/vendor/autoload.php';
$app = require $argv[1].'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
$config = $app->make('db')->connection()->getConfig();
if (! in_array($config['driver'], ['mysql', 'mariadb'], true)) {
    fwrite(STDERR, "Automatic backup requires MySQL/MariaDB.\n");
    exit(1);
}

$escape = static fn ($value) => '"'.str_replace(
    ["\\", '"', "\n", "\r"],
    ["\\\\", '\\"', '\\n', '\\r'],
    (string) $value
).'"';

$oldMask = umask(0077);
$defaults = tempnam(dirname($argv[2]), '.mysql-');
if ($defaults === false) {
    throw new RuntimeException('Cannot create database backup configuration.');
}
try {
    $options = [
        'user' => $config['username'],
        'password' => $config['password'],
        'host' => $config['host'] ?? 'localhost',
        'port' => $config['port'] ?? 3306,
    ];
    if (! empty($config['unix_socket'])) {
        $options['socket'] = $config['unix_socket'];
    }
    $text = "[client]\n";
    foreach ($options as $key => $value) {
        $text .= $key.'='.$escape($value)."\n";
    }
    if (file_put_contents($defaults, $text) === false) {
        throw new RuntimeException('Cannot write database backup configuration.');
    }
    $process = new Symfony\Component\Process\Process([
        'mysqldump', '--defaults-extra-file='.$defaults,
        '--single-transaction', '--quick', '--skip-lock-tables',
        '--no-tablespaces', '--hex-blob', '--default-character-set=utf8mb4',
        '--result-file='.$argv[2], '--', $config['database'],
    ]);
    $process->setTimeout(300);
    $process->mustRun();
    if (! is_file($argv[2]) || filesize($argv[2]) === 0) {
        throw new RuntimeException('Database backup is empty.');
    }
    chmod($argv[2], 0600);
    echo "Database backup completed.\n";
} finally {
    unlink($defaults);
    umask($oldMask);
}
