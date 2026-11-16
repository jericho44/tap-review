@echo off
title TapReview Development Server
echo ========================================================
echo       Starting TapReview Local Development Server
echo ========================================================
echo.

:: Ensure PHP 8.3 is in PATH for this session
set "PATH=C:\laragon\bin\php\php-8.3.28-Win32-vs16-x64;%PATH%"

echo [1/3] Checking PHP version...
php -v | findstr /i "PHP 8."
echo.

echo [2/3] Checking PostgreSQL connection...
php artisan db:monitor
echo.

echo [3/3] Starting Laravel Server at http://127.0.0.1:8000 ...
echo (Press Ctrl+C to stop)
echo.

php artisan serve --port=8000
pause
