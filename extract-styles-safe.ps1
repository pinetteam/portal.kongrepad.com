# Meeting Styles Extractor Script (Safe Version)
Write-Host "Starting style extraction from meeting files..." -ForegroundColor Yellow

$meetingPath = "resources/views/portal/meeting"
$cssOutputPath = "public/css/meeting-styles.css"

# Create public/css directory if it doesn't exist
$cssDir = Split-Path $cssOutputPath -Parent
if (!(Test-Path $cssDir)) {
    New-Item -ItemType Directory -Path $cssDir -Force
    Write-Host "Created CSS directory: $cssDir" -ForegroundColor Green
}

$allStyles = @()
$processedFiles = 0

Write-Host "Scanning files..." -ForegroundColor Cyan

# Process all blade files
Get-ChildItem -Path $meetingPath -Recurse -Filter "*.blade.php" | ForEach-Object {
    $filePath = $_.FullName
    $content = Get-Content -Path $filePath -Raw -Encoding UTF8
    
    # Check if file contains style tags
    if ($content -match "(?s)<style>(.*?)</style>") {
        $styleContent = $matches[1].Trim()
        $fileName = $_.Name
        $relativeFilePath = $_.FullName.Replace((Get-Location).Path + "\", "")
        
        # Add to styles collection with file header
        $fileHeader = "/* ============================================`n   Extracted from: $relativeFilePath`n   ============================================ */"
        $allStyles += "$fileHeader`n$styleContent`n`n"
        
        Write-Host "Found styles in: $fileName" -ForegroundColor Green
        $processedFiles++
    }
}

# Create consolidated CSS file
if ($allStyles.Count -gt 0) {
    $cssHeader = "/* ============================================`n   MEETING STYLES - CONSOLIDATED CSS`n   Generated on: $(Get-Date)`n   Total files processed: $processedFiles`n   ============================================ */`n`n"
    
    $finalCss = $cssHeader + ($allStyles -join "`n")
    Set-Content -Path $cssOutputPath -Value $finalCss -Encoding UTF8
    
    Write-Host ""
    Write-Host "SUCCESS!" -ForegroundColor Yellow
    Write-Host "Consolidated CSS saved to: $cssOutputPath" -ForegroundColor Cyan
    Write-Host "Total files processed: $processedFiles" -ForegroundColor Cyan
    Write-Host "CSS file size: $((Get-Item $cssOutputPath).Length) bytes" -ForegroundColor Cyan
    
    # Show which files had styles
    Write-Host "`nFiles with styles:" -ForegroundColor Magenta
    Get-ChildItem -Path $meetingPath -Recurse -Filter "*.blade.php" | ForEach-Object {
        $content = Get-Content -Path $_.FullName -Raw -Encoding UTF8
        if ($content -match "(?s)<style>(.*?)</style>") {
            Write-Host "  - $($_.Name)" -ForegroundColor White
        }
    }
} else {
    Write-Host ""
    Write-Host "No style tags found in meeting files." -ForegroundColor Red
}

Write-Host ""
Write-Host "Style extraction completed! (Files not modified)" -ForegroundColor Yellow 