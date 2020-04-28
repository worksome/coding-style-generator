#!/bin/sh -l

if [ -z $INPUT_MEMORY_LIMIT ]; then
  INPUT_MEMORY_LIMIT="128M"
fi

php -d memory_limit=$INPUT_MEMORY_LIMIT /action/codingStyleGenerator.phar $INPUT_OUTPUT_DIR $*