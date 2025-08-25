@echo off
:: This batch script provides a menu to run common commands for the Yii Data Cycle project.
:: Ensure that the file is saved in Windows (CRLF) format e.g. Netbeans bottom right corner

title Yii Data Cycle Command Menu
cd /d "%~dp0"

:menu
cls
echo =======================================
echo         Yii Data Cycle SYSTEM MENU
echo =======================================
echo.
echo +-------------------------------+------------------------------------------+-----------------------------------+
echo ^| Feature/Tool                  ^| Roave Static Analysis Plugin             ^| Infection (Mutation Testing)      ^|
echo +-------------------------------+------------------------------------------+-----------------------------------+
echo ^| Main Focus                    ^| Static analysis coverage                 ^| Test suite effectiveness          ^|
echo ^| Typical Backend               ^| PHPStan or Psalm                         ^| PHPUnit                           ^|
echo ^| When it runs                  ^| Composer events (install/update)         ^| Manually or in CI                 ^|
echo ^| Fails build if...             ^| New static analysis errors introduced    ^| Tests do not catch code changes   ^|
echo ^| Increases code safety by...   ^| Enforcing type safety and static checks  ^| Forcing robust meaningful tests   ^|
echo ^| Typical for                   ^| Code quality, type safety                ^| Test quality + mutation coverage  ^|
echo +-------------------------------+------------------------------------------+-----------------------------------+
echo.
echo [1] Run PHP Psalm
echo [2] Run PHP Psalm on a Specific File
echo [2a] Clear Psalm's cache (in the event of stubborn errors)
echo [2b] Php Unit Tests
echo [2c] Mutation Tests using Roave Covered - Prevents code from being merged if it decreases static analysis coverage
echo [2d] Mutation Tests using Roave Uncovered - Prevents code from being merged if it decreases static analysis coverage
echo [2e] Mutation Tests using Infection - Tests the quality of your test suite by introducing small changes a.k.a mutants in your code 
echo [3] Check Composer Outdated
echo [3a] Composer why-not {repository eg. yiisoft/yii-demo} {patch/minor version e.g. 1.1.1}
echo [3b] Run Code Style Fixer with a dry-run to see potential changes
echo [3c] Run Code Style Fixer and actually change the coding style of the files
echo [4] Run Composer Update
echo [5] Run Composer Require Checker
echo [5a] Run Rector See Potential Changes
echo [5b] Run Rector Make Changes
echo [6] Exit
echo [7] Exit to Current Directory
echo =======================================
set /p choice="Enter your choice [1-7]: "

if "%choice%"=="1" goto psalm
if "%choice%"=="2" goto psalm_file
if "%choice%"=="2a" goto psalm_clear_cache
if "%choice%"=="2b" goto php_unit_test
if "%choice%"=="2c" goto roave_infection_covered
if "%choice%"=="2d" goto roave_infection_uncovered
if "%choice%"=="2e" goto infection
if "%choice%"=="3" goto outdated
if "%choice%"=="3a" goto composerwhynot
if "%choice%"=="3b" goto code_style_suggest_changes
if "%choice%"=="3c" goto code_style_make_changes
if "%choice%"=="4" goto composer_update
if "%choice%"=="5" goto require_checker
if "%choice%"=="5a" goto rector_see_changes
if "%choice%"=="5b" goto rector_make_changes
if "%choice%"=="6" goto exit
if "%choice%"=="7" goto exit_to_directory
echo Invalid choice. Please try again.
pause
goto menu

:code_style_suggest_changes
echo Suggested changes to the Coding Style 
php vendor/bin/php-cs-fixer fix --config=.php-cs-fixer.php --dry-run --diff 
pause
goto menu

:code_style_make_changes
echo Make the changes that were suggested to the Coding Style 
php vendor/bin/php-cs-fixer fix --config=.php-cs-fixer.php 
pause
goto menu

:psalm
echo Running PHP Psalm...
php vendor/bin/psalm
pause
goto menu

:psalm_file
echo Running PHP Psalm on a specific file...
set /p file="Enter the path to the file (relative to the project root): "
if "%file%"=="" (
    echo No file specified. Returning to the menu.
    pause
    goto menu
)
php vendor/bin/psalm "%file%"
pause
goto menu

:psalm_clear_cache
echo Running PHP Psalm... php vendor/bin/psalm --clear-cache
php vendor/bin/psalm --clear-cache
pause
goto menu

:php_unit_test
echo Running PHP Unit Tests ... php vendor/bin/phpunit
php vendor/bin/phpunit 
pause
goto menu

:roave_infection_covered
echo Running Roave Infection Static Analysis Plugin ... php vendor/bin/roave-infection-static-analysis-plugin --only-covered --min-msi=99 
php vendor/bin/roave-infection-static-analysis-plugin --only-covered --min-msi=99
pause
goto menu

:roave_infection_uncovered
echo Running Roave Infection Static Analysis Plugin ... php vendor/bin/roave-infection-static-analysis-plugin --min-msi=99 
php vendor/bin/roave-infection-static-analysis-plugin --min-msi=99
pause
goto menu#

:infection
echo Running Infection ... php vendor/bin/infection 
php vendor/bin/infection
pause
goto menu

:outdated
echo Checking Composer Outdated... composer outdated
composer outdated
pause
goto menu

:composerwhynot
@echo off
set /p repo="Enter the package name (e.g. vendor/package): "
set /p version="Enter the version (e.g. 1.0.0): "
composer why-not %repo% %version%
pause
goto menu

:require_checker
echo Running Composer Require Checker... php vendor/bin/composer-require-checker
php vendor/bin/composer-require-checker
pause
goto menu

:rector_see_changes
echo See changes that Rector Proposes... php vendor/bin/rector process --dry-run
php vendor/bin/rector process --dry-run 
pause
goto menu

:rector_make_changes
echo Make changes that Rector Proposed... php vendor/bin/rector
php vendor/bin/rector
pause
goto menu

:composer_update
echo Running Composer Update... composer update
composer update
pause
goto menu

:exit_to_directory
echo Returning to the current directory. Goodbye!
cmd

:exit
echo Exiting. Goodbye!
pause
exit