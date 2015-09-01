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
     * Returns the list of zones with optional events for a shard
     *
     * @param string $shardName
     *
     * @return mixed
     *
     * @throws Exception\ConnectionException
     */
    public function getZones($shardName)
    {

        $shard = $this->getShardByName($shardName);
        $shardId = $shard['shardId'];
        $response = $this->client->get(sprintf($this->server.self::ENDPOINT_ZONEEVENT_LIST, $shardId));

        if ($response->getStatusCode() == "200") {
            $json = $response->json();

            return $json['data'];
        }

        throw new Exception\ConnectionException("Unable to retrieve zone list");
    }


    /**
     * Retrieves the shard list from the server
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

            return $this->distinctShardList($json['data']);
        }

        throw new Exception\ConnectionException("Unable to retrieve shard list");
    }


    /**
     * Creates a distinct list of shards. Latest shard wins.
     *
     * @param $shardList
     *
     * @return array
     */
    protected function distinctShardList($shardList)
    {

        $distinctShardList = array();

        foreach ($shardList as $shard) {
            $distinctShardList[$shard['name']] = $shard;
        }

        return $distinctShardList;
    }
}

