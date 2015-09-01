<?php

namespace Ecn\RiftConnector\Tests;

use Ecn\RiftConnector\Connector;

class ConnectorTest extends \PHPUnit_Framework_TestCase
{

    public function testIfcanInitClass()
    {
        $client = $this->getMock('\GuzzleHttp\ClientInterface');
        $connector = new Connector($client);
    }


    public function testRetrieveShardList()
    {
        // Assume a successful response
        $response = $this->getMock('\GuzzleHttp\Message\ResponseInterface');
        $response->method('getStatusCode')->willReturn('200');
        $response->method('json')->willReturn($this->getDummyShardList());

        $client = $this->getMock('\GuzzleHttp\ClientInterface');
        $client->method('get')->willReturn($response);

        $connector = new Connector($client);

        $shardList = $connector->getShardList();
        $this->assertNotEmpty($shardList);

        $shard = array_pop($shardList);

        $this->assertArrayHasKey('shardId', $shard);
    }


    /**
     *  @expectedException \Ecn\RiftConnector\Exception\ConnectionException
     */
    public function testRetrieveShardListError()
    {
        $response = $this->getMock('\GuzzleHttp\Message\ResponseInterface');
        $response->method('getStatusCode')->willReturn('404');

        $client = $this->getMock('\GuzzleHttp\ClientInterface');
        $client->method('get')->willReturn($response);

        $connector = new Connector($client);
        $connector->getShardList();
    }


    public function testRetrieveZoneEvents()
    {
        // Assume a successful response
        $response = $this->getMock('\GuzzleHttp\Message\ResponseInterface');
        $response->method('getStatusCode')->willReturn('200');
        $response->method('json')->willReturn($this->getDummyZoneEvents());

        $client = $this->getMock('\GuzzleHttp\ClientInterface');
        $client->method('get')->willReturn($response);

        $connector = $this->getMockBuilder('\Ecn\RiftConnector\Connector')
            ->setMethods(array('getShardList'))
            ->disableOriginalConstructor()
            ->getMock();

        $connector->method('getShardList')->willReturn($this->getDummyShardList()['data']);
        $connector->__construct($client);

        $zoneEvents = $connector->getZones('Bloodiron');

        $this->assertNotEmpty($zoneEvents);
    }


    /**
     *  @expectedException \Ecn\RiftConnector\Exception\ConnectionException
     */
    public function testRetrieveZoneEventsError()
    {
        $response = $this->getMock('\GuzzleHttp\Message\ResponseInterface');
        $response->method('getStatusCode')->willReturn('404');

        $client = $this->getMock('\GuzzleHttp\ClientInterface');
        $client->method('get')->willReturn($response);

        $connector = new Connector($client);
        $connector->getZones('2741');
    }


    public function testGetShardByName()
    {
        $response = $this->getMock('\GuzzleHttp\Message\ResponseInterface');
        $response->method('getStatusCode')->willReturn('200');
        $response->method('json')->willReturn($this->getDummyShardList());

        $client = $this->getMock('\GuzzleHttp\ClientInterface');
        $client->method('get')->willReturn($response);

        $connector = new Connector($client);

        $shard = $connector->getShardByName('Bloodiron');

        $this->assertNotNull($shard);
        $this->assertArrayHasKey('shardId', $shard);
        $this->assertArrayHasKey('name', $shard);
        $this->assertEquals('2507', $shard['shardId']);

    }

    /**
     *  @expectedException \Ecn\RiftConnector\Exception\ShardNotFoundException
     */
    public function testGetShardByNameError()
    {
        $response = $this->getMock('\GuzzleHttp\Message\ResponseInterface');
        $response->method('getStatusCode')->willReturn('200');
        $response->method('json')->willReturn($this->getDummyShardList());

        $client = $this->getMock('\GuzzleHttp\ClientInterface');
        $client->method('get')->willReturn($response);

        $connector = new Connector($client);

        $shard = $connector->getShardByName('Foo');

    }


    /**
     * Some dummy values
     *
     * @return mixed
     */
    private function getDummyShardList()
    {
        $data = '{
        "status":"success",
        "data":{
        "Blightweald":{"shardId":2501,"name":"Blightweald","running":false,"ready":false,"locked":false,"popLevel":0,"queueWaitTime":0,"pvp":false,"language":1},
        "Cloudborne":{"shardId":2502,"name":"Cloudborne","running":false,"ready":false,"locked":false,"popLevel":0,"queueWaitTime":0,"pvp":true,"language":1},
        "Sagespire":{"shardId":2504,"name":"Sagespire","running":false,"ready":false,"locked":false,"popLevel":0,"queueWaitTime":0,"pvp":true,"language":1},
        "Bloodiron":{"shardId":2507,"name":"Bloodiron","running":false,"ready":false,"locked":false,"popLevel":0,"queueWaitTime":0,"pvp":true,"language":1},
        "Zaviel":{"shardId":2722,"name":"Zaviel","running":false,"ready":false,"locked":false,"popLevel":0,"queueWaitTime":0,"pvp":false,"language":1},
        "Typhiria":{"shardId":2741,"name":"Typhiria","running":false,"ready":false,"locked":false,"popLevel":0,"queueWaitTime":0,"pvp":false,"language":1}
        }}';

        return json_decode($data, true);
    }

    private function getDummyZoneEvents()
    {
        $data = '{
        "status":"success",
        "data":[
        {"zone":"Kingdom of Pelladane","zoneId":479431687},
        {"zone":"Cape Jule","zoneId":1770829751},
        {"zone":"Shimmersand","zoneId":6},
        {"zone":"Stillmoor","zoneId":26,"name":"Witch of the West","started":1440628412},
        {"zone":"Freemarch","zoneId":19},
        {"zone":"Silverwood","zoneId":12},
        {"zone":"Ember Isle","zoneId":1992854106},
        {"zone":"Iron Pine Peak","zoneId":22},
        {"zone":"Scarlet Gorge","zoneId":26580443},
        {"zone":"Gloamwood","zoneId":27},
        {"zone":"Stonefield","zoneId":1481781477},
        {"zone":"Droughtlands","zoneId":336995470},
        {"zone":"Scarwood Reach","zoneId":20,"name":"Infernal Awakening","started":1440629309},
        {"zone":"The Dendrome","zoneId":282584906},
        {"zone":"Moonshade Highlands","zoneId":24},
        {"zone":"Ashora","zoneId":790513416},
        {"zone":"Steppes of Infinity","zoneId":798793247},
        {"zone":"Seratos","zoneId":1494372221},
        {"zone":"City Core","zoneId":1967477725,"name":"Unstable City Core","started":1440629019},
        {"zone":"Eastern Holdings","zoneId":1213399942},
        {"zone":"Ardent Domain","zoneId":1446819710},
        {"zone":"Kingsward","zoneId":1300766935},
        {"zone":"Morban","zoneId":956914599},
        {"zone":"Goboro Reef","zoneId":301},
        {"zone":"Draumheim","zoneId":302,"name":"Howling Fury","started":1440628818},
        {"zone":"Tarken Glacier","zoneId":303},
        {"zone":"Tyrant\u0027s Throne","zoneId":426135797}
        ]}';

        return json_decode($data, true);
    }

}
