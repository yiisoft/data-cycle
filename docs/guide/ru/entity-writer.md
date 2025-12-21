# EntityWriter

`EntityWriter` адаптирует `EntityManagerInterface` Cycle ORM к универсальному `Yiisoft\Data\Writer\DataWriterInterface`, чтобы вы могли единообразно сохранять или удалять сущности.

Запись и удаление сущностей можно выполнить следующим образом:

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
