@echo off
title TapReview Queue Worker
echo ========================================================
echo       Starting TapReview Background Queue Worker
echo ========================================================
echo.

set "PATH=C:\laragon\bin\php\php-8.3.28-Win32-vs16-x64;%PATH%"

echo Starting queue worker (database connection)...
php artisan queue:work database --sleep=3 --tries=3
pause
