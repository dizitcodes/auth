# Auth Panel

## Instalação

Instalar o CodeIgniter4 pelo composer

```sh
composer create-project codeigniter4/appstarter ./
```

Instalar o JWT

```sh
composer require firebase/php-jwt
```

Instalar e rodar o Dizit/Auth

```sh
composer require dizitcodes/auth
php spark auth:setup
copy dizit.env .env
```

Configurar o ENV
> Edite o arquivo .env para conectar com seu banco MYSQL na linha 33 (já criado ateriormente)
> Adicione uma KEY secreta na linha 166 (o comando php spark auth:setup gerou uma sugestão)

Instalar o CodeIgniter Settings

```sh
composer require codeigniter4/settings
```

Rodar os migrations e seeders

```sh
php spark migrate --all
php spark db:seed UsersSeeder
```

Iniciar server

```sh
php spark server
```

Acesso ao admin
[localhost:8080/auth](http://localhost:8080/auth)
> O usuário e senha padrão do admin se encontra no arquivo App>Database>Seeds>UsersSeeder.php


## License

MIT

**Free Software, Hell Yeah!**
