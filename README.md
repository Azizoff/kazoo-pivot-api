Readme
======

Json generation for kazoo pivot API

How to use
----------

```php
$tree =
    (new \AIR\ModuleBuilder())
        ->play()
        ->data(['id' => 'sound-resource-id-or-http-url'])
        ->sleep()
        ->data(new \AIR\Modules\data\SleepData(15))
        ->device()
        ->data(['id' => 'device-id', 'timeout' => 15])
        ->play()
        ->data(['id' => 'another-sound-resource-id-or-http-url'])
        ->end();
        
header('content-type: application/json');

echo $tree;
```
