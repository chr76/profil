$ symfony new --full ./
$ composer requier symfony/webpack-encore-bundle
$ yarn install
$ yarn add sass-loader@^9.0.1 node-sass --dev // version >9.0.1 incompatible avec webpack
$ yarn add jquery popper.js --dev
$ yarn add bootstrap --dev

$ php bin/console make:entity
$ php bin/console make:controller


Lancer serveur web dev
$ yarn run dev-server
$ symfony server:start <-- https (ssl) provoque une erreur Cross Origin Request
$ php -S localhost:8000 -t public <-- http ne provoque pas d'erreur