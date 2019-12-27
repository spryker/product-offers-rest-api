<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Spryker Marketplace License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\MerchantProductOfferSearch\Business\Writer;

interface MerchantProductOfferSearchWriterInterface
{
    /**
     * @param \Generated\Shared\Transfer\EventEntityTransfer[] $eventTransfers
     *
     * @return void
     */
    public function writeMerchantProductOfferSearchCollectionByIdMerchantEvents(array $eventTransfers): void;

    /**
     * @param \Generated\Shared\Transfer\EventEntityTransfer[] $eventTransfers
     *
     * @return void
     */
    public function writeMerchantProductOfferSearchCollectionByIdMerchantProfileEvents(array $eventTransfers): void;

    /**
     * @param \Generated\Shared\Transfer\EventEntityTransfer[] $eventTransfers
     *
     * @return void
     */
    public function writeMerchantProductOfferSearchCollectionByIdMerchantProductOfferEvents(array $eventTransfers): void;
}
