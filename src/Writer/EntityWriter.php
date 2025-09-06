<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Writer;

use Cycle\ORM\EntityManagerInterface;
use Throwable;
use Yiisoft\Data\Writer\DataWriterInterface;

final class EntityWriter implements DataWriterInterface
{
    public function __construct(private EntityManagerInterface $entityManager) 
    {
    }

    /**
     * @throws Throwable
     */
    #[\Override]
    public function write(iterable $items): void
    {
        foreach ($items as $entity) {
            if (!is_object($entity)) {
                throw new \InvalidArgumentException('Entity must be an object.');
            }
            $this->entityManager->persist($entity);
        }
        $this->entityManager->run();
    }

    #[\Override]
    public function delete(iterable $items): void
    {
        foreach ($items as $entity) {
            if (!is_object($entity)) {
                throw new \InvalidArgumentException('Entity must be an object.');
            }
            $this->entityManager->delete($entity);
        }
        $this->entityManager->run();
    }
}
