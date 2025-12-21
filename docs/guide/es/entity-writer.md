# EntityWriter

`EntityWriter` adapta `EntityManagerInterface` de Cycle ORM a la interfaz genérica `Yiisoft\Data\Writer\DataWriterInterface`
para que puedas persistir o eliminar entidades de manera uniforme.

La escritura y eliminación de entidades puede hacerse de la siguiente manera:

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
