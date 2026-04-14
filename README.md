# Vendic Recently Viewed Limit

Magento 2 module that limits the number of recently viewed products stored in localStorage and synced to the backend.

## Problem

Magento 2 core has no limit on how many recently viewed products accumulate in localStorage. A bot, browser automation tool, or simply a long browsing session can store thousands of entries. This causes:

- **Bloated localStorage** — the `recently_viewed_product` key grows unbounded (60KB+ for 1000 products)
- **Massive POST requests** — every page load sends all stored product IDs to `/catalog/product/frontend_action_synchronize` (uncached)
- **Database hammering** — `syncActions()` runs individual DELETE + INSERT queries per product in a loop
- **DoS vulnerability** — an attacker can craft a direct POST with thousands of product IDs to overload the server

This affects **all Magento 2 projects** using the default Luma theme or any theme that relies on the core recently viewed functionality.

## Solution

This module caps recently viewed products at **10 items** across three layers:

| Layer | File | What it does |
|---|---|---|
| Frontend (IDs) | `ids-storage-mixin.js` | Limits the `recently_viewed_product` localStorage object to 10 entries, keeping the most recent |
| Frontend (HTML) | `recently-viewed-mixin.js` | Limits the `recently-viewed-products` localStorage arrays (sku + html) to 10 entries |
| Backend | `LimitSyncRequest.php` | Plugin on `Synchronize` controller that truncates incoming POST data to 10 products |

The frontend mixins protect regular users from accumulating data. The backend plugin protects the server from direct POST attacks that bypass the browser.

## Installation

### Via Composer

```bash
composer require vendic/magento2-recently-viewed-limit
bin/magento setup:upgrade
bin/magento cache:flush
```

### Manual

Copy the module files to `app/code/Vendic/RecentlyViewedLimit/` and run:

```bash
bin/magento setup:upgrade
bin/magento cache:flush
```

## Compatibility

- Magento 2.4.x
- PHP 8.1+

## License

MIT
