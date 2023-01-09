# Url Checker

### Descrição 
Está é uma aplicação de cadastro e análise de urls. Nela é possível realizar login e ter acesso a uma interface para cadastro de urls no banco de dados e assincronamente a aplicação no servidor irá consultar a url e retornar informações.

### Banco de dados
Para utilização da aplicação é necessário possuir instalado e rodando o banco de dados Mysql e o servidor Apache. A localização padrão está configurada para `localhost:3306`. Também é necessário que a database configurada esteja criada no banco de dados.

### Informações
```
database="desafio"
host="localhost"
port="3306"
user="root"
password=""
```

### Passo-a-passo
1. Instalar o Apache caso não esteja instalado. [Página do Apache](https://www.apache.org/)
2. Instalar o Mysql caso não esteja instalado. [Recomendação para Windows](https://www.apachefriends.org/pt_br/download.html)
3. Acessar o banco de dados e criar uma database com o nome **desafio**.
4. Criar um usuário com as permissões suficientes de acesso a database criada.
5. Clonar este repositório para o ambiente local.
6. Dentro da pasta raiz do repositório clonado rodar o comando `composer install` para instalar as dependências.
