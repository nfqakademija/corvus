# Corvus team food booking project

Clean vagrant machine with Symfony installed.

## Notes

```sh
vagrant up
vagrant ssh
cd /var/www/corvus/
composer install

create DB
 php app/console doctrine:schema:create
Update DB, so that it have fos_user table
 php app/console doctrine:schema:update --force
```
then <http://corvus.dev> should show login and registration forms
