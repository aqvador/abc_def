<?php


namespace App\Share\Handlers;

use App\Infrastructure\Contracts\Repositories\AbcDefGmtRepositoryInterface;
use App\Infrastructure\Contracts\Repositories\AbcDefRepositoryInterface;
use App\Share\Contracts\LoadAbcDefInterface;
use App\Share\entyties\AbcDef;
use App\Share\entyties\AbcDefGmts;
use App\Share\Services\AbcDefNormalizer;
use Psr\Log\LoggerInterface;

class LoadAbcDefHandler implements LoadAbcDefInterface
{
    private AbcDefGmts $gmt;
    private const MAX_SAVE_COUNT = 1000;
    private array $items = [];
    private int $saveLines = 0;
    private int $errorLines = 0;

    public function __construct(
        private AbcDefRepositoryInterface    $repositoryNumbers,
        private AbcDefGmtRepositoryInterface $repositoryGmt,
        private LoggerInterface              $logger,
        private AbcDefNormalizer             $normalizer,
    )
    {
        $this->gmt = $this->repositoryGmt->getAllItems();

    }

    public function handle(string $parseUrl): void
    {
        $currentVersion = $this->repositoryNumbers->getCurrentVersion();

        $links = $this->getLinksFromUrl($parseUrl);

        foreach ($links as $link) {
            $this->loadDataFromCsv($link, $currentVersion + 1);
        }
        //сохраним остатки
        $this->saveItems();

        $dropVersion = $this->errorLines > 0 ? $currentVersion + 1 : $currentVersion;

        $this->repositoryNumbers->deleteVersion($dropVersion);

        if ($this->errorLines) {
            $this->logger->error('load abc def', ['error_lines' => $this->errorLines]);
        }

        // запишем что вышло в лог
        $this->logger->info('abc def done', ['save_lines' => $this->saveLines, 'error_lines' => $this->errorLines]);
    }

    /**
     * @param string $linkCsv
     */
    private function loadDataFromCsv(string $linkCsv, int $version): void
    {
        try {
            $file = new \SplFileObject($linkCsv, '', context: stream_context_create($this->getRequestOptions()));
            $file->fgets();
            while (!$file->eof()) {
                try {
                    $line = $file->fgetcsv(';');

                    $region = $this->normalizer->buildRegion($line[5]);
                    $gmt = $this->gmt->searchGmtByRegion($region->getRegion());
                    // Если не смогли определить GMT региона, пропускаем строку
                    if (is_null($gmt)) {
                        $this->errorLines++;
                        $this->logger->error('search GMT by region', ['region' => $region, 'line' => $line]);
                        continue;
                    }

                    $item = new AbcDef(
                        (int)$line[0],
                        (int)$line[1],
                        (int)$line[2],
                        (int)$line[3],
                        $line[4],
                        $region,
                        $gmt,
                        (int)$line[6],
                        $version
                    );
                    $this->addItem($item, self::MAX_SAVE_COUNT);
                } catch (\Exception|\Error $e) {
                    $this->errorLines++;
                    $this->logger->warning('parse line', [
                        'message' => $e->getMessage(),
                        'file' => $e->getFile(),
                        'line' => $e->getLine(),
                        'parse_line' => $line,
                    ]);
                }
            }

        } catch (\Exception|\Error $error) {
            $this->errorLines += 100000;
            $this->logger->error('save abc_def', [
                'message' => $error->getMessage(),
                'file' => $error->getFile(),
                'line' => $error->getLine(),
                'link_csv' => $linkCsv,
                'data_line' => $line ?? null,
            ]);
        }
    }

    private function addItem(AbcDef $item, ?int $countLines): void
    {
        $this->items[] = $item;

        if (count($this->items) >= $countLines || is_null($countLines)) {
            $this->saveItems();
        }
    }

    private function saveItems(): void
    {
        $this->repositoryNumbers->addItems(...$this->items);
        $this->saveLines += count($this->items);
        $this->items = [];
    }


    private function getLinksFromUrl(string $url): array
    {
        $html = file_get_contents($url, false, stream_context_create($this->getRequestOptions()));
        $xml = new \DOMDocument();
        $xml->loadHTML($html, LIBXML_NOERROR);
        $links = [];

        foreach ($xml->getElementsByTagName('a') as $link) {
            if (str_contains($link->getAttribute('href'), '.csv')) {
                $links[] = $link->getAttribute('href');
            }
        }
        return $links;
    }

    private function getRequestOptions(): array
    {
        return [
            "ssl" => [
                'verify_peer' => false,
                'verify_peer_name' => false,
            ]
        ];
    }
}