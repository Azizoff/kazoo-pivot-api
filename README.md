Readme
======

Json generation for [kazoo](https://github.com/2600hz/kazoo/) pivot API

How to use
----------

```php
$module = new \AIR\Modules\SimpleModule('play');
$module
    ->data(array('id' => 'sound-resource-id-or-http-url'))
    ->then('sleep')
    ->data(array('unit' => 's', 'duration' => 15))
    ->then('device')
    ->data(array('id' => 'device-id', 'timeout' => 15))
    ->then('play')
    ->data(array('id' => 'another-sound-resource-id-or-http-url'))
;
        
header('content-type: application/json');
echo $module->render();
```
or
```php
$module = new \AIR\Modules\SimpleModule('play');
$module
    ->data(array('id' => 'sound-resource-id-or-http-url'))
    ->then('sleep', array('unit' => 's', 'duration' => 15))
    ->then('device', array('id' => 'device-id', 'timeout' => 15))
    ->then('play', array('id' => 'another-sound-resource-id-or-http-url'))
;
        
header('content-type: application/json');
echo $module->render();
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