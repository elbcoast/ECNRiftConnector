<?php

namespace Ecn\RiftConnector\Hydrator;


use Ecn\RiftConnector\Entity\Event;
use Ecn\RiftConnector\Entity\Zone;

/**
 * Class ZoneHydrator
 *
 * PHP Version 5.4
 *
 * @author    Pierre Groth <pierre@elbcoast.net>
 * @copyright 2015
 * @license   MIT
 *
 */
class ZoneHydrator
{
    /**
     * Hydrates zone data into an array of Zone objects
     *
     * @param array $zoneData
     *
     * @return array
     */
    public static function hydrate($zoneData)
    {
        $zoneCollection = array();

        foreach ($zoneData as $record) {
            $zone = new Zone($record['zone'], $record['zoneId']);

            // Running event exists
            if (array_key_exists('started', $record) && array_key_exists('name', $record)) {
                $event = new Event($zone, $record['name'], $record['started']);
                $zone->setEvent($event);
            }

            $zoneCollection[] = $zone;

            unset ($zone, $event);
        }

        return $zoneCollection;
    }
}
