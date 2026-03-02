<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerShop\Yves\ShopCmsSlot\Dependency\Client;

use Generated\Shared\Transfer\CmsSlotStorageTransfer;

interface ShopCmsSlotToCmsSlotStorageClientInterface
{
    public function getCmsSlotByKey(string $cmsSlotKey): CmsSlotStorageTransfer;
}
