### Aluno-Backend 

Este projeto compõe o Backend de uma aplicação Web e fornece um CRUD de aluno com
os campos: nome, endereço e foto.

### Funções e URLs
Registrar aluno: POST https://aluno-backend.herokuapp.com/index.php/student/student
Campos(multipart/form-data):
nome(String);
endereco(String);
foto(File).

Atualizar dados do aluno: POST https://aluno-backend.herokuapp.com/index.php/student/student/update
Campos(multipart/form-data):
id(int);
nome(String);
endereco(String);
foto(File).

Mostrar aluno: GET https://aluno-backend.herokuapp.com/index.php/student/student/:id

Listar aluno: GET https://aluno-backend.herokuapp.com/index.php/student/list_students

Deletar aluno: GET https://aluno-backend.herokuapp.com/index.php/student/delete/:id (Há navegadores que não aceitam a função delete).

### Tecnologias utilizadas
CodeIgniter: Framework de desenvolvimento. 
REST_Controller: Biblioteca que permite aplicar a arquitetura  REST em conjunto com CodeIgniter.
Amazon S3: Permite o armazenamento de dados na nuvem. 
Heroku: Plataforma utilizada para o deploy de aplicaçẽos.
ClearBd Mysql: Banco de dados em nuvem.

### Instalação e execução do programa 
1-Salve a aplicação em um diretório.
2-Crie um banco de dados no Mysql local ou na nuvem.
3-Preencha as variáveis do arquivo application/.env.development com os dados do seu banco de dado:

MYSQL_HOST;
MYSQL_DATABASE;
MYSQL_USER;
MYSQL_PASSWORD;
PORT;
BASE_URL.

3-Crie um uma instância no Amazon S3 e preencha as variáveis do arquivo application/.env.development
(Obs: algumas funcionalidades depende da integração Amazon S3)

AWS_ACCESS_KEY_ID;
AWS_SECRET_ACCESS_KEY;
AWS_DEFAULT_REGION; 
AWS_BUCKET.

4-Para concluir, vá até o diretório do projeto  via terminal (Ubuntu) e digite "php -S localhost:8080".

