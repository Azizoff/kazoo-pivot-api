Readme
======

Json generation for [kazoo](https://github.com/2600hz/kazoo/) pivot API

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

or

```php
$tree =
    (new \AIR\ModuleBuilder())
        ->play(['id' => 'sound-resource-id-or-http-url'])
        ->sleep(new \AIR\Modules\data\SleepData(15))
        ->device(['id' => 'device-id', 'timeout' => 15])
        ->play(['id' => 'another-sound-resource-id-or-http-url'])
        ->end();
        
header('content-type: application/json');

echo $tree;
```

Result:
```json
{
  "module": "play",
  "data": {
    "id": "sound-resource-id-or-http-url"
  },
  "children": {
    "_": {
      "module": "sleep",
      "data": {
        "unit": "s",
        "duration": 15
      },
      "children": {
        "_": {
          "module": "device",
          "data": {
            "id": "device-id",
            "timeout": 15
          },
          "children": {
            "_": {
              "module": "play",
              "data": {
                "id": "another-sound-resource-id-or-http-url"
              }
            }
          }
        }
      }
    }
  }
}
```
