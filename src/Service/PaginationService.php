<?php
declare(strict_types=1);
namespace App\Service;

use Doctrine\ORM\Tools\Pagination\CountWalker;
use Doctrine\ORM\QueryBuilder as DoctrineQueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator as DoctrinePaginator;
use Traversable;

class PaginationService
{
    public const PAGE_SIZE = 6;
    private const PAGE = 1;

    private int $currentPage;
    private Traversable $results;
    private int $numberResults;

    public function __construct(private DoctrineQueryBuilder $queryBuilder, private int $limit = self::PAGE_SIZE) {}

    public function pagination(int $page = self::PAGE): static
    {
        $this->currentPage = max(1, $page);

        $query = $this->queryBuilder
            ->setFirstResult($this->limit * ($this->currentPage - 1))
            ->setMaxResults($this->limit)
            ->getQuery();

        if (0 === \count($this->queryBuilder->getDQLPart('join'))) {
            $query->setHint(CountWalker::HINT_DISTINCT, false);
        }

        $paginator = new DoctrinePaginator($query, true);

        $useOutputWalkers = \count($this->queryBuilder
                ->getDQLPart('having') ?: []) > 0;

        $paginator->setUseOutputWalkers($useOutputWalkers);

        try {
            $this->results = $paginator->getIterator();
        } catch (\Exception $exception) {}
        $this->numberResults = $paginator->count();

        return $this;
    }

    public function currentPage(): int
    {
        return $this->currentPage;
    }

    public function lastPage(): int
    {
        return (int) ceil($this->numberResults / $this->limit);
    }

    public function total(): int
    {
        return $this->limit;
    }

    public function previousPage(): int
    {
        return max(1, $this->currentPage - 1);
    }

    public function hasToPaginate(): bool
    {
        return $this->numberResults > $this->limit;
    }

    public function results(): Traversable
    {
        return $this->results;
    }
}