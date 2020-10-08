<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

## Sobre o projeto

Para rodar o projeto deve se dividir o processo em duas pequenas etapas: 
- 1º Instalar os pacotes do node com npm ou yarn na pasta raiz do projeto.
- 2º Acessar o front feito em vue abrindo o terminal e rodando o comando com npm run watch ou yarn run watch(consulte para confirmar o comando), assim ele iniciará o servidor do vueJs para desenvolvimento.
- 3ª Rodar o servidor da aplicação, na pasta raiz do projeto digite o comando php artisan serve.

A aplicação está dividida entre dois end-points sendo eles:
- http://127.0.0.1:8000/<seu_nome>/registrar

Aqui contem um formulario aonde voce pode cadastras os seus dados basicos.

- http://127.0.0.1:8000/<nome_do_admin>/validar
Essa rota é protegita, então somente um administrador pode entrar para validar os registros.

Rode as Migrates, para criar as tabelas no banco de dados:
- php artisan migrate

O administrador que acessa a url "validar" está pré configurado como um arquivo seed, então rode: 
- php artisan db:seed --class=UserAdminSeeder
 
Após isso use o nome: Perdo-admin-2222 para acessar a rota validar.

## License
The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
