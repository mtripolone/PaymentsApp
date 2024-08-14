## Introdução

    * Documentação da api Disponivel em http://localhost:8005/doc após configuração do projeto
    * Utlização deve ser realizada via Postman, Insomnia ou rota /doc com swagger open-api

## Rodando o Projeto Via Docker

### Requisitos do Sistema

*   Docker
*   Docker-compose
*   Make (caso não esteja instalado, siga as instruções abaixo)

### Instalando o Make

#### Ubuntu/Debian:

```
sudo apt-get install make
```

#### MacOs(via Homebrew):

```
brew install make
```

### Passo a Passo

1. Clonar o projeto e acessar a pasta do mesmo

```
git clone git@github.com:mtripolone/Payments.git && cd Payments
```

2. Configurar e iniciar o projeto usando o Makefile:

```
make start
```

3. Acessar no navegador:

```
http://localhost:8005
```

### Teste

* Para rodar o teste, pode utilizar o comando abaixo.

```
make test
```

By - Matheus Tripolone
# Payments
