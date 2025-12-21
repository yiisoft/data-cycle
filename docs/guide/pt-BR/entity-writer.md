# EntityWriter

`EntityWriter` adapta o `EntityManagerInterface` do Cycle ORM à interface genérica `Yiisoft\Data\Writer\DataWriterInterface`
para que você possa persistir ou excluir entidades de forma uniforme.

A escrita e a exclusão de entidades podem ser feitas da seguinte forma:

```php
use Cycle\ORM\EntityManagerInterface;
use Yiisoft\Data\Cycle\Writer\EntityWriter;

final class ArticleRepository
{
    public function __construct(
        private EntityWriter $writer,
    ) {}

    public function saveAll(iterable $articles): void
    {
        $this->writer->write($articles);
    }
    
    public function removeAll(iterable $articles): void
    {
        $this->writer->delete($articles);
    }
}
```
