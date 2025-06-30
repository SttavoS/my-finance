# My Finance

## Descrição do Projeto
Este projeto é uma aplicação moderna desenvolvida com Symfony 7.3 no backend e Vue.js 3 no frontend, oferecendo uma arquitetura robusta e escalável para desenvolvimento web.

## Arquitetura Utilizada
O projeto segue uma arquitetura moderna de aplicação web dividida em duas camadas principais:

### Backend
- API REST desenvolvida com Symfony 7.3
- Arquitetura em camadas seguindo os princípios do Domain-Driven Design (DDD)
- Sistema de persistência com Doctrine ORM
- Gerenciamento de dependências via Composer

### Frontend
- Single Page Application (SPA) desenvolvida com Vue.js 3
- Sistema de rotas com Vue Router
- Interface de usuário com PrimeVue
- TypeScript para maior segurança e manutenibilidade do código

## Tecnologias

### Backend
- PHP 8.4
- Symfony 7.3
- Doctrine ORM 3.4
- PostgreSQL 16

### Frontend
- Vue.js 3.5
- TypeScript 5.8
- Vue Router 4.5
- PrimeVue 4.3
- Vite 6.2

## Configuração e Inicialização

### Pré-requisitos
- PHP 8.4
- Composer
- Node.js (versão LTS recomendada)
- npm
- Docker e Docker Compose

### Passos para Configuração

1. **Clone o repositório**

    ```bash
     git clone [URL_DO_REPOSITÓRIO] cd [NOME_DO_PROJETO]
    ```

2. **Configure as variáveis de ambiente**  
    ```bash
    cd server
    cp .env.example .env
    ```
    Edite o arquivo `.env` com suas configurações locais

3. **Instale as dependências do Backend**

    ```bash
    cd server
    composer install
    ```

4. **Instale as dependências do Frontend**

    ```bash
    cd web
    npm install
    ```

5. **Inicie os containers Docker**

    ```bash
    docker-compose up -d
    ```

6. **Configure o banco de dados**

    ```bash
    php bin/console doctrine:database:create 
    php bin/console doctrine:migrations:migrate
    ```
7. **Inicie o servidor de desenvolvimento**
 
    Para o Backend:
    ```bash
    php bin/console server:start
    ``` 
    
    Para o Frontend:
    ```bash
    npm run dev
    ``` 

A aplicação estará disponível em:
- Backend: `http://localhost:8000`
- Frontend: `http://localhost:5173`
