$files = Get-ChildItem -Path ./resources/views -Filter *.blade.php -Recurse
foreach($file in $files) {
    $content = Get-Content $file.FullName
    $newContent = $content -replace 'data-bs-toggle="modal"', 'data-bs-toggle="offcanvas"'
    Set-Content -Path $file.FullName -Value $newContent
} 