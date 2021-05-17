# School database
Simple tools to manage your lectures with your users.

## Installation
Download and install 

[Laragon](https://laragon.org/download/)

[Composer](https://getcomposer.org/download/)

Then clone the repository into the www folder of laragon path and setup the .env file according to your web server settings.

Afterwards, open a command prompt, go the web app directory and type the following commands

Create database

```bash
php bin/console doctrine:database:create
```

Install the dependencies
```bash
composer install
```

Install the js libraries
```bash
yarn install --force
```

Clear cache
```bash
php bin/console cache:clear -vvv
```

Have fun 👾👾👾

## License
[MIT](https://choosealicense.com/licenses/mit/)