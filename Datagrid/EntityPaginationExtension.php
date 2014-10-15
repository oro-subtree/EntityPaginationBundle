<?php

namespace Oro\Bundle\EntityPaginationBundle\Datagrid;

use Oro\Bundle\DataGridBundle\Datagrid\Builder;
use Oro\Bundle\DataGridBundle\Extension\AbstractExtension;
use Oro\Bundle\DataGridBundle\Datasource\Orm\OrmDatasource;
use Oro\Bundle\DataGridBundle\Datagrid\Common\DatagridConfiguration;

class EntityPaginationExtension extends AbstractExtension
{
    const ENTITY_PAGINATION_PATH = '[options][entity_pagination]';

    /**
     * {@inheritdoc}
     */
    public function isApplicable(DatagridConfiguration $config)
    {
        $pagination = $config->offsetGetByPath(self::ENTITY_PAGINATION_PATH, null);

        if ($pagination === null) {
            return false;
        }

        return $config->offsetGetByPath(Builder::DATASOURCE_TYPE_PATH) == OrmDatasource::TYPE;
    }

    /**
     * {@inheritdoc}
     */
    public function processConfigs(DatagridConfiguration $config)
    {
        $pagination = $config->offsetGetByPath(self::ENTITY_PAGINATION_PATH);

        if ($pagination !== null && !is_bool($pagination)) {
            throw new \Exception('Entity pagination is not boolean');
        }

        $pagination = $pagination ? true : false;

        // replace config values by normalized
        $config->offsetSetByPath(self::ENTITY_PAGINATION_PATH, $pagination);
    }
}
