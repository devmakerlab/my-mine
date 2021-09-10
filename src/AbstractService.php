<?php

declare(strict_types=1);

namespace DevMakerLab\MyMine;

use DateTime;
use DateTimeZone;
use GuzzleHttp\Client;
use DevMakerLab\MyMine\Exceptions\ExistingFilterKeyException;
use DevMakerLab\MyMine\Exceptions\NonExistingFilterKeyException;

abstract class AbstractService
{
    protected HttpService $httpService;

    protected array $filters = [];

    public function __construct(Client $client)
    {
        $this->httpService = new HttpService($client);
    }

    protected function fetch(string $endpoint): array
    {
        $items = [];

        $maxLimit = $this->filters['limit'] ?? \PHP_INT_MAX;
        $offset = $this->filters['offset'] ?? 0;

        while ($maxLimit > 0) {
            if ($maxLimit > 100) {
                $currentLimit = 100;
                $maxLimit -= 100;
            } else {
                $currentLimit = $maxLimit;
                $maxLimit = 0;
            }

            $this->filters['limit'] = $currentLimit;
            $this->filters['offset'] = $offset;

            $uri = $this->computeUri($endpoint);
            $newDataSet = $this->httpService->get($uri);

            $items = array_merge_recursive($items, $newDataSet);
            $offset += $currentLimit;

            if (empty($newDataSet) || !isset($newDataSet['limit']) ||
                (isset($newDataSet['offset']) && isset($newDataSet['total_count']) && $newDataSet['offset'] >= $newDataSet['total_count'])) {
                $maxLimit = 0;
            }
        }

        $this->resetFilters();

        return $items;
    }

    public function addFilter(string $key, $value): self
    {
        if (\array_key_exists($key, $this->filters)) {
            throw new ExistingFilterKeyException();
        }

        $this->filters[$key] = $value;

        return $this;
    }

    public function updateFilter(string $key, $value): self
    {
        if (! \array_key_exists($key, $this->filters)) {
            throw new NonExistingFilterKeyException();
        }

        $this->filters[$key] = $value;

        return $this;
    }

    public function getFilters(): array
    {
        return $this->filters;
    }

    public function resetFilters(): void
    {
        $this->filters = [];
    }

    public function setLimit(int $limit): self
    {
        $this->filters['limit'] = $limit;

        return $this;
    }

    public function setOffset(int $offset): self
    {
        $this->filters['offset'] = $offset;

        return $this;
    }

    protected function transform(array $array, callable $callback): array
    {
        return array_map($callback, $array);
    }

    private function computeUri(string $endpoint): string
    {
        $parameters = preg_replace('/%5B[0-9]+%5D/simU', '%5B%5D', http_build_query($this->filters));

        return sprintf('%s?%s', $endpoint, $parameters);
    }

    protected function convertToTz($time = "", $toTz = '', $fromTz = 'UTC'): DateTime
    {
        $date = new DateTime($time, new DateTimeZone($fromTz));
        $date->setTimezone(new DateTimeZone($toTz));

        return $date;
    }
}
