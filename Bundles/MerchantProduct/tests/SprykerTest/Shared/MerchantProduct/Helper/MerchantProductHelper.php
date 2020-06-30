<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Spryker Marketplace License Agreement. See LICENSE file.
 */

namespace SprykerTest\Shared\MerchantProduct\Helper;

use Codeception\Module;
use Generated\Shared\Transfer\MerchantProductTransfer;
use Orm\Zed\MerchantProduct\Persistence\SpyMerchantProductAbstract;
use SprykerTest\Shared\Product\Helper\ProductDataHelper;
use SprykerTest\Shared\Testify\Helper\DataCleanupHelperTrait;
use SprykerTest\Zed\Merchant\Helper\MerchantHelper;

class MerchantProductHelper extends Module
{
    use DataCleanupHelperTrait;

    /**
     * @param array $seedData
     *
     * @return \Generated\Shared\Transfer\MerchantProductTransfer
     */
    public function haveMerchantProduct(array $seedData = []): MerchantProductTransfer
    {
        $merchantProductAbstractEntity = new SpyMerchantProductAbstract();
        $merchantProductAbstractEntity->setFkMerchant($seedData[MerchantProductTransfer::ID_MERCHANT]);
        $merchantProductAbstractEntity->setFkProductAbstract($seedData[MerchantProductTransfer::ID_PRODUCT_ABSTRACT]);
        $merchantProductAbstractEntity->save();

        $this->getDataCleanupHelper()->_addCleanup(function () use ($merchantProductAbstractEntity) {
            $merchantProductAbstractEntity->delete();
        });

        return (new MerchantProductTransfer())
            ->fromArray($merchantProductAbstractEntity->toArray(), true)
            ->setIdMerchant($merchantProductAbstractEntity->getFkMerchant())
            ->setIdProductAbstract($merchantProductAbstractEntity->getFkProductAbstract());
    }

    /**
     * @return \SprykerTest\Zed\Merchant\Helper\MerchantHelper
     */
    protected function getMerchantHelper(): MerchantHelper
    {
        /** @var \SprykerTest\Zed\Merchant\Helper\MerchantHelper $merchantHelper */
        $merchantHelper = $this->getModule('\\' . MerchantHelper::class);

        return $merchantHelper;
    }

    /**
     * @return \SprykerTest\Shared\Product\Helper\ProductDataHelper
     */
    protected function getProductDataHelper(): ProductDataHelper
    {
        /** @var \SprykerTest\Shared\Product\Helper\ProductDataHelper $productDataHelper */
        $productDataHelper = $this->getModule('\\' . ProductDataHelper::class);

        return $productDataHelper;
    }
}
