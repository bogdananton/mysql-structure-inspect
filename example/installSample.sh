#!/usr/bin/env bash

# import
git clone https://github.com/datacharmer/test_db
cd test_db
mysql -uroot -pPASSWORD < employees.sql
cd ..
rm -rf test_db

# extract
php ../console.php details root:PASSWORD@localhost/test_db

# display
cat structure*
