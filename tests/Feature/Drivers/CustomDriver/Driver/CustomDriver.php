<?php

declare(strict_types=1);

namespace Rawilk\Printing\Tests\Feature\Drivers\CustomDriver\Driver;

use Illuminate\Support\Collection;
use Rawilk\Printing\Contracts\Driver;
use Rawilk\Printing\Contracts\Printer;
use Rawilk\Printing\Contracts\PrintJob;
use Rawilk\Printing\Contracts\PrintTask;
use Rawilk\Printing\Tests\Feature\Drivers\CustomDriver\Driver\Entity\Printer as CustomDriverPrinter;
use Rawilk\Printing\Tests\Feature\Drivers\CustomDriver\Driver\PrintTask as CustomDriverPrintTask;

final class CustomDriver implements Driver
{
    public string $apiKey;

    public function __construct(string $apiKey)
    {
        $this->apiKey = $apiKey;
    }

    public function newPrintTask(): PrintTask
    {
        return new CustomDriverPrintTask;
    }

    public function printer($printerId = null): ?Printer
    {
        return $this->printers()
            ->filter(fn (CustomDriverPrinter $p) => $p->id() === $printerId)
            ->first();
    }

    public function printers(int|null $limit = null, int|null $offset = null, string|int $dir = null): Collection
    {
        return collect($this->customPrinters())
            ->map(fn (array $data) => new CustomDriverPrinter($data))
            ->values();
    }

    protected function customPrinters(): array
    {
        return [
            [
                'id' => 'printer_one',
                'name' => 'Printer One',
                'status' => 'online',
                'capabilities' => [],
                'description' => 'Printer one description',
            ],
            [
                'id' => 'printer_two',
                'name' => 'Printer Two',
                'status' => 'offline',
                'capabilities' => [],
                'description' => 'Printer two description',
            ],
        ];
    }

    public function printJobs(int|null $limit = null, int|null $offset = null, string|null $dir = null): Collection
    {
        return collect();
    }

    public function printJob($jobId = null): null|PrintJob
    {
        return null;
    }

    public function printerPrintJobs($printerId, int|null $limit = null, int|null $offset = null, string|null $dir = null): Collection
    {
        return collect();
    }

    public function printerPrintJob($printerId, $jobId): null|PrintJob
    {
        return null;
    }
}
