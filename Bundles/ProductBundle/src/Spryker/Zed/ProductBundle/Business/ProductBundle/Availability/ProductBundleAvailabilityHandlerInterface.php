<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\ProductBundle\Business\ProductBundle\Availability;

interface ProductBundleAvailabilityHandlerInterface
{

    /**
     * @param string $bundledProductSku
     *
     * @return void
     */
    public function updateAffectedBundlesAvailability($bundledProductSku);

    /**
     * @param string $bundleProductSku
     *
     * @return string
     */
    public function updateBundleAvailability($bundleProductSku);

}
