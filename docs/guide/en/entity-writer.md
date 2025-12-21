# EntityWriter

`EntityWriter` adapts Cycle ORM's `EntityManagerInterface` to the generic `Yiisoft\Data\Writer\DataWriterInterface`
so you can persist or delete entities in a uniform way.

Writing and deleting entities could be done in the following way:

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
