# Corvus team food booking project

Clean vagrant machine with Symfony installed.

## Instalation

```sh
vagrant up
vagrant ssh
cd /var/www/corvus/
composer install

```

to create DB tables run: ```php app/console doctrine:schema:update --force```

<<<<<<< HEAD
then <http://corvus.dev> should show login and registration forms

=======
then <http://corvus.dev> should show "Hello World" from CorvusMainBundle
>>>>>>> parent of 4f6c8ec... Update README.md
