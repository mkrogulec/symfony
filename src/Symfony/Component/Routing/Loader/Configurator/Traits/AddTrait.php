<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Routing\Loader\Configurator\Traits;

use Symfony\Component\Routing\Loader\Configurator\CollectionConfigurator;
use Symfony\Component\Routing\Loader\Configurator\RouteConfigurator;
use Symfony\Component\Routing\RouteCollection;

/**
 * @author Nicolas Grekas <p@tchwork.com>
 */
trait AddTrait
{
    use LocalizedRouteTrait;

    /**
     * @var RouteCollection
     */
    private $collection;
    private $name = '';
    private $prefixes;

    /**
     * Adds a route.
     *
     * @param string|array $path the path, or the localized paths of the route
     */
    final public function add(string $name, $path): RouteConfigurator
    {
        $parentConfigurator = $this instanceof CollectionConfigurator ? $this : ($this instanceof RouteConfigurator ? $this->parentConfigurator : null);
        $routes = $this->createRoutes($this->collection, $name, $path, $this->name, $this->prefixes);

        return new RouteConfigurator($this->collection, $routes, $this->name, $parentConfigurator, $this->prefixes);
    }

    /**
     * Adds a route.
     *
     * @param string|array $path the path, or the localized paths of the route
     */
    final public function __invoke(string $name, $path): RouteConfigurator
    {
        return $this->add($name, $path);
    }
}
