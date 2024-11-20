## Sistema de gerencimento de biblioteca

### Introdução

Olá!

Aqui está o projeto desenvolvido para a fase de testes do processo seletivo. O sistema foi construído com PHP e MySQL, utilizando o framework Laravel, conforme as instruções fornecidas.

O objetivo do projeto foi criar um sistema simples para o gerenciamento de uma biblioteca, atendendo aos seguintes requisitos:

CRUD de Usuários: Onde é possível cadastrar, editar, visualizar e excluir usuários da biblioteca, com campos obrigatórios como Nome, Email e Número de Cadastro.

CRUD de Livros: Onde é possível realizar as mesmas operações para os livros da biblioteca, incluindo os campos Nome, Autor e Número de Registro.

Classificação dos Livros por Gênero: Os livros podem ser classificados em diferentes gêneros, como Ficção, Romance, Fantasia, Aventura, etc.

Funcionalidade de Empréstimo: Permite cadastrar um novo empréstimo, associando um livro a um usuário, com data de devolução. Também inclui a opção de marcar o empréstimo como Atrasado ou Devolvido.

O código segue a estrutura recomendada e está acompanhado de um arquivo README com instruções para rodar o projeto em um ambiente local. O repositório está disponível publicamente para avaliação.

Fico à disposição para qualquer dúvida ou explicação adicional sobre o projeto.

Obs: Removi a informação de situação do livro, pois ela já é obtida diretamente da tabela de empréstimos, evitando redundância no sistema.

### Ferramentas utilizadas

Para conseguir desenvolver o projeto eu utilizei diversar ferramentas para me auxiliar, dentre elas as principais foram:

- PHP 8.2
- Laravel 11
- mysql 8
- Node 18
- laravel vite para compilação dos arquivos
- bootstrap 5 (para estilização do front-end)

## Como começar

Para inciar o sistema é necessário configurar na máquina as tecnologias listadas anteriormente, após a instalção é necessário criar um novo banco de dados com o nome 'library-rent' e senha 'password'. Após isso basta fazer o download do repositório e rodar os seguintes comandos após o download:

- composer install (instala as dependências do php)
- npm install (instala os pacotes do npm)
- php artisan migrate:fresh --seed (cria as tabelas no banco de dados e popula elas com o Seeder)
- npm run build (Compila os arquivos css e js)
- php artisan serve (Roda o projeto, por padrão na porta 8000)

