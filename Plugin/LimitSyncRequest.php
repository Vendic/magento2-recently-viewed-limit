<?php

declare(strict_types=1);

namespace Vendic\RecentlyViewedLimit\Plugin;

use Magento\Catalog\Controller\Product\Frontend\Action\Synchronize;
use Magento\Framework\App\RequestInterface;

class LimitSyncRequest
{
    private const MAX_PRODUCTS = 10;

    public function __construct(
        private readonly RequestInterface $request
    ) {
    }

    public function beforeExecute(Synchronize $subject): void
    {
        $productsData = $this->request->getParam('ids', []);

        if (is_array($productsData) && count($productsData) > self::MAX_PRODUCTS) {
            $this->request->setParams([
                'ids' => array_slice($productsData, 0, self::MAX_PRODUCTS, true)
            ]);
        }
    }
}
