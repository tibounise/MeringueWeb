#!/bin/sh

cd $(dirname $0)
cd doc
./mkdoc.php deploy ../documentation
cd ..
rm -rf doc
rm .gitignore
rm README.md
rm build.sh
echo "DONE !"