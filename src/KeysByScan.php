<?php

declare(strict_types=1);

namespace Lab104\Laravel\Redis;

use Illuminate\Redis\Connections\Connection;
use Predis\Client as PredisClient;
use Redis as PhpRedisClient;

use function array_unique;
use function is_array;
use function sort;
use function usleep;

/**
 * KeysByScan class is used to scan Redis keys by pattern.
 * It uses the SCAN command to iterate through the keys in the Redis database.
 * The class is designed to be used with the Laravel framework and its Redis connection.
 */
class KeysByScan
{
    private const DEFAULT_CURSOR = '0';

    public function __construct(private readonly Connection $connection)
    {
    }

    public function __invoke(string $pattern, ?int $count = null, int $usleep = 10): array
    {
        $client = $this->connection->client();

        if ($client instanceof PhpRedisClient) {
            $prefix = $client->getOption(PhpRedisClient::OPT_PREFIX);
        } elseif ($client instanceof PredisClient) {
            $prefix = $client->getOptions()->prefix ?? '';
        }
        $cursor = self::DEFAULT_CURSOR;
        $keys = [];

        $options = [
            'match' => $prefix . $pattern,
        ];

        if ($count !== null) {
            $options['count'] = $count;
        }

        do {
            [$cursor, $result] = $this->connection->scan($cursor, $options);

            if (!is_array($result)) {
                break;
            }

            if (empty($result)) {
                continue;
            }

            $result = array_unique($result);

            $keys = [
                ...$keys,
                ...$result,
            ];

            usleep($usleep);
        } while ((string)$cursor !== self::DEFAULT_CURSOR);

        sort($keys);

        return $keys;
    }
}
