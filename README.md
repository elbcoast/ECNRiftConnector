ECNRiftConnector
================

[![Build Status](https://travis-ci.org/elbcoast/ECNRiftConnector.svg?branch=master)](https://travis-ci.org/elbcoast/ECNRiftConnector)

## Installation

Install the RiftConnector via composer:

```bash
$ composer require ecn/riftconnector:dev-master
```

## Usage

The RiftConnector comes along with a `RiftService` class that allows easy access to shards, zones and events.


### Setup

To get a running RiftService instance, pass a connector instance to the constructor:

```php
<?php

use GuzzleHttp\Client;
use Ecn\RiftConnector\Connector;
use Ecn\RiftConnector\RiftService;

$connector = new Connector(new Client(), Connector::EU_SERVER);
$service = new RiftService($connector);
        
```

### Retrieving shard data

To retrieve a shard object, use the `getShard()` method:

```php

// returns a Shard object
$shard = $service->getShard('Brutwacht');
        
```

### Retrieving zones

You can query zones from the shard object:

```php

// returns an array of Zone objects
$zones = $shard->getZones();
        
```

Alternatively, you can retrieve zones directly from the RiftService:

```php

// returns an array of Zone objects
$zones = $service->getZones('Brutwacht');
        
```

### Retrieving events

Similar to zones, events can be retrieved from the shard object or from the RiftConnector directly:

```php

// returns an array of Event objects
$events = $shard->getEvents();

// returns an array of Event objects
$events = $service->getEvents('Brutwacht');
        
```

Additionally, you can check a zone directly for an event:

```php

$zones = $shard->getZones();
 
if ($zones[0]->hasEvent()) {
    $event = $zones[0]->getEvent();
}
        
```

