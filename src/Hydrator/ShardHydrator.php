<?php

namespace Ecn\RiftConnector\Hydrator;

use Ecn\RiftConnector\Entity\Shard;
use Ecn\RiftConnector\RiftService;

/**
 * Class ShardHydrator
 *
 * PHP Version 5.4
 *
 * @author    Pierre Groth <pierre@elbcoast.net>
 * @copyright 2015
 * @license   MIT
 *
 */
class ShardHydrator
{
    /**
     * Hydrates shard data into a Shard object
     *
     * @param array       $shardData
     * @param RiftService $service
     *
     * @return Shard
     */
    public static function hydrate($shardData, RiftService $service)
    {
        $shard = new Shard($service);

        $shard->setShardId($shardData['shardId']);
        $shard->setName($shardData['name']);
        $shard->setRunning($shardData['running']);
        $shard->setReady($shardData['ready']);
        $shard->setLocked($shardData['locked']);
        $shard->setPopLevel($shardData['popLevel']);
        $shard->setQueueWaitTime($shardData['queueWaitTime']);
        $shard->setPvp($shardData['pvp']);
        $shard->setLanguage($shardData['language']);

        return $shard;
    }
}
