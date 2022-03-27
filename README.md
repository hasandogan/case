# case
symfony server:start
php bin/console doctrine:database:create
php bin/console doctrine:schema:create


php bin/console app:get-data http://www.mocky.io/v2/5d47f24c330000623fa3ebfa


php bin/console app:get-data http://www.mocky.io/v2/5d47f235330000623fa3ebf7

