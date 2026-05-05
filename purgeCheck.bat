@echo off
set "SCRIPT_PATH=%~dp0"
cd /d "%SCRIPT_PATH%"

where php >nul 2>&1
if %errorlevel% neq 0 (
    echo PHP not found in PATH. Please install XAMPP or add PHP to your Environment Variables.
    exit /b
)

php notify.php
exit