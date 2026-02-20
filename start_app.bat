@echo off
setlocal ENABLEDELAYEDEXPANSION

REM Change working directory to the folder where this script lives
cd /d "%~dp0"

REM ---------------------------------------------
REM (Optional) Start your standalone MySQL server
REM ---------------------------------------------
REM If you installed MySQL as a Windows service, you can uncomment and
REM adjust the service name below so that the database starts automatically.
REM Example service names: MySQL, MySQL80, mysql57, etc.
REM net start MySQL80 >NUL 2>&1

REM ---------------------------------------------
REM Locate PHP executable
REM ---------------------------------------------
REM Preferred: bundled portable PHP at .\php\php.exe
set "PHP_BIN=%~dp0php\php.exe"

if not exist "%PHP_BIN%" (
    REM Fallback: use php from PATH
    set "PHP_BIN=php"
)

REM Port for the mini local server
set "PORT=8080"

REM Start PHP built-in web server in a new window
start "PersonnelVerification-PHP-Server" "%PHP_BIN%" -S 127.0.0.1:%PORT% -t "%cd%"

REM Give the server a moment to start
timeout /t 2 /nobreak >NUL

REM Open default browser pointing to index.php
start "" "http://127.0.0.1:%PORT%/index.php"

endlocal
