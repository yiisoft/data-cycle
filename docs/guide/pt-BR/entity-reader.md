# Classe EntityReader

`EntityReader` permite passar com segurança consultas de seleção do repositório para o tempo de execução do usuário.
Por consulta selecionada, assumimos uma instância de `\Cycle\ORM\Select` ou `\Cycle\Database\Query\SelectQuery`.

Você precisa saber o seguinte sobre `EntityReader`:

- `EntityReader` implementa `IteratorAggregate`.
  Ele permite usar a instância `EntityReader` em `foreach`.
- Usando `EntityReader` você pode ajustar a consulta de seleção:
  - Adicione manualmente `Limit` e `Offset` ou usando `OffsetPaginator`
  - Especifique a classificação. Observe que a classificação `EntityReader`
     não substitui a classificação da consulta inicial, mas adiciona uma classificação no topo dela.
     Cada próxima chamada `withSort()` substitui as opções de classificação `EntityReader`.
  - Aplicar filtro. As condições de filtragem em `EntityReader` também não substituem as condições de filtragem
     na consulta inicial, mas adiciona condições a ela. Portanto, usando filtragem no `SeletecDataReader`
     você só pode refinar a seleção, mas NÃO expandir.
- `EntityReader` consulta o banco de dados somente quando você realmente lê os dados.
- Caso você esteja usando `read()`, `readOne()` ou `count()`, os dados serão armazenados em cache por `EntityReader`.
- O método `count()` retorna o número de elementos sem levar em consideração o limite e o deslocamento.
- Caso você queira evitar o cache, use `getIterator()`. Observe que se o cache já estiver lá, `getIterator()`
   vai usá-lo.

## Exemplos

Vamos implementar um repositório para trabalhar com tabela de artigos. Queremos um método para obter artigos públicos `findPublic()` mas
ue não retorne uma coleção de artigos prontos ou uma consulta selecionada. Em vez disso, retorne `EntityReader`:

```php
use Yiisoft\Data\Cycle\Data\Reader\EntityReader;
use Yiisoft\Data\Reader\DataReaderInterface;

class ArticleRepository extends \Cycle\ORM\Select\Repository
{
    /**
     * @return EntityReader
     */
    public function findPublic(): DataReaderInterface
    {
        return new EntityReader($this->select()->where(['public' => true]));
    }
}
```

Agora podemos usar `EntityReader` para paginação como o seguinte:

```php
/**
 * @var ArticleRepository $repository
 * @var \Yiisoft\Data\Cycle\Reader\EntityReade $articles
 */
$articles = $repository->findPublic();

// Offset and limit could be specified explicitly.
// Third page:
$pageReader = $articles->withLimit(10)->withOffset(20);

// Paginator could be used instead.
$paginator = new \Yiisoft\Data\Paginator\OffsetPaginator($articles);
$paginator->withPageSize(10)->withCurrentPage(3);


// Getting articles from EntityReader with caching:
foreach ($pageReader->read() as $article) {
    // ...
}
// Same without caching:
foreach ($pageReader as $article) {
    // ...
}

// Getting articles from paginator:
foreach ($paginator->read() as $article) {
    // ...
}
```

Agora consultaremos os 20 artigos publicados mais recentes e, em seguida, os 20 primeiros artigos.

```php
/**
 * @var \Yiisoft\Data\Cycle\Data\Reader\EntityReader $articles
 */

// The order of specifying parameters is not important so let's start with limit
$lastPublicReader = $articles->withLimit(20);

// Ordering is specified with Sort object:
$sort = \Yiisoft\Data\Reader\Sort::any()->withOrder(['published_at' => 'desc']);
// Note that EntityReader would not check Sort field correctness.
// Specifying non-existing fields would result in an error in Cycle code

// Don't forget about immutability when applying sorting rules
$lastPublicReader = $lastPublicReader->withSort($sort);

printf(
    "Last %d published articles of %d total:",
    count($lastPublicReader->read()),
    $lastPublicReader->count()
);
foreach ($lastPublicReader->read() as $article) {
    // ...
}

// Now let's obtain 20 first published articles
$sort = $lastPublicReader->getSort()->withOrder(['published_at' => 'asc']);

// Because of immutability Sort object won't be modified and current 
// sorting for $lastPublicReader will stay the same.
// To apply new sorting rules call withSort() once again:
$lastPublicReader = $lastPublicReader->withSort($sort);

printf(
    "First %d published articles of %d total:",
    count($lastPublicReader->read()),
    $lastPublicReader->count()
);
foreach ($lastPublicReader->read() as $article) {
    // ...
}
```

A classificação por meio de `EntityReader` não substitui a classificação na consulta inicial, mas adiciona mais a ela.
Se você precisar definir a classificação padrão em um método de repositório, mas quiser alterá-la em um controlador, você
pode fazer assim:

```php
use Yiisoft\Data\Cycle\Data\Reader\EntityReader;
use Yiisoft\Data\Reader\DataReaderInterface;
use Yiisoft\Data\Reader\Sort;

class ArticleRepository extends \Cycle\ORM\Select\Repository
{
    /**
     * @return EntityReader
     */
    public function findPublic(): DataReaderInterface
    {
        $sort = Sort::any()->withOrder(['published_at' => 'desc']);
        return (new EntityReader($this->select()->where(['public' => true])))->withSort($sort);
    }
}

// class SiteController ... {

function index(ArticleRepository $repository)
{
    $articlesReader = $repository
        // Getting EntityReader
        ->findPublic()
        // Applying new sorting
        ->withSort(Sort::any()->withOrder(['published_at' => 'asc']));
}
```
Você pode refinar as condições de consulta com filtros. Essas condições de filtragem são adicionadas às condições de consulta de seleção originais, mas NÃO as substituem.

```php
use Yiisoft\Data\Cycle\Data\Reader\EntityReader;
use Yiisoft\Data\Reader\DataReaderInterface;
use Yiisoft\Data\Reader\Filter\Equals;

class ArticleRepository extends \Cycle\ORM\Select\Repository
{
    public function findUserArticles(int $userId): DataReaderInterface
    {
        return (new EntityReader($this->select()->where('user_id', $userId)))
            //Adding filter by default - only public articles.
            
            ->withFilter(new Equals('public', '1'));
        // condition `public` = "1" doesnt replace `user_id` = "$userId"
    }
}
```

Use filtros do pacote [yiisoft/data](https://github.com/yiisoft/data) ou qualquer outro, tendo previamente escrito
os handlers(processors) apropriados para eles.
