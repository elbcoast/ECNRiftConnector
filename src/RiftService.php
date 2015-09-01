<?php

namespace Ecn\RiftConnector;

use Ecn\RiftConnector\Entity\Shard;
use Ecn\RiftConnector\Hydrator\ShardHydrator;
use Ecn\RiftConnector\Hydrator\ZoneHydrator;


/**
 * Class RiftService
 *
 * PHP Version 5.4
 *
 * @author    Pierre Groth <pierre@elbcoast.net>
 * @copyright 2014
 * @license   MIT
 *
 */
class RiftService
{

    /**
     * @var Connector
     */
    protected $connector;

    /**
     * @var array
     */
    protected $shard = array();

    /**
     * @var array
     */
    protected $zones = array();

    /**
     * @var array
     */
    protected $events = array();


    /**
     * Constructor.
     *
     * @param Connector $connector
     */
    public function __construct(Connector $connector)
    {
        $this->connector = $connector;
    }


    /**
     * Retrieves a shard
     *
     * @param $shardName
     *
     * @return Shard
     *
     * @throws Exception\ShardNotFoundException
     */
    public function getShard($shardName)
    {
        if (!array_key_exists($shardName, $this->shard)) {
            $shardData = $this->connector->getShardByName($shardName);
            $this->shard[$shardName] = ShardHydrator::hydrate($shardData, $this);
        }

        return $this->shard[$shardName];
    }


    /**
     * Returns a list of zones for a shard
     *
     * @param $shardName
     *
     * @return array
     *
     * @throws Exception\ShardNotFoundException
     */
    public function getZones($shardName)
    {
        if (!array_key_exists($shardName, $this->zones)) {
            $zoneData = $this->connector->getZones($shardName);
            $this->zones[$shardName] = ZoneHydrator::hydrate($zoneData);
        }

        return $this->zones[$shardName];
    }


    /**
     * Returns a list of all running events on a shard
     *
     * @param $shardName
     *
     * @return array
     */
    public function getEvents($shardName)
    {
        if (!array_key_exists($shardName, $this->events)) {
            $events = array();
            $zones = $this->getZones($shardName);

            foreach ($zones as $zone) {
                if ($zone->hasEvent()) {
                    $events[] = $zone->getEvent();
                }
            }

            $this->events[$shardName] = $events;
        }

        return $this->events[$shardName];
    }
}
