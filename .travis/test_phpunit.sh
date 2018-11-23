#!/usr/bin/env bash

set -ev

echo "Running unit tests";

composer require ${TYPO3_VERSION}

#phpenv config-rm xdebug.ini

.Build/bin/phpunit Tests/Unit/
