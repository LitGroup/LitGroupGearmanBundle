GearmanBundle
=============

Simpliest __Gearman php-extension__ integration with __Dependency Injectiono Container__ of __Symfony 2__

Installation
------------

### Before installation
At first you should install __PECL Extension for Gearman__.
See instruction [here][1].

### Installation with Composer

```json
{
    "require": {
        "litgroup/gearman-bundle": "dev-master"
    }
}
```

### Enable bundle in the AppKernel

```php
class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            // ...
            new LitGroup\Bundle\GearmanBundle\LitGroupGearmanBundle(),
        );

        // ...
        
        return $bundles;
    }

    // ...
}
```

Configuration
-------------

With empty configuration localhost server will be used on default port.

You can also specify the list of servers. Look on examples for `yaml`, `xml` and `php` configurations:

```yaml
lit_group_gearman:
    servers:
        - "10.0.0.1"
        - "10.0.0.2:4703" # Specify the port
```

```xml
<gearman:config
        xmlns:gearman="http://litgroup.ru/schema/dic/gearman"
        xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
        xsi:schemaLocation="http://litgroup.ru/schema/dic/gearman http://litgroup.ru/schema/dic/gearman/gearman-1.0.xsd">

    <gearman:servers>
        <gearman:server>10.0.0.1:4703</gearman:server>
        <gearman:server>10.0.0.2:4703</gearman:server>
    </gearman:servers>

</gearman:config>
```

```php
$container->loadFromExtension('lit_group_gearman', [
    'servers' => [
        '10.0.0.1:4703',
        '10.0.0.2:4703',
    ]
]);
```

Usage
-----
Bundle provides two services available in container.

 - `litgroup_gearman.client` — `GearmanClient` class;
 - `litgroup_gearman.worker` — `GearmanWorker` class.


License
-------
This bundle is under the MIT license. See the complete license in the bundle:

```
Resources/meta/LICENSE
```

Reporting an issue or a feature request
---------------------------------------
Issues and feature requests are tracked in the Github issue tracker.

Pull request should be sent for `develop` branch.

[1]: http://www.php.net/manual/en/book.gearman.php