<?php

declare(strict_types=1);

namespace Utils\Collection;

use Stringable;
use Utils\Exception\DetailedException;
use Utils\Exception\ErrorCode;

/**
 * @template T of Stringable
 */
final class ItemNotExistsInCollectionException extends DetailedException
{
    /**
     * @param T $item
     */
    public function __construct($item)
    {
        parent::__construct(
            'Item not found',
            ErrorCode::ItemNotFoundInCollection,
            sprintf('This item "%s" was not found in the collection.', $item),
        );
    }
}
