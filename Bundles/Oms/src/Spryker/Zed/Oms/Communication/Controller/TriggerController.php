<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\Oms\Communication\Controller;

use Propel\Runtime\ActiveQuery\Criteria;
use Spryker\Zed\Kernel\Communication\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

/**
 * @method \Spryker\Zed\Oms\Business\OmsFacadeInterface getFacade()
 * @method \Spryker\Zed\Oms\Persistence\OmsQueryContainerInterface getQueryContainer()
 * @method \Spryker\Zed\Oms\Communication\OmsCommunicationFactory getFactory()
 * @method \Spryker\Zed\Oms\Persistence\OmsRepositoryInterface getRepository()
 */
class TriggerController extends AbstractController
{
    protected const ROUTE_REDIRECT_DEFAULT = '/';

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function triggerEventForOrderItemsAction(Request $request)
    {
        if (!$request->isMethod(Request::METHOD_POST)) {
            return $this->redirectResponse(static::ROUTE_REDIRECT_DEFAULT);
        }

        $idOrderItem = $this->castId($request->query->getInt('id-sales-order-item'));
        $event = $request->query->get('event');
        $redirect = $request->query->get('redirect', static::ROUTE_REDIRECT_DEFAULT);

        $this->getFacade()->triggerEventForOrderItems($event, [$idOrderItem]);
        $this->addInfoMessage('Status change triggered successfully.');

        return $this->redirectResponse($redirect);
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function triggerEventForOrderAction(Request $request)
    {
        if (!$request->isMethod(Request::METHOD_POST)) {
            return $this->redirectResponse(static::ROUTE_REDIRECT_DEFAULT);
        }

        $idOrder = $this->castId($request->query->getInt('id-sales-order'));
        $event = $request->query->get('event');
        $redirect = $request->query->get('redirect', '/');
        $itemsList = $request->query->get('items');

        $orderItems = $this->getOrderItemsToTriggerAction($idOrder, $itemsList);

        $this->getFacade()->triggerEvent($event, $orderItems, []);
        $this->addInfoMessage('Status change triggered successfully.');

        return $this->redirectResponse($redirect);
    }

    /**
     * @param int $idOrder
     * @param array|null $itemsList
     *
     * @return \Orm\Zed\Sales\Persistence\SpySalesOrderItem[]|\Propel\Runtime\Collection\ObjectCollection
     */
    protected function getOrderItemsToTriggerAction($idOrder, $itemsList = null)
    {
        $query = $this->getQueryContainer()->querySalesOrderItemsByIdOrder($idOrder);

        if (is_array($itemsList) && count($itemsList) > 0) {
            $query->filterByIdSalesOrderItem($itemsList, Criteria::IN);
        }

        $orderItems = $query->find();

        return $orderItems;
    }
}
