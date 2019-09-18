<?php
// todo review

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerShop\Yves\ShopCmsSlot\Business;

use Generated\Shared\Transfer\CmsSlotContentRequestTransfer;
use Generated\Shared\Transfer\CmsSlotContextTransfer;
use Generated\Shared\Transfer\CmsSlotContentResponseTransfer;
use SprykerShop\Yves\ShopCmsSlot\Dependency\Client\ShopCmsSlotToCmsSlotClientInterface;
use SprykerShop\Yves\ShopCmsSlot\Exception\MissingRequiredParameterException;
use SprykerShop\Yves\ShopCmsSlotExtension\Dependency\Plugin\CmsSlotContentPluginInterface;

class CmsSlotDataProvider implements CmsSlotDataProviderInterface
{
    /**
     * @var \SprykerShop\Yves\ShopCmsSlotExtension\Dependency\Plugin\CmsSlotContentPluginInterface
     */
    protected $cmsSlotContentPlugin;

    /**
     * @var \SprykerShop\Yves\ShopCmsSlot\Dependency\Client\ShopCmsSlotToCmsSlotClientInterface
     */
    protected $cmsSlotClient;

    /**
     * @param \SprykerShop\Yves\ShopCmsSlotExtension\Dependency\Plugin\CmsSlotContentPluginInterface $cmsSlotContentPlugin
     * @param \SprykerShop\Yves\ShopCmsSlot\Dependency\Client\ShopCmsSlotToCmsSlotClientInterface $cmsSlotClient
     */
    public function __construct(
        CmsSlotContentPluginInterface $cmsSlotContentPlugin,
        ShopCmsSlotToCmsSlotClientInterface $cmsSlotClient
    ) {
        $this->cmsSlotContentPlugin = $cmsSlotContentPlugin;
        $this->cmsSlotClient = $cmsSlotClient;
    }

    /**
     * @param \Generated\Shared\Transfer\CmsSlotContextTransfer $cmsSlotContextTransfer
     *
     * @return \Generated\Shared\Transfer\CmsSlotContentResponseTransfer
     */
    public function getSlotContent(CmsSlotContextTransfer $cmsSlotContextTransfer): CmsSlotContentResponseTransfer
    {
        $providedData = $cmsSlotContextTransfer->getProvidedData();

        $this->assureProvidedHasRequiredKeys($providedData, $cmsSlotContextTransfer->getRequiredKeys());

        $autoFilledKeys = $cmsSlotContextTransfer->getAutoFilledKeys();

        if ($autoFilledKeys) {
            $autoFilledData = $this->cmsSlotClient->getCmsSlotExternalDataByKeys($autoFilledKeys)->getValues();
            $providedData = $autoFilledData + $providedData;
        }

        $cmsSlotContentRequestTransfer = (new CmsSlotContentRequestTransfer())
            ->setCmsSlotKey($cmsSlotContextTransfer->getCmsSlotKey())
            ->setParams($providedData);

        return $this->cmsSlotContentPlugin->getSlotContent($cmsSlotContentRequestTransfer);
    }

    /**
     * @param array $provided
     * @param string[] $requiredKeys
     *
     * @throws \SprykerShop\Yves\ShopCmsSlot\Exception\MissingRequiredParameterException
     *
     * @return void
     */
    protected function assureProvidedHasRequiredKeys(array $provided, array $requiredKeys): void
    {
        if (!$requiredKeys) {
            return;
        }

        foreach ($requiredKeys as $requiredKey) {
            if (!isset($provided[$requiredKey])) {
                throw new MissingRequiredParameterException(
                    sprintf('The "%s" param is missing in the provided data', $requiredKey)
                );
            }
        }
    }
}