<?php
declare(strict_types=1);

namespace Xervice\Elasticsearch\Business\Collection;

use Xervice\Elasticsearch\Dependency\Plugin\IndexProviderInterface;

class IndexCollection implements \Iterator, \Countable
{
    /**
     * @var \Xervice\Elasticsearch\Dependency\Plugin\IndexProviderInterface[]
     */
    private $collection;

    /**
     * @var int
     */
    private $position;

    /**
     * Collection constructor.
     *
     * @param \Xervice\Elasticsearch\Dependency\Plugin\IndexProviderInterface[] $collection
     */
    public function __construct(array $collection)
    {
        foreach ($collection as $validator) {
            $this->add($validator);
        }
    }

    /**
     * @param \Xervice\Elasticsearch\Dependency\Plugin\IndexProviderInterface $validator
     */
    public function add(IndexProviderInterface $validator): void
    {
        $this->collection[] = $validator;
    }

    /**
     * @return \Xervice\Elasticsearch\Dependency\Plugin\IndexProviderInterface
     */
    public function current(): IndexProviderInterface
    {
        return $this->collection[$this->position];
    }

    public function next(): void
    {
        $this->position++;
    }

    /**
     * @return int
     */
    public function key(): int
    {
        return $this->position;
    }

    /**
     * @return bool
     */
    public function valid(): bool
    {
        return isset($this->collection[$this->position]);
    }

    public function rewind(): void
    {
        $this->position = 0;
    }

    /**
     * @return int
     */
    public function count(): int
    {
        return \count($this->collection);
    }
}