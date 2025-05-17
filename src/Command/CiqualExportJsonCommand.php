<?php

declare(strict_types=1);

namespace App\Command;

use App\Service\ChunkReadFilter;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'ciqual:export-json',
    description: 'Extracts data from a Ciqual XLSX and streams it as JSON with minimal memory footprint.'
)]
class CiqualExportJsonCommand extends Command
{
    private const CHUNK_SIZE = 500;

    protected function configure(): void
    {
        $this
            ->addArgument('input-file', InputArgument::REQUIRED, 'Path to the Ciqual XLSX file')
            ->addArgument('output-file', InputArgument::OPTIONAL, 'Path to write the JSON output (defaults to stdout)');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $inputFilePath = $input->getArgument('input-file');
        $outputFilePath = $input->getArgument('output-file');

        if (!is_file($inputFilePath)) {
            $io->error(sprintf('Input file "%s" not found.', $inputFilePath));

            return Command::FAILURE;
        }

        // Load only meta information to avoid loading the entire workbook
        /** @var Xlsx $readerInfo */
        $readerInfo = IOFactory::createReader('Xlsx');
        $worksheetInfo = $readerInfo->listWorksheetInfo($inputFilePath)[0];
        $totalRows = $worksheetInfo['totalRows'];
        $totalColumns = $worksheetInfo['totalColumns'];
        $worksheetName = $worksheetInfo['worksheetName'];
        $highestColumnLetter = Coordinate::stringFromColumnIndex($totalColumns);

        $io->title('Ciqual JSON Export');
        $io->text(sprintf('Reading data from: %s (sheet: %s)', $inputFilePath, $worksheetName));

        $dataRowCount = max(0, $totalRows - 1); // Exclude header
        $io->progressStart($dataRowCount);

        /** ---------------------- Read header row ---------------------- */
        $headerReader = IOFactory::createReader('Xlsx');
        $headerReader->setReadDataOnly(true)
            ->setLoadSheetsOnly([$worksheetName])
            ->setReadFilter(new ChunkReadFilter(1, 1)); // First row only

        $headerSpreadsheet = $headerReader->load($inputFilePath);
        $headerSheet = $headerSpreadsheet->getActiveSheet();
        $rawHeaderValues = $headerSheet->rangeToArray("A1:{$highestColumnLetter}1", null, true, true, true)[1];
        $headerKeys = array_map([self::class, 'slugify'], $rawHeaderValues);

        // Free memory used by header workbook
        $headerSpreadsheet->disconnectWorksheets();
        unset($headerSpreadsheet, $headerSheet);

        /** -------------------- Prepare output stream ------------------ */
        $outputHandle = $outputFilePath ? fopen($outputFilePath, 'w') : STDOUT;
        if (false === $outputHandle) {
            $io->error(sprintf('Unable to open "%s" for writing.', $outputFilePath));

            return Command::FAILURE;
        }

        fwrite($outputHandle, "[\n"); // Begin JSON array
        $isFirstRecord = true;

        /* ---------------- Stream data in small chunks --------------- */
        for ($batchStartRow = 2; $batchStartRow <= $totalRows; $batchStartRow += self::CHUNK_SIZE) {
            $batchSize = min(self::CHUNK_SIZE, $totalRows - $batchStartRow + 1);

            $batchReader = IOFactory::createReader('Xlsx');
            $batchReader->setReadDataOnly(true)
                ->setLoadSheetsOnly([$worksheetName])
                ->setReadFilter(new ChunkReadFilter($batchStartRow, $batchSize));

            $batchSheet = $batchReader->load($inputFilePath)->getActiveSheet();
            $batchRange = "A{$batchStartRow}:{$highestColumnLetter}" . ($batchStartRow + $batchSize - 1);
            $rows = $batchSheet->rangeToArray($batchRange, null, true, true, true);

            foreach ($rows as $row) {
                $record = [];
                foreach ($headerKeys as $columnLetter => $key) {
                    $record[$key] = $row[$columnLetter] ?? null;
                }

                if (!$isFirstRecord) {
                    fwrite($outputHandle, ",\n"); // Comma before every record except the first
                }
                fwrite($outputHandle, json_encode($record, JSON_THROW_ON_ERROR));
                $isFirstRecord = false;

                $io->progressAdvance();
            }

            // Free memory for this batch
            $batchSheet->disconnectCells();
            unset($batchSheet);
            gc_collect_cycles();
        }

        fwrite($outputHandle, "\n]\n");
        if ($outputFilePath) {
            fclose($outputHandle);
            $io->success(sprintf('JSON successfully written to %s', $outputFilePath));
        }

        $io->progressFinish();

        return Command::SUCCESS;
    }

    private static function slugify(string $value): string
    {
        $slug = preg_replace('/[^a-z0-9]+/i', '_', strtolower(trim($value)));

        return trim((string) preg_replace('/_+/', '_', $slug), '_');
    }
}
