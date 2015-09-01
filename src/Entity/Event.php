<?php

namespace Ecn\RiftConnector\Entity;

use Ecn\RiftConnector\Entity\Zone;

/**
 * Class Event
 *
 * PHP Version 5.4
 *
 * @author    Pierre Groth <pierre@elbcoast.net>
 * @copyright 2015
 * @license   MIT
 *
 */
class Event
{

    /**
     * @var string
     */
    protected $name;

    /**
     * @var \DateTime
     */
    protected $startDate;

    /**
     * @var Zone
     */
    protected $zone;


    /**
     * Constructor.
     *
     * @param \Ecn\RiftConnector\Entity\Zone $zone
     * @param string                         $name
     * @param string                         $startDate Unix Timestamp
     */
    public function __construct(Zone $zone, $name, $startDate)
    {
        $this->name = $name;
        $this->startDate = new \DateTime('@'.$startDate);
        $this->startDate->setTimezone(new \DateTimeZone(date('e')));
        $this->zone = $zone;
    }


    /**
     * @return \Ecn\RiftConnector\Entity\Zone
     */
    public function getZone()
    {
        return $this->zone;
    }


    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }


    /**
     * @return \DateTime
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

}
