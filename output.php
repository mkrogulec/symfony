<?php

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\Exception\InvalidArgumentException;
use Symfony\Component\DependencyInjection\Exception\LogicException;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;
use Symfony\Component\DependencyInjection\ServiceProxy;
use Symfony\Component\DependencyInjection\ParameterBag\FrozenParameterBag;

/**
 * ProjectServiceContainer.
 *
 * This class has been auto-generated
 * by the Symfony Dependency Injection Component.
 *
 * @final since Symfony 3.3
 */
class ProjectServiceContainer extends Container
{
    private $parameters;
    private $targetDirs = array();

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->services = array();
        $this->methodMap = array(
            'bar' => 'getBarService',
            'foo' => 'getFooService',
        );

        $this->aliases = array();
    }

    /**
     * {@inheritdoc}
     */
    public function compile()
    {
        throw new LogicException('You cannot compile a dumped container that was already compiled.');
    }

    /**
     * {@inheritdoc}
     */
    public function isCompiled()
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function isFrozen()
    {
        @trigger_error(sprintf('The %s() method is deprecated since version 3.3 and will be removed in 4.0. Use the isCompiled() method instead.', __METHOD__), E_USER_DEPRECATED);

        return true;
    }

    /**
     * Gets the 'bar' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return \stdClass A stdClass instance
     */
    protected function getBarService()
    {
        $this->services['bar'] = $instance = new \stdClass();

        $instance->foo = array(0 => new SymfonyComponentDependencyInjectionTestsFixturesContainer32FoowithVariadicServiceProxy_0000000045db3c7000000000547e3317(function () {
            return ${($_ = isset($this->services['foo']) ? $this->services['foo'] : $this->get('foo')) && false ?: '_'};
        }, 'Symfony\Component\DependencyInjection\Tests\Fixtures\Container32\Foo', 'withVariadic'), 1 => new SymfonyComponentDependencyInjectionTestsFixturesContainer32FoowithNullableServiceProxy_0000000045db3c7100000000547e3317(function () {
            return ${($_ = isset($this->services['foo']) ? $this->services['foo'] : $this->get('foo')) && false ?: '_'};
        }, 'Symfony\Component\DependencyInjection\Tests\Fixtures\Container32\Foo', 'withNullable'), 2 => new SymfonyComponentDependencyInjectionTestsFixturesContainer32FoowithReturnTypeServiceProxy_0000000045db3c3700000000547e3317(function () {
            return ${($_ = isset($this->services['foo']) ? $this->services['foo'] : $this->get('foo')) && false ?: '_'};
        }, 'Symfony\Component\DependencyInjection\Tests\Fixtures\Container32\Foo', 'withReturnType'));

        return $instance;
    }

    /**
     * Gets the 'foo' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return \Symfony\Component\DependencyInjection\Tests\Fixtures\Container32\Foo A Symfony\Component\DependencyInjection\Tests\Fixtures\Container32\Foo instance
     */
    protected function getFooService()
    {
        return $this->services['foo'] = new \Symfony\Component\DependencyInjection\Tests\Fixtures\Container32\Foo();
    }
}

class SymfonyComponentDependencyInjectionTestsFixturesContainer32FoowithVariadicServiceProxy_0000000045db3c7000000000547e3317 extends ServiceProxy 
{
    public function __invoke($a, &...$c) 
    {
        return $this->getService()->withVariadicwithVariadic($a, ...$c);
    }
}

class SymfonyComponentDependencyInjectionTestsFixturesContainer32FoowithNullableServiceProxy_0000000045db3c7100000000547e3317 extends ServiceProxy 
{
    public function __invoke(?int $a) 
    {
        return $this->getService()->withNullablewithNullable($a);
    }
}

class SymfonyComponentDependencyInjectionTestsFixturesContainer32FoowithReturnTypeServiceProxy_0000000045db3c3700000000547e3317 extends ServiceProxy 
{
    public function __invoke(): \Bar 
    {
        return $this->getService()->withReturnTypewithReturnType();
    }
}
