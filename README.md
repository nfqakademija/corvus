# Corvus team food booking project

Clean vagrant machine with Symfony installed.

## Instalation

```sh
vagrant up
vagrant ssh
cd /var/www/corvus/
composer install
```
to create database run: ```php app/console doctrine:database:create```
to create DB tables run: ```php app/console doctrine:schema:update --force```

then <http://corvus.dev> should show "Hello World" from CorvusMainBundle
