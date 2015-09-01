<?php

namespace Ecn\RiftConnector\Entity;

use Ecn\RiftConnector\RiftService;

/**
 * Class Shard
 *
 * PHP Version 5.4
 *
 * @author    Pierre Groth <pierre@elbcoast.net>
 * @copyright 2015
 * @license   MIT
 *
 */
class Shard
{
    /**
     * @var int
     */
    protected $shardId;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var boolean
     */
    protected  $running;

    /**
     * @var boolean
     */
    protected $ready;

    /**
     * @var boolean
     */
    protected $locked;

    /**
     * @var int
     */
    protected $popLevel;

    /**
     * @var int
     */
    protected $queueWaitTime;

    /**
     * @var boolean
     */
    protected $pvp;

    /**
     * @var int
     */
    protected $language;

    /**
     * @var RiftService
     */
    protected $service;


    /**
     * Constructor.
     *
     * @param RiftService $service
     */
    public function __construct(RiftService $service)
    {
        $this->service = $service;
    }


    /**
     * @return int
     */
    public function getShardId()
    {
        return $this->shardId;
    }


    /**
     * @param int $shardId
     */
    public function setShardId($shardId)
    {
        $this->shardId = $shardId;
    }


    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }


    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }


    /**
     * @return boolean
     */
    public function isRunning()
    {
        return $this->running;
    }


    /**
     * @param boolean $running
     */
    public function setRunning($running)
    {
        $this->running = $running;
    }


    /**
     * @return boolean
     */
    public function isReady()
    {
        return $this->ready;
    }


    /**
     * @param boolean $ready
     */
    public function setReady($ready)
    {
        $this->ready = $ready;
    }


    /**
     * @return boolean
     */
    public function isLocked()
    {
        return $this->locked;
    }


    /**
     * @param boolean $locked
     */
    public function setLocked($locked)
    {
        $this->locked = $locked;
    }


    /**
     * @return int
     */
    public function getPopLevel()
    {
        return $this->popLevel;
    }


    /**
     * @param int $popLevel
     */
    public function setPopLevel($popLevel)
    {
        $this->popLevel = $popLevel;
    }


    /**
     * @return int
     */
    public function getQueueWaitTime()
    {
        return $this->queueWaitTime;
    }

    /**
     * @param int $queueWaitTime
     */
    public function setQueueWaitTime($queueWaitTime)
    {
        $this->queueWaitTime = $queueWaitTime;
    }


    /**
     * @return boolean
     */
    public function isPvp()
    {
        return $this->pvp;
    }


    /**
     * @param boolean $pvp
     */
    public function setPvp($pvp)
    {
        $this->pvp = $pvp;
    }


    /**
     * @return int
     */
    public function getLanguage()
    {
        return $this->language;
    }


    /**
     * @param int $language
     */
    public function setLanguage($language)
    {
        $this->language = $language;
    }


    /**
     * @return mixed
     */
    public function getZones()
    {
        return $this->service->getZones($this->getName());
    }

    /**
     * @return mixed
     */
    public function getEvents()
    {
        return $this->service->getEvents($this->getName());
    }

}
