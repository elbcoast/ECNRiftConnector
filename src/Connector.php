<?php

namespace Ecn\RiftConnector;

use GuzzleHttp\ClientInterface;

class Connector
{
    // Servers
    const EU_SERVER = "http://chat-eu.riftgame.com:8080";
    const US_SERVER = "http://chat-us.riftgame.com:8080";

    // Endpoints
    const ENDPOINT_SHARD_LIST = "/chatservice/shard/list";
    const ENDPOINT_ZONEEVENT_LIST = "/chatservice/zoneevent/list?shardId=%s";

    /**
     * @var string Url of the chat server
     */
    protected $server;

    /**
     * @var array List of shards
     */
    protected $shardList;

    /**
     * @var Client The Guzzle HTTP Client
     */
    protected $client;


    /**
     * Constructor.
     *
     * @param ClientInterface $client
     * @param string          $server
     */
    public function __construct(ClientInterface $client, $server = self::EU_SERVER)
    {
        $this->client = $client;
        $this->server = $server;
    }


    /**
     * Returns a list of shards on the current chat server
     *
     * @return array
     */
    public function getShardList()
    {
        if (!$this->shardList) {
            $this->shardList = $this->retrieveShardList();
        }

        return $this->shardList;
    }


    /**
     * Finds a shard by its name
     *
     * @param string $name
     *
     * @return mixed
     */
    public function getShardByName($name)
    {
        $shardList = $this->getShardList();

        return array_key_exists($name, $shardList) ? $shardList[$name] : null;
    }


    /**
     * Returns a list of zone events for a shard
     *
     * @param string $name
     *
     * @return mixed
     *
     * @throws Exception\ConnectionException
     */
    public function getZoneEvents($name)
    {

        $shard = $this->getShardByName($name);
        $shardId = $shard['shardId'];
        $response = $this->client->get(sprintf($this->server.self::ENDPOINT_ZONEEVENT_LIST, $shardId));

        if ($response->getStatusCode() == "200") {
            $json =  $response->json();

            return $json['data'];
        }

        throw new Exception\ConnectionException("Unable to retrieve zone events");
    }


    /**
     * Retrieves the shard list from the server, hydrates and caches it
     *
     * @return array
     *
     * @throws Exception\ConnectionException
     */
    protected function retrieveShardList()
    {
        $response = $this->client->get($this->server.self::ENDPOINT_SHARD_LIST);

        if ($response->getStatusCode() == "200") {
           $json =  $response->json();

            return $this->hydrateShardList($json['data']);
        }

        throw new Exception\ConnectionException("Unable to retrieve shard list");
    }


    /**
     * Hydrates the shard list into a more useful format
     *
     * @param $shardList
     *
     * @return array
     */
    protected function hydrateShardList($shardList)
    {

        $hydratedShardList = array();

        foreach ($shardList as $shard) {
            $hydratedShardList[$shard['name']] = $shard;
        }

        return $hydratedShardList;
    }
}

