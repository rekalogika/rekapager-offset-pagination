<?php

declare(strict_types=1);

/*
 * This file is part of rekalogika/rekapager package.
 *
 * (c) Priyadi Iman Nurcahyo <https://rekalogika.dev>
 *
 * For the full copyright and license information, please view the LICENSE file
 * that was distributed with this source code.
 */

namespace Rekalogika\Rekapager\Offset\Internal;

use Rekalogika\Contracts\Rekapager\NullPageInterface;
use Rekalogika\Contracts\Rekapager\PageableInterface;
use Rekalogika\Contracts\Rekapager\PageInterface;
use Rekalogika\Rekapager\Offset\Contracts\PageNumber;

/**
 *
 * @template TKey of array-key
 * @template T
 * @implements NullPageInterface<TKey,T>
 * @implements \IteratorAggregate<TKey,T>
 * @internal
 */
final readonly class NullOffsetPage implements NullPageInterface, \IteratorAggregate
{
    /**
     * @param PageableInterface<TKey,T> $pageable
     * @param int<1,max> $pageNumber
     * @param int<1,max> $itemsPerPage
     */
    public function __construct(
        private PageableInterface $pageable,
        private int $pageNumber,
        private int $itemsPerPage,
    ) {}

    #[\Override]
    public function withPageNumber(?int $pageNumber): static
    {
        $pageNumber ??= 1;
        if ($pageNumber < 1) {
            $pageNumber = 1;
        }

        return new self($this->pageable, $pageNumber, $this->itemsPerPage);
    }

    #[\Override]
    public function getIterator(): \Traversable
    {
        yield from [];
    }

    #[\Override]
    public function getPageIdentifier(): object
    {
        return new PageNumber($this->pageNumber);
    }

    #[\Override]
    public function getPageNumber(): int
    {
        return $this->pageNumber;
    }

    #[\Override]
    public function getPageable(): PageableInterface
    {
        return $this->pageable;
    }

    #[\Override]
    public function getItemsPerPage(): int
    {
        return $this->itemsPerPage;
    }

    #[\Override]
    public function getNextPage(): ?PageInterface
    {
        return null;
    }

    #[\Override]
    public function getPreviousPage(): ?PageInterface
    {
        return null;
    }

    #[\Override]
    public function getNextPages(int $numberOfPages): array
    {
        return [];
    }

    #[\Override]
    public function getPreviousPages(int $numberOfPages): array
    {
        return [];
    }

    #[\Override]
    public function count(): int
    {
        return 0;
    }
}
