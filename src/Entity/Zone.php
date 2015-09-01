<?php

namespace Ecn\RiftConnector\Entity;

use Ecn\RiftConnector\Entity\Event;

/**
 * Class Zone
 *
 * PHP Version 5.4
 *
 * @author    Pierre Groth <pierre@elbcoast.net>
 * @copyright 2015
 * @license   MIT
 */
class Zone
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var int
     */
    protected $id;

    /**
     * @var Event
     */
    protected $event;

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }


    /**
     * Constructor.
     *
     * @param $name
     * @param $id
     */
    public function __construct($name, $id)
    {
        $this->name = $name;
        $this->id = $id;
    }


    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }


    /**
     * @return \Ecn\RiftConnector\Entity\Event
     */
    public function getEvent()
    {
        return $this->event;
    }


    /**
     * @param \Ecn\RiftConnector\Entity\Event $event
     */
    public function setEvent($event)
    {
        $this->event = $event;
    }


    /**
     * @return bool
     */
    public function hasEvent()
    {
        return $this->event ? true : false;
    }

}
