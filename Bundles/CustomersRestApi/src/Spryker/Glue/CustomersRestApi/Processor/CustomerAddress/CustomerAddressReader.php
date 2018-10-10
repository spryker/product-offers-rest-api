<?php

/**
 * Copyright © 2017-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Glue\CustomersRestApi\Processor\CustomerAddress;

use Generated\Shared\Transfer\CustomerTransfer;
use Spryker\Glue\CustomersRestApi\Dependency\Client\CustomersRestApiToCustomerClientInterface;
use Spryker\Glue\CustomersRestApi\Processor\Mapper\AddressResourceMapperInterface;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceInterface;

class CustomerAddressReader implements CustomerAddressReaderInterface
{
    /**
     * @var \Spryker\Glue\CustomersRestApi\Dependency\Client\CustomersRestApiToCustomerClientInterface
     */
    protected $customerClient;

    /**
     * @var \Spryker\Glue\CustomersRestApi\Processor\Mapper\AddressResourceMapperInterface
     */
    protected $addressesResourceMapper;

    /**
     * @param \Spryker\Glue\CustomersRestApi\Dependency\Client\CustomersRestApiToCustomerClientInterface $customerClient
     * @param \Spryker\Glue\CustomersRestApi\Processor\Mapper\AddressResourceMapperInterface $addressesResourceMapper
     */
    public function __construct(
        CustomersRestApiToCustomerClientInterface $customerClient,
        AddressResourceMapperInterface $addressesResourceMapper
    ) {
        $this->customerClient = $customerClient;
        $this->addressesResourceMapper = $addressesResourceMapper;
    }

    /**
     * @param string $customerReference
     * @param \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceInterface $restResource
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceInterface
     */
    public function getAddressesByCustomerReference(string $customerReference, RestResourceInterface $restResource): RestResourceInterface
    {
        $customerTransfer = (new CustomerTransfer())->setCustomerReference($customerReference);
        $customerResponseTransfer = $this->customerClient->findCustomerByReference($customerTransfer);

        if (!$customerResponseTransfer->getHasCustomer()) {
            return $restResource;
        }

        $addressesTransfer = $this->customerClient->getAddresses($customerResponseTransfer->getCustomerTransfer());

        foreach ($addressesTransfer->getAddresses() as $addressTransfer) {
            $restResource->addRelationship(
                $this
                    ->addressesResourceMapper
                    ->mapAddressTransferToRestResource($addressTransfer, $customerResponseTransfer->getCustomerTransfer())
            );
        }

        return $restResource;
    }
}