<?php

declare(strict_types=1);

namespace App\Service;

use PhpOffice\PhpSpreadsheet\Reader\IReadFilter;

/**
 * Read filter that limits PhpSpreadsheet to a specific set of rows.
 */
class ChunkReadFilter implements IReadFilter
{
    public function __construct(
        private readonly int $startRow,
        private readonly int $rowCount,
    ) {
    }

    public function readCell($columnAddress, $row, $worksheetName = ''): bool
    {
        return $row >= $this->startRow && $row < ($this->startRow + $this->rowCount);
    }
}
