# Desafio Bolton 

## Intro

O Desafio Bolton foi construído com o objetivo de demonstrar a qualidade do código para solucionar o problema proposto. O problema proposto consiste em desenvolver uma aplicação backend, tendo como requisitos: 

- Integrar com a API da arquivei as notas recebidas
- Gravar dados de cada nota(id, total) em banco de dados relacional
- Criar um endpoint para consulta de valor de uma nota, dado um id(chave de acesso)

## Tecnologias utilizadas

- Docker, Docker Compose
- PHP, Laravel, Behat, PHPUnit, Guzzle
- Postgresql
- Nginx

## Instalação

### Pré-requisitos
Para instalar essa aplicação é necessário ter instalado: composer, Docker, Docker Compose. 
O projeto foi criado com:
- Docker version 19.03.5, build 633a0ea838
- docker-compose version 1.25.0, build 0a186604

### Etapas
Para instalar a aplicação na máquina local siga os seguintes passos:

1. git clone https://github.com/gustavosooeiro/bolton.git

2. composer install

3. chmod -R 777 ./storage

4. mkdir .docker/dbdata

5. docker-compose up -d --build

6. Acesse: http://localhost:8000/
Aplicação deve apresentar uma tela do Laravel!

7. Para finalizar as configurações, execute: 
    - docker-compose exec web sh

Agora você está dentro do container WEB. Gerencie sua aplicação por aqui.

8. Dentro do container WEB, execute: 
    - php artisan migrate  #este comando criará as tabelas no banco de dados
    - php artisan testdb:make #este comando criará o seu banco de testes

9. Sua aplicação deve estar rodando perfeitamente! Sim?

### Para rodas os testes

1. Dentro do container WEB: docker-compose exec web sh

2. Execute:
    - /vendor/bin/behat
    - /vendor/phpunit/phpunit/phpunit

    Estes dois rodam testes unitários e comportamentais do sistema.

## Uso

Essa aplicação possui duas funcionalidades:

    - Integração:
        A integração faz a leitura na API da Arquivei das notas recebidas e faz a gravação 
        no banco de dados de todas as notas.
        - Acessível em: http://localhost:8000/api/v1/nfes

    - Consulta de valor de NFE:
        A consulta do valor da nota recebe a Chave de Acesso da nota como parâmetro e retorna o valor total da nota.
        - Acessível em: http://localhost:8000/api/v1/nfe/{accessKey}

