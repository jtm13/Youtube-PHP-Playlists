DIR = /c/xampp/htdocs/mine/APITest/
SRC = src/

all: php

php:
	cp -r . $(DIR)

run:
	php -S localhost:80 $(DIR)*

clean:
	rm -f $(DIR)*.*
	rm -f $(DIR)css/*.css
