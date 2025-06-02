# Remove Style Tags Script
Write-Host "Removing style tags from meeting files..." -ForegroundColor Yellow

$meetingPath = "resources/views/portal/meeting"
$processedFiles = 0

# Process all blade files
Get-ChildItem -Path $meetingPath -Recurse -Filter "*.blade.php" | ForEach-Object {
    $filePath = $_.FullName
    $content = Get-Content -Path $filePath -Raw -Encoding UTF8
    
    # Check if file contains style tags
    if ($content -match "(?s)<style>(.*?)</style>") {
        $fileName = $_.Name
        
        # Remove style tags from file
        $newContent = $content -replace "(?s)<style>.*?</style>", ""
        Set-Content -Path $filePath -Value $newContent -Encoding UTF8
        
        Write-Host "Removed styles from: $fileName" -ForegroundColor Green
        $processedFiles++
    }
}

Write-Host ""
Write-Host "Removed style tags from $processedFiles files!" -ForegroundColor Yellow 