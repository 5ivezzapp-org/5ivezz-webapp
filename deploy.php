<?php
// deploy.php - Place this in your project root

$ftpHost = '82.198.229.254';
$ftpUser = 'u369478809';
$ftpPass = 'your-password-here';
$remotePath = '/public_html/';

// Create a zip of your project (excluding unnecessary files)
$zip = new ZipArchive();
$zipFile = 'deploy.zip';
if ($zip->open($zipFile, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== TRUE) {
    die("Failed to create zip file\n");
}

// Files and folders to exclude
$exclude = [
    '.git', '.github', 'node_modules', 'tests', 'storage/logs', 
    '.env', '.gitignore', 'composer.json', 'composer.lock', 
    'package.json', 'package-lock.json', 'phpunit.xml', 
    'README.md', 'deploy.php', 'deploy.zip'
];

// Add files to zip
$files = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator(__DIR__),
    RecursiveIteratorIterator::LEAVES_ONLY
);

foreach ($files as $file) {
    if ($file->isDir()) continue;
    
    $filePath = $file->getRealPath();
    $relativePath = substr($filePath, strlen(__DIR__) + 1);
    
    // Check if file should be excluded
    $excludeFile = false;
    foreach ($exclude as $ex) {
        if (strpos($relativePath, $ex) === 0) {
            $excludeFile = true;
            break;
        }
    }
    
    if (!$excludeFile) {
        $zip->addFile($filePath, $relativePath);
    }
}
$zip->close();

echo "Zip file created: " . filesize($zipFile) . " bytes\n";

// Connect to FTP
$conn = ftp_connect($ftpHost, 21);
if (!$conn) {
    die("Failed to connect to FTP\n");
}

if (!ftp_login($conn, $ftpUser, $ftpPass)) {
    die("Failed to login to FTP\n");
}

ftp_pasv($conn, true);

// Upload the zip file
echo "Uploading zip file...\n";
if (!ftp_put($conn, $remotePath . $zipFile, $zipFile, FTP_BINARY)) {
    die("Failed to upload zip file\n");
}

// Extract the zip on the server
echo "Extracting...\n";
$script = "<?php
\$zip = new ZipArchive();
if (\$zip->open('{$remotePath}{$zipFile}') === TRUE) {
    \$zip->extractTo('{$remotePath}');
    \$zip->close();
    unlink('{$remotePath}{$zipFile}');
    echo 'Extraction complete\\n';
} else {
    echo 'Failed to extract\\n';
}
?>";

file_put_contents('extract.php', $script);
ftp_put($conn, $remotePath . 'extract.php', 'extract.php', FTP_ASCII);

// Run the extraction script via HTTP
echo "Running extraction...\n";
$domain = 'https://5ivezz.app';
$response = file_get_contents($domain . '/extract.php');
echo $response;

// Cleanup
ftp_delete($conn, $remotePath . 'extract.php');
ftp_close($conn);
unlink($zipFile);
unlink('extract.php');

echo "Deployment complete!\n";