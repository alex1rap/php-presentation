# Test Task #

## SetUp ##

- ### Install SymfonyCLI ###

```shell
echo 'deb [trusted=yes] https://repo.symfony.com/apt/ /' | sudo tee /etc/apt/sources.list.d/symfony-cli.list
sudo apt update
sudo apt install symfony-cli
```

- ### Clone project: ###

```shell
git clone git@github.com:alex1rap/php-presentation.git
cd php-presentation
```

- ### Create database ###
- ### Configure environment (in file .env) ###

- ### Migrate: ###

```shell
bin/console doctrine:migrations:migrate
```

- ### Start debug server: ###

```shell
symfony server:start
```
