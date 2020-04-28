#!/bin/sh -l

if [ -z $INPUT_MEMORY_LIMIT ]; then
  INPUT_MEMORY_LIMIT="128M"
fi

if [ -z $INPUT_OUTPUT_DIR ]; then
  INPUT_OUTPUT_DIR="docs"
fi

php -d memory_limit=$INPUT_MEMORY_LIMIT /generator/codingStyleGenerator.phar $INPUT_OUTPUT_DIR $*

vuepress build $INPUT_OUTPUT_DIR