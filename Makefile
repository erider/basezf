#
# MyProject Makefile
#
# Targets:
#  - clean: remove the staged files.
#
# @copyright  Copyright (c) 2008 BaseZF
# @author     Harold Th�tiot (hthetiot)
# @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)

# Binary
ZIP = zip
TAR = tar
PHP = php
DOXYGEN = doxygen

YUI_VERSION = 2.3.5
YUI = java -jar $(PROJECT_BIN)/yuicompressor-$(YUI_VERSION).jar --charset UTF-8

# Project ID
PROJECT_NAME = MyProject
PROJECT_VERSION = alpha

# Path
ROOT = .
PROJECT_LIB = $(ROOT)/lib
PROJECT_BIN = $(ROOT)/bin

# Static
LOCALES_SRC_PATH = $(ROOT)/app
CSS_SRC_PATH = $(ROOT)/etc/static/css
CSS_PACK_PATH = $(ROOT)/public/css/pack
JS_SRC_PATH = $(ROOT)/etc/static/js
JS_PACK_PATH = $(ROOT)/public/js/pack

# Others
RELEASE_NAME = $(NAME)-$(VERSION)
CHANGELOG_FILE_PATH = $(ROOT)/CHANGELOG

ZIP_NAME = $(NAME)-$(VERSION).zip
TAR_NAME = $(NAME)-$(VERSION).tar.gz

all: clean syntax locales static-pack
	@echo "----------------"
	@echo "Project build complete."
	@echo ""

doc:
	@echo "----------------"
	@echo "Generate doxygen doc :"
	@$(DOXYGEN) ./etc/doxygen.cnf > ./logs/doc.log
	@echo "done"

list:

syntax:
	@echo "----------------"
	@echo "Check PHP syntax on all php files:"
	@PHP_SOURCES=`find . -type f -name *.php | tr '\n' ' '`
	@for i in $(PHP_SOURCES); do test=`php -l $$i`; test2=`echo $$test | grep "Parse error"`; if [ "$$test2" != "" ]; then echo $$test; exit 1; fi; done;
	@echo "done"

test:
	@echo "----------------"
	@echo "Exec Units test:"
	@cd tests && phpunit AllTests
	@echo "done"

locales:
	@echo "----------------"
	@echo "Build GetText MO files:"
#todo
	@echo "done"

# Static packing
static-pack: static-pack-css static-pack-js

static-pack-css:
	@echo "----------------"
	@./bin/tools/static-pack.sh css $(CSS_SRC_PATH) $(CSS_PACK_PATH)

static-pack-js:
	@echo "----------------"
	@./bin/tools/static-pack.sh js $(JS_SRC_PATH) $(JS_PACK_PATH)

# Clean Useless file
clean:
	@echo "----------------"
	@echo "Cleaning useless files:"
	@find . -name "*~" -exec rm {} \;
	@echo "done"

.PHONY: doc
