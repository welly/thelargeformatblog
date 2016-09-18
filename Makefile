PHPCS_FOLDERS=app/sites/all/modules/custom
PHPCS_EXTENSIONS=php,module,inc,install,test,profile,theme
BUILD_LOGS_DIR=./build/logs
ARCH=$(shell uname -m)
APP_ROOT=./app
URI=thelargeformatblog.dev

build: updb cache-clear

build-local: sql-drop sync updb features-revert cache-clear

build-production: maintenance-on updb features-revert cache-clear maintenance-off

build-front-end:
	node_modules/.bin/gulp build

sql-drop:
	drush -r $(APP_ROOT) sql-drop -y

updb:
	drush -r $(APP_ROOT) updb -y

cache-clear:
	drush -r $(APP_ROOT) cc all -y

maintenance-on:
	drush -r ${APP_ROOT} vset site_offline 1 -y

maintenance-off:
	drush -r ${APP_ROOT} vset site_offline 0 -y

sync: sync-prod

sync-prod:
	drush @largeformat.prod sql-dump > /tmp/db.sql && drush sql-cli -r ${APP_ROOT} < /tmp/db.sql

sync-dev:
	drush @largeformat.prod sql-dump > /tmp/db.sql && drush sql-cli -r ${APP_ROOT} < /tmp/db.sql

features-revert:
	drush -r ${APP_ROOT} fra -y

phpcbf:
	./bin/phpcbf --report=full --standard=vendor/drupal/coder/coder_sniffer/Drupal/ruleset.xml --extensions=$(PHPCS_EXTENSIONS) $(PHPCS_FOLDERS)

phpcs:
	./bin/phpcs --report=full --standard=vendor/drupal/coder/coder_sniffer/Drupal/ruleset.xml --extensions=$(PHPCS_EXTENSIONS) $(PHPCS_FOLDERS)

ci-phpcs: ci-prepare
	rm -rf $(BUILD_LOGS_DIR)/checkstyle.xml
	./bin/phpcs --report=checkstyle --report-file=$(BUILD_LOGS_DIR)/checkstyle.xml --standard=vendor/drupal/coder/coder_sniffer/Drupal/ruleset.xml --extensions=$(PHPCS_EXTENSIONS) $(PHPCS_FOLDERS)

ci-prepare:
	mkdir -p $(BUILD_LOGS_DIR)

test-ci: phantomjs
	mkdir -p app/sites/simpletest
	export SIMPLETEST_BASE_URL="http://127.0.0.1";export SIMPLETEST_DB="mysql://drupal:drupal@localhost/local";./bin/phpunit -c app/core app/sites/all/modules/custom --log-junit build/logs/phpunit/phpunit.xml
	kill `cat $(CURDIR)/.phantomjs.pid`

test:
	export BROWSERTEST_OUTPUT_FILE="/vagrant/app/test-output.html";export SIMPLETEST_BASE_URL="http://${URI}";export SIMPLETEST_DB="mysql://root:@localhost/d7_testing";./bin/phpunit -c $(APP_ROOT)/sites/all/modules/custom/$(folder);cat $(APP_ROOT)/test-output.html;echo "" > $(APP_ROOT)/test-output.html

test-init:
	touch $(APP_ROOT)/test-output.html;
	chmod 777 $(APP_ROOT)/test-output.html;
	echo "create database d7_testing;" | sudo mysql

login:
	drush uli --uri=http://${URI}

setup-local:
	composer install
	mkdir -p /home/vagrant/.drush
	cp /vagrant/largeformat.aliases.drushrc.php /home/vagrant/.drush/

phantomjs: phantom-init
	$(CURDIR)/bin/phantomjs --ssl-protocol=any --ignore-ssl-errors=true vendor/jcalderonzumba/gastonjs/src/Client/main.js 8510 1024 768 & echo $$! > $(CURDIR)/.phantomjs.pid

phantom-init:
ifneq ($(wildcard .phantomjs.lock),)
	echo "Phantomjs already exists"
else
	wget https://dl.dropboxusercontent.com/u/10201421/phantomjs-2.1.1-linux-$(ARCH).tar.bz2 -O /tmp/phantomjs.tar.bz2
	cd /tmp && tar -jxf /tmp/phantomjs.tar.bz2
	ln -s /tmp/phantomjs-2.1.1-linux-$(ARCH)/bin/phantomjs $(CURDIR)/bin
	touch .phantomjs.lock
endif
