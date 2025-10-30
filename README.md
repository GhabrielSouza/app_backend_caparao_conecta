Backend Caparaó Conecta (API Laravel)
Este diretório contém a aplicação backend para o projeto Caparaó Conecta, desenvolvida com o framework Laravel. A aplicação serve como uma API RESTful para gerir utilizadores (candidatos e empresas), vagas, candidaturas e outras funcionalidades da plataforma.

Funcionalidades Principais
Autenticação Segura: Sistema de login, registo e recuperação de senha utilizando o Laravel Sanctum para autenticação de SPA (Single Page Application) baseada em cookies.

Gestão de Perfis: Endpoints para criar, ler, atualizar e apagar perfis de candidatos e empresas.

Sistema de Vagas: CRUD completo para vagas, incluindo publicação, edição, finalização e prorrogação.

Matching de Candidatos: Lógica para filtrar e recomendar vagas com base na área de atuação.

Sistema de Notificações: Event-driven, para notificar utilizadores sobre novas candidaturas, vagas recomendadas, etc.

Upload de Ficheiros: Rota segura para upload de imagens de perfil.

Tarefas Agendadas (Scheduler): Processo automático para finalizar vagas expiradas.

Requisitos
PHP >= 8.2

Composer

MySQL >= 8.0

Docker e Docker Compose (para o ambiente de produção/homologação)

Instalação e Execução com Docker (Ambiente de Produção/Homologação)
Esta é a forma recomendada para correr a aplicação num ambiente de produção ou homologação, garantindo consistência e isolamento.

1. Configurar o Ficheiro de Ambiente
   Antes de iniciar, é necessário criar o ficheiro .env para o backend.

# Na pasta raiz do projeto completo (ex: caparaoconecta1/)

# Copie o ficheiro de exemplo para criar o seu ficheiro de configuração local

cp backend/.env.example backend/.env

Abra o ficheiro backend/.env e configure as variáveis de ambiente, especialmente as de conexão com a base de dados (DB_DATABASE, DB_USERNAME, DB_PASSWORD), que devem corresponder às que estão definidas no docker-compose.yml.

2. Construir e Iniciar os Contentores
   Na pasta raiz do projeto (onde está o docker-compose.yml), execute os seguintes comandos:

# 1. Construir as imagens do Docker

docker-compose build

# 2. Iniciar todos os serviços em segundo plano

docker-compose up -d

3. Finalizar a Instalação (Dentro do Contentor)
   Após os contentores estarem a correr, precisamos de executar os comandos do Laravel.

# 1. Gerar a chave da aplicação

docker-compose exec app_backend php artisan key:generate

# 2. Executar as migrações (criar as tabelas) e os seeders (popular os dados iniciais)

docker-compose exec app_backend php artisan migrate --seed

# 3. Criar o link simbólico para o storage (para as imagens de perfil)

docker-compose exec app_backend php artisan storage:link

Acesso
Frontend da Aplicação: http://localhost:4200

API do Backend: http://localhost:8000

Desenvolvimento Local (Sem Docker)
Para desenvolver e testar o backend localmente, siga estes passos.

1. Navegar para a Pasta do Backend
   cd backend

2. Instalar Dependências
   composer install

3. Configurar o Ficheiro de Ambiente
   cp .env.example .env

Edite o ficheiro .env com as configurações da sua base de dados local.

4. Gerar a Chave da Aplicação
   php artisan key:generate

5. Executar as Migrações e Seeders
   php artisan migrate --seed

6. Iniciar o Servidor de Desenvolvimento
   php artisan serve

A sua API estará agora a correr em http://localhost:8000.
