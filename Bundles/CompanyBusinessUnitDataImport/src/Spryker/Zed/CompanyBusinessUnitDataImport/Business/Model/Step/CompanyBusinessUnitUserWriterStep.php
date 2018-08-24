<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Spryker\Zed\CompanyBusinessUnitDataImport\Business\Model\Step;

use Orm\Zed\CompanyBusinessUnit\Persistence\Map\SpyCompanyBusinessUnitTableMap;
use Orm\Zed\CompanyBusinessUnit\Persistence\SpyCompanyBusinessUnitQuery;
use Orm\Zed\CompanyUser\Persistence\SpyCompanyUserQuery;
use Spryker\Zed\CompanyBusinessUnitDataImport\Business\Model\DataSet\CompanyBusinessUnitUserDataSet;
use Spryker\Zed\DataImport\Business\Exception\EntityNotFoundException;
use Spryker\Zed\DataImport\Business\Model\DataImportStep\DataImportStepInterface;
use Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface;

class CompanyBusinessUnitUserWriterStep implements DataImportStepInterface
{
    /**
     * @param \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface $dataSet
     *
     * @throws \Pyz\Zed\DataImport\Business\Exception\EntityNotFoundException
     *
     * @return void
     */
    public function execute(DataSetInterface $dataSet)
    {
        $idCompanyBusinessUnit = $this->getIdCompanyBusinessUnitByKey($dataSet[CompanyBusinessUnitUserDataSet::COLUMN_BUSINESS_UNIT_KEY]);

        $companyUserEntity = SpyCompanyUserQuery::create()
            ->filterByKey($dataSet[CompanyBusinessUnitUserDataSet::COLUMN_COMPANY_USER_KEY])
            ->findOne();

        if ($companyUserEntity === null) {
            throw new EntityNotFoundException(sprintf('Could not find company user by key "%s"', $dataSet[CompanyBusinessUnitUserDataSet::COLUMN_COMPANY_USER_KEY]));
        }

        $companyUserEntity
            ->setFkCompanyBusinessUnit($idCompanyBusinessUnit)
            ->save();
    }

    /**
     * @param string $companyBusinessUnitKey
     *
     * @throws \Pyz\Zed\DataImport\Business\Exception\EntityNotFoundException
     *
     * @return int
     */
    protected function getIdCompanyBusinessUnitByKey(string $companyBusinessUnitKey): int
    {
        $idCompanyBusinessUnit = $this->getCompanyBusinessUnitQuery()
            ->select(SpyCompanyBusinessUnitTableMap::COL_ID_COMPANY_BUSINESS_UNIT)
            ->findOneByKey($companyBusinessUnitKey);

        if (!$idCompanyBusinessUnit) {
            throw new EntityNotFoundException(sprintf('Could not find company business unit by key "%s"', $companyBusinessUnitKey));
        }

        return $idCompanyBusinessUnit;
    }

    /**
     * @return \Orm\Zed\CompanyBusinessUnit\Persistence\SpyCompanyBusinessUnitQuery
     */
    protected function getCompanyBusinessUnitQuery(): SpyCompanyBusinessUnitQuery
    {
        return SpyCompanyBusinessUnitQuery::create();
    }
}
