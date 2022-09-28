<?php


namespace App\Share\Handlers;

use App\Infrastructure\Contracts\Repositories\AbcDefGmtRepositoryInterface;
use App\Infrastructure\Contracts\Repositories\AbcDefRepositoryInterface;
use App\Share\Contracts\LoadAbcDefInterface;
use App\Share\entyties\AbcDef;
use App\Share\entyties\AbcDefGmt;
use App\Share\entyties\AbcDefGmts;
use App\Share\entyties\vo\AbcDefRegion;
use Psr\Log\LoggerInterface;

class LoadAbcDefHandler implements LoadAbcDefInterface
{
    private AbcDefGmts $gmt;
    private const MAX_SAVE_COUNT = 5000;
    private array $items = [];


    public function __construct(
        private AbcDefRepositoryInterface    $repositoryNumbers,
        private AbcDefGmtRepositoryInterface $repositoryGmt,
        private LoggerInterface              $logger,
        private AbcDefNormaliz               $normaliz,
    )
    {
        $this->gmt = $this->repositoryGmt->queryAllRegion();

    }

    public function handle(string $parseUrl): bool
    {
        $links = $this->getLinksFromUrl($parseUrl);
        $this->repositoryNumbers->clearTable();
        foreach ($links as $link) {
            $this->getDataCsv($link);
        }

        return true;
    }


    private function splitRegion(string $region): array
    {
        $response = [];
        $regionArray = explode('|', $region);
        foreach ($regionArray as $item) {
            $response = array_merge($response, explode(' * ', $item));
        }
        return $response;
    }

    /**
     * @param string $linkCsv
     */
    private function getDataCsv(string $linkCsv): bool
    {
        static $count = 0;
        try {
            $file = new \SplFileObject($linkCsv, '', context: stream_context_create($this->getRequestOptions()));
            $file->fgets();
            while (!$file->eof()) {
                ++$count;
                $line = $file->fgetcsv(';');

                $region = $this->normaliz->parseRegion($this->splitRegion($line[5]));
                $gmt = $this->searchGmt($region);

                $obj = new AbcDef(
                    (int)$line[0],
                    (int)$line[1],
                    (int)$line[2],
                    (int)$line[3],
                    $line[4],
                    $region,
                    $gmt,
                    (int)$line[6],
                );
                $this->saveItem($obj, self::MAX_SAVE_COUNT);
            }
            $this->logger->info('abc def', ['save lines' => $count]);
            $this->saveItem($obj, null);

            return true;
        } catch (\Exception|\Error $error) {
            $this->logger->error('save abc_def', [
                'message' => $error->getMessage(),
                'file' => $error->getFile(),
                'line' => $error->getLine(),
                'data_line' => $line ?? null,
            ]);
        }
        throw $error;
    }

    private function saveItem(AbcDef $item, ?int $countLines)
    {
        $this->items[] = $item;

        if (count($this->items) >= $countLines || is_null($countLines)) {
            $this->repositoryNumbers->addItems(...$this->items);
            $this->items = [];
        }
    }

    private function searchGmt(AbcDefRegion $region): AbcDefGmt
    {
        if (!$region->isRegion()) {
            $region->setRegion($this->normaliz->getNormalRegion($region->getValueIsEmptyRegion()));
        }
        return $this->gmt->searchGmtByRegion($region->getRegion());
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