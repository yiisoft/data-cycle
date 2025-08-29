@echo off
REM php_ext_check.bat: PHP extension & test suite checker for data-cycle

REM Get the php.ini used by the active 'php' in your PATH
for /f "tokens=*" %%i in ('php --ini ^| findstr /C:"Loaded Configuration File"') do set "PHP_INI=%%i"
set "PHP_INI=%PHP_INI:Loaded Configuration File: =%"
set "PHP_INI=%PHP_INI: =%"
if not exist "%PHP_INI%" (
    echo Could not find active php.ini via PATH.
    goto end
)
echo Using active php.ini at: %PHP_INI%

:menu
echo.
echo ==== PHP Extension and Test Suite Submenu ====
echo [1] Check PostgreSQL extensions (pdo_pgsql, pgsql)
echo [2] Check MySQL extensions (pdo_mysql, mysql)
echo [3] Check SQLite extensions (pdo_sqlite, sqlite3)
echo [4] Check MSSQL extensions (pdo_sqlsrv, sqlsrv)
echo [5] Check ALL extensions above
echo [6] Run PHPUnit Pgsql suite
echo [7] Run PHPUnit Mysql suite
echo [8] Run PHPUnit Sqlite suite
echo [9] Run PHPUnit Mssql suite
echo [Q] Quit
set /p choice="Enter your choice: "

if /i "%choice%"=="1" goto check_pgsql
if /i "%choice%"=="2" goto check_mysql
if /i "%choice%"=="3" goto check_sqlite
if /i "%choice%"=="4" goto check_mssql
if /i "%choice%"=="5" goto check_all
if /i "%choice%"=="6" goto run_pgsql
if /i "%choice%"=="7" goto run_mysql
if /i "%choice%"=="8" goto run_sqlite
if /i "%choice%"=="9" goto run_mssql
if /i "%choice%"=="Q" goto end

echo Invalid choice.
goto menu

:check_pgsql
call :check_ext "pdo_pgsql"
call :check_ext "pgsql"
goto menu

:check_mysql
call :check_ext "pdo_mysql"
call :check_ext "mysql"
goto menu

:check_sqlite
call :check_ext "pdo_sqlite"
call :check_ext "sqlite3"
goto menu

:check_mssql
call :check_ext "pdo_sqlsrv"
call :check_ext "sqlsrv"
goto menu

:check_all
echo --- PostgreSQL ---
call :check_ext "pdo_pgsql"
call :check_ext "pgsql"
echo --- MySQL ---
call :check_ext "pdo_mysql"
call :check_ext "mysql"
echo --- SQLite ---
call :check_ext "pdo_sqlite"
call :check_ext "sqlite3"
echo --- MSSQL ---
call :check_ext "pdo_sqlsrv"
call :check_ext "sqlsrv"
goto menu

:run_pgsql
echo Running: vendor\bin\phpunit --testsuite Pgsql
vendor\bin\phpunit --testsuite Pgsql
goto menu

:run_mysql
echo Running: vendor\bin\phpunit --testsuite Mysql
vendor\bin\phpunit --testsuite Mysql
goto menu

:run_sqlite
echo Running: vendor\bin\phpunit --testsuite Sqlite
vendor\bin\phpunit --testsuite Sqlite
goto menu

:run_mssql
echo Running: vendor\bin\phpunit --testsuite Mssql
vendor\bin\phpunit --testsuite Mssql
goto menu

REM Subroutine for checking extension in php.ini
:check_ext
set "EXT=%~1"
findstr /R /C:"^[^;]*extension\s*=\s*%EXT%" "%PHP_INI%" >nul
if %ERRORLEVEL% EQU 0 (
    echo %EXT% extension is ENABLED in %PHP_INI%
) else (
    echo %EXT% extension is NOT enabled in %PHP_INI%
)
exit /b

:end
echo.
echo Exiting.
pause