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

Bundle supports only _yaml_-configuration.

With empty configuration localhost server will be used on default port.

```yaml
lit_group_gearman: ~
```

You can also specify the list of servers:
```yaml
lit_group_gearman:
    servers:
        - "10.0.0.1"
        - "10.0.0.2:4703" # Specify the port
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