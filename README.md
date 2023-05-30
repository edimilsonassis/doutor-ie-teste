# API RESTful de Cadastro de Livros e Índices/Sumário

Esta API permite o cadastro de livros e seus respectivos índices/sumários. Apenas usuários logados que são os publicadores dos livros têm permissão para realizar o cadastro.

## Testes

[Link para o Postman](https://elements.getpostman.com/redirect?entityId=17260296-d93c6ab6-ba63-428d-9948-3c0008f2367a&entityType=collection)

## Tabelas

### Usuários

Tabela padrão fornecida pelo Laravel.

### Livros

Tabela responsável pelo armazenamento das informações dos livros.

| Campo                  | Tipo     | Descrição                           |
|------------------------|----------|-------------------------------------|
| id                     | Int      | Identificador único do livro         |
| usuario_publicador_id  | Int      | ID do usuário publicador do livro    |
| titulo                 | String   | Título do livro                      |

### Índices

Tabela responsável pelo armazenamento das informações dos índices/sumários dos livros.

| Campo           | Tipo     | Descrição                            |
|-----------------|----------|--------------------------------------|
| id              | Int      | Identificador único do índice         |
| livro_id        | Int      | ID do livro ao qual o índice pertence |
| indice_pai_id   | Int      | ID do índice pai (quando houver)      |
| titulo          | String   | Título do índice                      |
| pagina          | Int      | Página do livro associada ao índice   |

## Rotas

### POST v1/auth/token

Recupera o token de acesso do usuário para poder acessar as outras rotas.

### GET v1/livros

Listar livros.

#### Query Params

- titulo: Filtra os livros pelo título.
- titulo_do_indice: Retorna os livros que possuem o índice com o título pesquisado, juntamente com seus ascendentes, quando houver.

### POST v1/livros

Cadastra um novo livro e valida a estrutura dos índices.

#### Request Body

```json
{
  "titulo": "Título do Livro",
  "indices": [
    {
      "indice_pai_id": null,
      "titulo": "Capítulo 1",
      "pagina": 10
    },
    {
      "indice_pai_id": 1,
      "titulo": "Seção 1.1",
      "pagina": 15
    },
    {
      "indice_pai_id": 1,
      "titulo": "Seção 1.2",
      "pagina": 20
    }
  ]
}
```

### POST v1/livros/{livroId}/importar-indices-xml

Importa índices em formato XML para um livro específico.

## Importação de XML

`
<indice>
    <item pagina="10" titulo="Capítulo 1">
        <item pagina="15" titulo="Seção 1.1" />
        <item pagina="20" titulo="Seção 1.2">
            <item pagina="25" titulo="Subseção 1.2.1" />
            <item pagina="30" titulo="Subseção 1.2.2" />
        </item>
    </item>
    <item pagina="35" titulo="Capítulo 2">
        <item pagina="40" titulo="Seção 2.1" />
        <item pagina="45" titulo="Seção 2.2" />
    </item>
    <item pagina="50" titulo="Capítulo 3" />
</indice>
`
