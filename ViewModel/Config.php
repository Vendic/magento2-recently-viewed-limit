<?php

declare(strict_types=1);

namespace Vendic\RecentlyViewedLimit\ViewModel;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Store\Model\ScopeInterface;

class Config implements ArgumentInterface
{
    private const STORAGE_LIMIT_PATH = 'catalog/recently_products/storage_limit';
    private const VIEWED_COUNT_PATH = 'catalog/recently_products/viewed_count';
    private const DEFAULT_STORAGE_LIMIT = 10;

    public function __construct(
        private readonly ScopeConfigInterface $scopeConfig
    ) {
    }

    public function getStorageLimit(): int
    {
        $storageLimit = (int) $this->scopeConfig->getValue(self::STORAGE_LIMIT_PATH, ScopeInterface::SCOPE_STORE)
            ?: self::DEFAULT_STORAGE_LIMIT;
        $viewedCount = (int) $this->scopeConfig->getValue(self::VIEWED_COUNT_PATH, ScopeInterface::SCOPE_STORE);

        return max($storageLimit, $viewedCount);
    }
}
