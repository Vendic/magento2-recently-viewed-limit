<?php

declare(strict_types=1);

namespace Vendic\RecentlyViewedLimit\Plugin;

use Magento\Catalog\Controller\Product\Frontend\Action\Synchronize;
use Magento\Framework\App\RequestInterface;
use Vendic\RecentlyViewedLimit\ViewModel\Config;

class LimitSyncRequest
{
    public function __construct(
        private readonly RequestInterface $request,
        private readonly Config $config
    ) {
    }

    public function beforeExecute(Synchronize $subject): void
    {
        $limit = $this->config->getStorageLimit();
        $productsData = $this->request->getParam('ids', []);

        if (is_array($productsData) && count($productsData) > $limit) {
            $this->request->setParams([
                'ids' => array_slice($productsData, 0, $limit, true)
            ]);
        }
    }
}
