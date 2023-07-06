  # IFCITEC 


## Reuniões TODAS as terças em algum auditório às 10h


#### Não deixe de ler o [Tutorial de navegação do Gitlab](https://about.gitlab.com/2016/03/08/gitlab-tutorial-its-all-connected/)

---

## Portas

### Site do ifcitec
localhost:8088

### Banco de dados
localhost:16543

---

## Regras de Commit

 Se possível (e quando necessário), o commit deve manter um corpo estrutural 
padronizado.
Utilizaremos o padrão utilizado em alguns projetos do Google (simplificado)

` TYPE(TARGET): DESCRIPTION. 
`

O `TARGET` é o alvo de modificações do commit. Pode ser um arquivo, ou um módulo da aplicação.

---

### Types Permitidos


* FEAT: 
Commits com adição de funcionalidade (Seja ela pronta ou em progresso);

* FIX: Um bugfix. 
Se houver uma Issue relacionada, deve-se fechá-la;

* REFACT: 
Algumas melhorias de código (Sejam elas de performance, de limpeza, ou de documentação);

---

## Lista de users


* @GatoImorrivel - Guilherme Viana
* @marcio.bigolin - Marcio Bigolin
* @sandro.silva - Sandro Silva
* @vinicius_raupp - Vinícius Raupp
* @vitor_bertoncello - Victor Beroncello

-Talvez possa pedir ajuda

* @muchsousa - Bruno Sousa
* @rafaellabueno - Rafaella Bueno

---

## Como rodar

Clonar o repositório e entrar na pasta  
`git clone https://gitlab.com/ifrscanoas/ifcitec.git && cd ifcitec`

Rodar o docker  
`docker-compose up --build`

---

### Caso apareça um erro no site da ifcitec
Uma das causas disso pode ser que as dependencias não estao  
instaladas no container do docker

Pegar o ID do container que esta rodando o laravel (o nome é ifcitec_web)  
`docker ps`

Entrar no container  
`docker exec -it [ID_CONTAINER] /bin/bash`

Rodar o script que instala as dependencias  
`./install-composer.sh`

---

### Como usar o dump do banco de dados

Pegar o ID do container do banco (o nome do container é 'ifcitec_postgres')  
`docker ps`

Entrar no container do banco de dados  
`docker exec -it [ID_CONTAINER] /bin/bash`

Passar o dump para o banco  
`su postgres`  
`psql ifcitec < /var/lib/dump_banco_ifcitec/dump.sql`

---

## Links úteis

[PGAdmin Documentation](https://www.pgadmin.org/docs/pgadmin4/latest/index.html)

[Laravel Documentation](https://laravel.com/docs/5.5/)

[Docker Documentation](https://docs.docker.com/)
