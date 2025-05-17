<?php

declare(strict_types=1);

namespace App\Service;

use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use Symfony\Component\Filesystem\Exception\FileNotFoundException;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Service responsible for loading a Ciqual XLSX file and exposing its rows as JSON.
 *
 * Usage example (inside a controller or command):
 *   $json = $ciqualExtractorService->toJson($pathToFile);
 *   file_put_contents('ciqual.json', $json);
 */
final class CiqualExtractorService
{
    public function __construct(
        private readonly SerializerInterface $serializer,
    ) {
    }

    /**
     * Convert the given XLSX file to a JSON string.
     *
     * @param string $filePath absolute path to the Ciqual XLSX file
     *
     * @throws FileNotFoundException if the file cannot be found
     */
    public function toJson(string $filePath): string
    {
        $records = $this->extract($filePath);

        return $this->serializer->serialize($records, 'json');
    }

    /**
     * Extract the spreadsheet into an array of associative rows using chunked reading to limit memory usage.
     *
     * @return array<int, array<string, mixed>>
     */
    public function extract(string $filePath): array
    {
        if (!file_exists($filePath)) {
            throw new FileNotFoundException(sprintf('File "%s" does not exist.', $filePath));
        }

        // Prepare reader in data-only mode
        /** @var Xlsx $reader */
        $reader = IOFactory::createReader('Xlsx');
        $reader->setReadDataOnly(true);

        // Get worksheet dimensions without loading full spreadsheet
        $info = $reader->listWorksheetInfo($filePath)[0];
        $totalRows = $info['totalRows'];
        $totalColumns = $info['totalColumns'];
        $highestColumn = Coordinate::stringFromColumnIndex($totalColumns);

        // --- Read header row ---
        $reader->setReadFilter(new ChunkReadFilter(1, 1));
        $spreadsheet = $reader->load($filePath);
        $sheet = $spreadsheet->getActiveSheet();
        $headerRow = $sheet->rangeToArray('A1:' . $highestColumn . '1', null, true, true, true)[1];
        $normalizedHeaders = $this->normalizeHeaders($headerRow);

        // Free header sheet memory
        $spreadsheet->disconnectWorksheets();
        unset($spreadsheet, $sheet);

        $records = [];
        $chunkSize = 500;

        // --- Read data in chunks ---
        for ($startRow = 2; $startRow <= $totalRows; $startRow += $chunkSize) {
            $reader->setReadFilter(new ChunkReadFilter($startRow, $chunkSize));
            $spreadsheet = $reader->load($filePath);
            $sheet = $spreadsheet->getActiveSheet();

            $endRow = min($startRow + $chunkSize - 1, $totalRows);
            $rows = $sheet->rangeToArray(
                'A' . $startRow . ':' . $highestColumn . $endRow,
                null,
                true,
                true,
                true
            );

            foreach ($rows as $rowValues) {
                $record = [];
                foreach ($normalizedHeaders as $col => $key) {
                    $record[$key] = $rowValues[$col] ?? null;
                }
                $records[] = $record;
            }

            // Free chunk sheet memory
            $spreadsheet->disconnectWorksheets();
            unset($spreadsheet, $sheet);
        }

        return $records;
    }

    /**
     * Turn spreadsheet headings into snake_case keys.
     *
     * @param array<string, string|null> $headerRow
     *
     * @return array<string, string>
     */
    private function normalizeHeaders(array $headerRow): array
    {
        $headers = [];

        foreach ($headerRow as $col => $cell) {
            $headers[$col] = $this->slugify((string) $cell);
        }

        return $headers;
    }

    /**
     * Slugifies a string: lowercase, non-alphanumeric replaced by '_', collapse underscores.
     */
    private function slugify(string $value): string
    {
        $value = preg_replace('/[^a-z0-9]+/i', '_', strtolower(trim($value)));

        return trim((string) preg_replace('/_+/', '_', $value), '_');
    }
}
