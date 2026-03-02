<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerShop\Yves\ShopCmsSlot;

use Spryker\Yves\Kernel\AbstractFactory;
use SprykerShop\Yves\ShopCmsSlot\Business\CmsSlotDataProvider;
use SprykerShop\Yves\ShopCmsSlot\Business\CmsSlotDataProviderInterface;
use SprykerShop\Yves\ShopCmsSlot\Dependency\Client\ShopCmsSlotToCmsSlotClientInterface;
use SprykerShop\Yves\ShopCmsSlot\Dependency\Client\ShopCmsSlotToCmsSlotStorageClientInterface;
use SprykerShop\Yves\ShopCmsSlot\Twig\Node\ShopCmsSlotNodeBuilder;
use SprykerShop\Yves\ShopCmsSlot\Twig\Node\ShopCmsSlotNodeBuilderInterface;
use SprykerShop\Yves\ShopCmsSlot\Twig\TokenParser\ShopCmsSlotTokenParser;

/**
 * @method \SprykerShop\Yves\ShopCmsSlot\ShopCmsSlotConfig getConfig()
 */
class ShopCmsSlotFactory extends AbstractFactory
{
    public function createShopCmsSlotTokenParser(): ShopCmsSlotTokenParser
    {
        return new ShopCmsSlotTokenParser($this->createShopCmsSlotNodeBuilder());
    }

    public function createShopCmsSlotNodeBuilder(): ShopCmsSlotNodeBuilderInterface
    {
        return new ShopCmsSlotNodeBuilder();
    }

    public function createCmsSlotDataProvider(): CmsSlotDataProviderInterface
    {
        return new CmsSlotDataProvider(
            $this->getCmsSlotContentPlugins(),
            $this->getCmsSlotClient(),
            $this->getCmsSlotStorageClient(),
            $this->getConfig(),
        );
    }

    /**
     * @return array<string, \SprykerShop\Yves\ShopCmsSlotExtension\Dependency\Plugin\CmsSlotContentPluginInterface>
     */
    public function getCmsSlotContentPlugins(): array
    {
        return $this->getProvidedDependency(ShopCmsSlotDependencyProvider::PLUGINS_CMS_SLOT_CONTENT);
    }

    public function getCmsSlotClient(): ShopCmsSlotToCmsSlotClientInterface
    {
        return $this->getProvidedDependency(ShopCmsSlotDependencyProvider::CLIENT_CMS_SLOT);
    }

    public function getCmsSlotStorageClient(): ShopCmsSlotToCmsSlotStorageClientInterface
    {
        return $this->getProvidedDependency(ShopCmsSlotDependencyProvider::CLIENT_CMS_SLOT_STORAGE);
    }
}
