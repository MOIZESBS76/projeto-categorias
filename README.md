# 🚀 Projeto Categorias - CRUD com Laravel e Docker

## 📝 Descrição do Projeto

Este projeto é uma aplicação web desenvolvida com **Laravel** para o backend, utilizando **Docker** para orquestração de containers e **MySQL** como banco de dados. O objetivo principal é demonstrar a implementação de um **CRUD (Create, Read, Update, Delete)** completo para a entidade `Categorias`, seguindo as melhores práticas de desenvolvimento backend e organização de projeto.

## 🎯 Objetivo do Trabalho (Trabalho Avaliativo)

Este repositório representa um trabalho avaliativo focado na criação de um ambiente de desenvolvimento robusto e funcional. Os principais pontos de avaliação incluem:

*   **Desenvolvimento Backend**: Implementação de lógica de negócio e manipulação de dados.
*   **Organização do Projeto**: Estrutura de arquivos e pastas clara e padronizada.
*   **Utilização Correta do Docker e MySQL**: Configuração e interação eficiente entre os serviços.
*   **Boas Práticas**: Aplicação de padrões em rotas, controllers, migrations e Eloquent ORM.
*   **Operações CRUD**: Funcionalidades completas de criação, listagem, edição e exclusão de dados.

## ⚙️ Requisitos do Sistema

Para rodar este projeto, você precisará ter instalado em sua máquina:

*   **Docker**: Versão 20.10.0 ou superior.
*   **Docker Compose**: Versão 1.29.0 ou superior (geralmente vem junto com o Docker Desktop).

## 📁 Estrutura do Projeto

A estrutura principal do projeto segue o padrão Laravel, com a adição dos arquivos de configuração do Docker na raiz:

. ├── .env.example ├── .gitignore ├── Dockerfile ├── docker-compose.yml ├── app/ │ ├── Http/ │ │ └── Controllers/ │ │ └── CategoryController.php │ └── Models/ │ └── Category.php ├── bootstrap/ ├── config/ ├── database/ │ ├── migrations/ │ │ └── 2025_11_26_xxxxxx_create_categories_table.php │ └── seeders/ ├── public/ ├── resources/ │ └── views/ │ └── categories/ │ ├── create.blade.php │ ├── edit.blade.php │ └── index.blade.php ├── routes/ │ └── web.php ├── storage/ ├── tests/ ├── vendor/ ├── artisan ├── composer.json ├── composer.lock ├── package.json ├── phpunit.xml └── vite.config.js

