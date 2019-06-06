<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\ProductBundle\Dependency\Service;

class ProductBundleToUtilQuantityServiceBridge implements ProductBundleToUtilQuantityServiceInterface
{
    /**
     * @var \Spryker\Service\UtilQuantity\UtilQuantityServiceInterface
     */
    protected $utilQuantityService;

    /**
     * @param \Spryker\Service\UtilQuantity\UtilQuantityServiceInterface $utilQuantityService
     */
    public function __construct($utilQuantityService)
    {
        $this->utilQuantityService = $utilQuantityService;
    }

    /**
     * @param float $firstQuantity
     * @param float $secondQuantity
     *
     * @return bool
     */
    public function isQuantityEqual(float $firstQuantity, float $secondQuantity): bool
    {
        return $this->utilQuantityService->isQuantityEqual($firstQuantity, $secondQuantity);
    }

    /**
     * @param float $firstQuantity
     * @param float $secondQuantity
     *
     * @return float
     */
    public function sumQuantities(float $firstQuantity, float $secondQuantity): float
    {
        return $this->utilQuantityService->sumQuantities($firstQuantity, $secondQuantity);
    }

    /**
     * @param float $firstQuantity
     * @param float $secondQuantity
     *
     * @return float
     */
    public function subtractQuantities(float $firstQuantity, float $secondQuantity): float
    {
        return $this->utilQuantityService->subtractQuantities($firstQuantity, $secondQuantity);
    }

    /**
     * @param float $dividentQuantity
     * @param float $divisorQuantity
     * @param float $remainder
     *
     * @return bool
     */
    public function isQuantityModuloEqual(float $dividentQuantity, float $divisorQuantity, float $remainder): bool
    {
        return $this->utilQuantityService->isQuantityModuloEqual($dividentQuantity, $divisorQuantity, $remainder);
    }

    /**
     * @param float $firstQuantity
     * @param float $secondQuantity
     *
     * @return bool
     */
    public function isQuantityLessOrEqual(float $firstQuantity, float $secondQuantity): bool
    {
        return $this->utilQuantityService->isQuantityLessOrEqual($firstQuantity, $secondQuantity);
    }
}
