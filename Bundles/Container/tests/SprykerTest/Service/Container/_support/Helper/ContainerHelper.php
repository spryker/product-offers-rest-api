<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerTest\Service\Container\Helper;

use Codeception\Module;
use Codeception\TestInterface;
use ReflectionClass;
use ReflectionProperty;
use Spryker\Service\Container\ContainerInterface;
use Spryker\Shared\Kernel\Container\ContainerProxy;

class ContainerHelper extends Module
{
    protected const CONFIG_KEY_DEBUG = 'debug';

    /**
     * @var \Spryker\Service\Container\ContainerInterface|null
     */
    protected $container;

    /**
     * @var array
     */
    protected $config = [
        self::CONFIG_KEY_DEBUG => false,
    ];

    /**
     * @return \Spryker\Service\Container\ContainerInterface
     */
    public function getContainer(): ContainerInterface
    {
        if ($this->container === null) {
            $this->container = new ContainerProxy(['logger' => null, 'debug' => $this->config[static::CONFIG_KEY_DEBUG], 'charset' => 'UTF-8']);
        }

        return $this->container;
    }

    /**
     * @param \Codeception\TestInterface $test
     *
     * @return void
     */
    public function _before(TestInterface $test): void
    {
        parent::_before($test);

        if ($this->container !== null) {
            $this->resetStaticProperties();
        }

        $this->container = null;
    }

    /**
     * @return void
     */
    protected function resetStaticProperties(): void
    {
        $reflectedClass = new ReflectionClass($this->container);

        foreach ($reflectedClass->getProperties(ReflectionProperty::IS_STATIC) as $reflectedProperty) {
            $reflectedProperty->setAccessible(true);
            $reflectedProperty->setValue([]);
        }
    }
}
