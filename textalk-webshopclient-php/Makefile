install: composer.phar
	./composer.phar install

update: composer.phar
	./composer.phar update

test: vendor/bin/phpunit build
	./vendor/bin/phpunit --strict

composer.phar:
	curl -s http://getcomposer.org/installer | php

vendor/bin/phpunit: install

build:
	mkdir build

clean:
	rm -f composer.phar
	rm -fr vendor
	rm -fr build