## 🛠️ Como Instalar e Configurar (Passo a Passo) Siga estas etapas para configurar e rodar o projeto em sua máquina: 1. **Clone o Repositório:** ```bash git clone https://github.com/SEU_USUARIO/projeto-categorias.git cd projeto-categorias ``` *(Substitua `SEU_USUARIO` pelo seu usuário do GitHub)* 2. **Crie o Projeto Laravel (via Docker):** Como o projeto já está configurado para Docker, vamos usar o `composer` dentro de um container temporário para criar a estrutura inicial do Laravel. ```bash docker run --rm -v ${PWD}:/app composer create-project laravel/laravel . --no-interaction ``` *Aguarde alguns minutos até a instalação ser concluída.* 3. **Copie o arquivo de ambiente:** ```bash cp .env.example .env ``` 4. **Edite o arquivo `.env`:** Abra o arquivo `.env` e configure as variáveis de ambiente para o banco de dados e a URL da aplicação: ```ini APP_KEY= # Será gerada no próximo passo APP_URL=http://localhost:8000 DB_CONNECTION=mysql DB_HOST=mysql DB_PORT=3306 DB_DATABASE=laravel DB_USERNAME=root DB_PASSWORD=root SESSION_DRIVER=file QUEUE_CONNECTION=sync CACHE_STORE=file ``` 5. **Gere a APP_KEY do Laravel:** ```bash docker run --rm -v ${PWD}:/app -w /app php:8.2-cli php artisan key:generate ``` 6. **Crie os arquivos Docker:** Crie o `docker-compose.yml` e o `Dockerfile` na raiz do projeto com os seguintes conteúdos: **`docker-compose.yml`** ```yaml services: app: build: context: . dockerfile: Dockerfile container_name: laravel_app restart: unless-stopped working_dir: /var/www/html volumes: - ./:/var/www/html ports: - "8000:8000" environment: - DB_HOST=mysql - DB_PORT=3306 - DB_DATABASE=laravel - DB_USERNAME=root - DB_PASSWORD=root depends_on: - mysql networks: - laravel-network mysql: image: mysql:8.0 container_name: laravel_mysql restart: unless-stopped environment: MYSQL_DATABASE: laravel MYSQL_ROOT_PASSWORD: root ports: - "3307:3306" volumes: - mysql_data:/var/lib/mysql networks: - laravel-network phpmyadmin: image: phpmyadmin:latest container_name: laravel_phpmyadmin restart: unless-stopped environment: PMA_HOST: mysql PMA_USER: root PMA_PASSWORD: root ports: - "8080:80" depends_on: - mysql networks: - laravel-network volumes: mysql_data: networks: laravel-network: driver: bridge ``` **`Dockerfile`** ```dockerfile FROM php:8.2-fpm WORKDIR /var/www/html RUN apt-get update && apt-get install -y \ build-essential \ libpng-dev \ libjpeg62-turbo-dev \ libfreetype6-dev \ zip \ unzip \ git \ curl \ && docker-php-ext-configure gd --with-freetype --with-jpeg \ && docker-php-ext-install pdo pdo_mysql gd bcmath \ && apt-get clean && rm -rf /var/lib/apt/lists/* COPY composer.json composer.lock ./ RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer && \ composer install --no-interaction --no-dev --prefer-dist COPY . . RUN chown -R www-data:www-data /var/www/html && \ chmod -R 755 /var/www/html && \ chmod -R 777 /var/www/html/storage /var/www/html/bootstrap/cache EXPOSE 8000 CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"] ``` 7. **Suba os containers:** ```bash docker-compose up -d --build ``` *Aguarde até que todos os serviços estejam `Up`.* 8. **Execute as Migrations:** ```bash docker-compose exec app php artisan migrate ``` *Isso criará a tabela `categories` no banco de dados.* ## 🏃 Como Rodar a Aplicação Após a instalação e configuração, a aplicação já estará rodando em segundo plano. * **Verificar status dos containers:** ```bash docker-compose ps ``` Todos os containers (`laravel_app`, `laravel_mysql`, `laravel_phpmyadmin`) devem estar com status `Up`. ## ✨ Funcionalidades Implementadas Este projeto implementa um CRUD completo para a entidade `Categorias`, permitindo as seguintes operações: * **Criar Categoria**: Adicionar novas categorias ao sistema. * **Listar Categorias**: Visualizar todas as categorias existentes. * **Editar Categoria**: Modificar os dados de uma categoria existente. * **Excluir Categoria**: Remover uma categoria do sistema. ## 🛣️ Endpoints/Rotas As rotas para as operações de categorias são definidas como um recurso RESTful: | Método HTTP | URL | Ação (Controller) | Descrição | | :---------- | :-------------------- | :-------------------- | :------------------------- | | `GET` | `/categories` | `CategoryController@index` | Lista todas as categorias | | `GET` | `/categories/create` | `CategoryController@create` | Exibe formulário de criação | | `POST` | `/categories` | `CategoryController@store` | Salva uma nova categoria | | `GET` | `/categories/{id}/edit` | `CategoryController@edit` | Exibe formulário de edição | | `PUT/PATCH` | `/categories/{id}` | `CategoryController@update` | Atualiza uma categoria | | `DELETE` | `/categories/{id}` | `CategoryController@destroy`| Exclui uma categoria | ## 💻 Tecnologias Utilizadas | Tecnologia | Versão | Descrição | | :-------------- | :----- | :------------------------------------------- | | **PHP** | 8.2 | Linguagem de programação backend | | **Laravel** | 11.x | Framework PHP para desenvolvimento web | | **Docker** | Latest | Plataforma para containers | | **Docker Compose** | Latest | Ferramenta para definir e rodar aplicações Docker multi-container | | **MySQL** | 8.0 | Sistema de gerenciamento de banco de dados relacional | | **phpMyAdmin** | Latest | Ferramenta web para administração MySQL | | **Composer** | Latest | Gerenciador de dependências PHP | | **Blade** | Latest | Motor de templates do Laravel | ## 🗄️ Banco de Dados A estrutura da tabela `categories` é a seguinte: ```sql CREATE TABLE `categories` ( `id` bigint unsigned NOT NULL AUTO_INCREMENT, `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL UNIQUE, `description` text COLLATE utf8mb4_unicode_ci, `created_at` timestamp NULL DEFAULT NULL, `updated_at` timestamp NULL DEFAULT NULL, PRIMARY KEY (`id`) ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
🧑‍💻 Como Usar a Aplicação
Acessar a Lista de Categorias: Abra seu navegador e acesse: http://localhost:8000/categories

Criar uma Categoria: Na página de listagem, clique no botão "Criar Categoria" e preencha o formulário.

Editar uma Categoria: Na lista, clique no link "Editar" ao lado da categoria desejada e atualize os dados.

Excluir uma Categoria: Na lista, clique no botão "Deletar" ao lado da categoria que deseja remover. Uma confirmação será solicitada.

🌐 Acessos Disponíveis
Aplicação Laravel: http://localhost:8000
CRUD de Categorias: http://localhost:8000/categories
phpMyAdmin: http://localhost:8080
Servidor: mysql
Usuário: root
Senha: root
✅ Boas Práticas Implementadas
Arquitetura MVC: Separação clara entre Model, View e Controller.
Eloquent ORM: Utilização do ORM do Laravel para interação com o banco de dados.
Validação de Dados: Implementação de validações no Controller para garantir a integridade dos dados.
Rotas RESTful: Definição de rotas seguindo os princípios REST para o recurso categories.
Migrations: Gerenciamento do esquema do banco de dados de forma versionada.
Containers Isolados: Cada serviço (PHP-FPM, MySQL, phpMyAdmin) roda em seu próprio container.
Variáveis de Ambiente: Uso do arquivo .env para configurações sensíveis e específicas do ambiente.
🚀 Próximos Passos para Evolução
Este projeto pode ser expandido com as seguintes funcionalidades:

Autenticação de Usuários: Implementar sistema de login e registro.
Interface de Usuário (UI): Melhorar o design com frameworks CSS (Bootstrap, Tailwind CSS).
Relacionamentos: Adicionar outras entidades (ex: Produtos) e estabelecer relacionamentos com Categorias.
Testes Automatizados: Escrever testes unitários e de integração para garantir a robustez da aplicação.
API RESTful: Criar endpoints de API para consumo por aplicações frontend ou mobile.
Paginação: Implementar paginação para a listagem de categorias.
🤝 Contribuições e Autor
Contribuições são bem-vindas! Sinta-se à vontade para abrir issues ou pull requests.

Autor: **Autor:** Moizes **Ano:** 2025
