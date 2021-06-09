<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Client\ProductReview\Plugin\Elasticsearch\QueryExpander;

use Elastica\Query;
use Spryker\Client\Kernel\AbstractPlugin;
use Spryker\Client\SearchExtension\Dependency\Plugin\QueryExpanderPluginInterface;
use Spryker\Client\SearchExtension\Dependency\Plugin\QueryInterface;

class BatchProductRatingAggregationQueryExpanderPlugin extends AbstractPlugin implements QueryExpanderPluginInterface
{
    /**
     * {@inheritDoc}
     * - Expands base query by aggregations product and rating
     *
     * @api
     *
     * @param \Spryker\Client\SearchExtension\Dependency\Plugin\QueryInterface $searchQuery
     * @param array $requestParameters
     *
     * @return \Spryker\Client\Search\Dependency\Plugin\QueryInterface
     */
    public function expandQuery(QueryInterface $searchQuery, array $requestParameters = [])
    {
        return $this->addProductRatingAggregation($searchQuery);

        return $searchQuery;
    }

    /**
     * @param \Elastica\Query $query
     *
     * @return \Elastica\Query
     */
    protected function addProductRatingAggregation(QueryInterface $searchQuery): QueryInterface
    {
        $prodcutAggregation = $this->getFactory()->createBatchRatingAggregation()->createAggregation();

        return $query->addAggregation($prodcutAggregation);
    }
}
