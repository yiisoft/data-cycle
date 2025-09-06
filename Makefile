.PHONY: m p pf pc pu ric riu i co cwn cs cm cu crc rdr rmc ep em es ex ea rp rm rs re x xd

m:
	@echo "================================================================================"
	@echo "                Data Cycle SYSTEM MENU (Make targets)"
	@echo "================================================================================"
	@echo ""
	@echo "make p     - Run PHP Psalm"
	@echo "make pf FILE=src/Foo.php     - Run PHP Psalm on a specific file"
	@echo "make pc    - Clear Psalm's cache"
	@echo "make pu    - Run PHPUnit tests"
	@echo "make ric   - Roave Infection Covered"
	@echo "make riu   - Roave Infection Uncovered"
	@echo "make i     - Infection Mutation Test"
	@echo "make co    - Composer outdated"
	@echo "make cwn REPO=yiisoft/yii-demo VERSION=1.1.1 - Composer why-not"
	@echo "make cs    - PHP CS Fixer dry-run"
	@echo "make cm    - PHP CS Fixer fix"
	@echo "make cu    - Composer update"
	@echo "make crc   - Composer require checker"
	@echo "make rdr   - Rector Dry Run (see changes)"
	@echo "make rmc   - Rector (make changes)"
	@echo ""
	@echo "Extension & DB Test Suite Menu:"
	@echo "make ep    - Check PostgreSQL PHP extensions"
	@echo "make em    - Check MySQL PHP extensions"
	@echo "make es    - Check SQLite PHP extensions"
	@echo "make ex    - Check MSSQL PHP extensions"
	@echo "make ea    - Check ALL DB PHP extensions"
	@echo "make rp    - Run PHPUnit Pgsql test suite"
	@echo "make rm    - Run PHPUnit Mysql test suite"
	@echo "make rs    - Run PHPUnit Sqlite test suite"
	@echo "make re    - Run PHPUnit Mssql test suite"
	@echo "================================================================================"

p:
	php vendor/bin/psalm

pf:
ifndef FILE
	$(error Please provide FILE, e.g. 'make pf FILE=src/Foo.php')
endif
	php vendor/bin/psalm "$(FILE)"

pc:
	php vendor/bin/psalm --clear-cache

pu:
	php vendor/bin/phpunit

ric:
	php vendor/bin/roave-infection-static-analysis-plugin --only-covered

riu:
	php vendor/bin/roave-infection-static-analysis-plugin

i:
	php vendor/bin/infection

co:
	composer outdated

cwn:
ifndef REPO
	$(error Please provide REPO, e.g. 'make cwn REPO=yiisoft/yii-demo VERSION=1.1.1')
endif
ifndef VERSION
	$(error Please provide VERSION, e.g. 'make cwn REPO=yiisoft/yii-demo VERSION=1.1.1')
endif
	composer why-not $(REPO) $(VERSION)

cs:
	php vendor/bin/php-cs-fixer fix --dry-run --diff

cm:
	php vendor/bin/php-cs-fixer fix

cu:
	composer update

crc:
	php vendor/bin/composer-require-checker

rdr:
	php vendor/bin/rector process --dry-run

rmc:
	php vendor/bin/rector

ep:
	@echo "Checking for pdo_pgsql and pgsql extensions..."
	@php -m | grep -E "^pdo_pgsql$$|^pgsql$$" || (echo 'Missing PostgreSQL extensions!'; exit 1)

em:
	@echo "Checking for pdo_mysql and mysql extensions..."
	@php -m | grep -E "^pdo_mysql$$|^mysql$$" || (echo 'Missing MySQL extensions!'; exit 1)

es:
	@echo "Checking for pdo_sqlite and sqlite3 extensions..."
	@php -m | grep -E "^pdo_sqlite$$|^sqlite3$$" || (echo 'Missing SQLite extensions!'; exit 1)

ex:
	@echo "Checking for pdo_sqlsrv and sqlsrv extensions..."
	@php -m | grep -E "^pdo_sqlsrv$$|^sqlsrv$$" || (echo 'Missing MSSQL extensions!'; exit 1)

ea:
	$(MAKE) ep
	$(MAKE) em
	$(MAKE) es
	$(MAKE) ex

rp:
	php vendor/bin/phpunit --testsuite Pgsql

rm:
	php vendor/bin/phpunit --testsuite Mysql

rs:
	php vendor/bin/phpunit --testsuite Sqlite

re:
	php vendor/bin/phpunit --testsuite Mssql