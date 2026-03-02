<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerShop\Yves\ShopCmsSlot\Business;

use Generated\Shared\Transfer\CmsSlotContentResponseTransfer;
use Generated\Shared\Transfer\CmsSlotContextTransfer;

interface CmsSlotDataProviderInterface
{
    public function getSlotContent(CmsSlotContextTransfer $cmsSlotContextTransfer): CmsSlotContentResponseTransfer;
}
