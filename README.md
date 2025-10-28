# 🧾 CRUD de Fornecedores

Projeto **CRUD de Fornecedores** permitindo cadastrar e gerenciar **Pessoas Físicas (PF)** e **Pessoas Jurídicas (PJ)**.
Desenvolvido com **Laravel 12**, utilizando o **AdminLTE** como tema administrativo e **MySQL** como banco de dados.
Idealizado como teste prático para avaliação técnica.

---

## 🚀 Tecnologias Utilizadas

* **PHP** `8.2`
* **Laravel** `12`
* **Laravel UI** (autenticação e telas de login)
* **AdminLTE** (painel administrativo)
* **Vite** (bundler de assets frontend)
* **Composer** (gerenciador de dependências PHP)
* **Node.js + npm** (build dos assets frontend)
* **MySQL**
* **Laragon** (ambiente de desenvolvimento local **recomendado**)

---

## 🧰 Pré-requisitos

Antes de iniciar, certifique-se de que as seguintes ferramentas estão instaladas em sua máquina:

1.  **Laragon:** Instalação completa (já inclui PHP, Composer e MySQL).
2.  **Node.js & npm:** Para gerenciar e compilar os assets (CSS/JS).
3.  **Git:** Para clonar o repositório.

---

## 🛠️ Guia de Instalação e Execução

Siga a ordem dos comandos para configurar e rodar o projeto localmente.

* Baixe e instale o Laragon (inclui PHP, Composer, MySQL e servidor web)
* Instale o Node.js com npm no computador
* Clone o projeto e acesse a pasta
* Renomeie o arquivo .env-example para .env
* Abra o Laragon e inicie todos os serviços (Apache, MySQL)
* Execute o comando composer setup - este comando executa automaticamente:
    * composer install (instala dependências PHP)
    * php artisan key:generate (gera chave da aplicação)
    * php artisan migrate (executa migrações do banco)
* Execute php artisan db:seed para popular as tabelas com dados mockados
* Execute npm install para instalar dependências frontend
* Execute npm run build para compilar os assets
* Executar o comando php artisan adminlte:install, e quando apos a instalacao for concluida e a pergunta de substituicao de arquivos aparecer como : "Config file was already published. Want to replace it?", selecionar a opção 'no'.
* Inicie o servidor com php artisan serve

## Credenciais de teste:
* Email: teste@admin.com
* Senha: 123456



