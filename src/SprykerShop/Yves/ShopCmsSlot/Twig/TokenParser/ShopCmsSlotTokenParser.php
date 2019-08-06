<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerShop\Yves\ShopCmsSlot\Twig\TokenParser;

use SprykerShop\Yves\ShopCmsSlot\Twig\Node\ShopCmsSlotNode;
use Twig\Node\Node;
use Twig\Token;
use Twig\TokenParser\AbstractTokenParser;
use Twig\TokenStream;

class ShopCmsSlotTokenParser extends AbstractTokenParser
{
    public const NODE_AUTOFULFILLED = 'autofulfilled';
    public const NODE_REQUIRED = 'required';
    public const NODE_WITH = 'with';
    protected const PARAMETER_NAME_AUTOFULFILLED = 'autofulfilled';
    protected const PARAMETER_NAME_REQUIRED = 'required';
    protected const PARAMETER_NAME_WITH = 'with';

    /**
     * @return string
     */
    public function getTag(): string
    {
        return 'cms_slot';
    }

    /**
     * @param \Twig\Token $token
     *
     * @return \SprykerShop\Yves\ShopCmsSlot\Twig\Node\ShopCmsSlotNode|\Twig_NodeInterface
     */
    public function parse(Token $token)
    {
        $stream = $this->parser->getStream();
        $nodes = [];
        $attributes = [];

        $cmsSlotKey = $stream->expect(Token::STRING_TYPE)->getValue();

        $parameterAutofulfilled = $this->parseAutofulfilled($stream);

        if ($parameterAutofulfilled) {
            $nodes[static::NODE_AUTOFULFILLED] = $parameterAutofulfilled;
        }

        $parameterRequired = $this->parseRequired($stream);

        if ($parameterRequired) {
            $nodes[static::NODE_REQUIRED] = $parameterRequired;
        }

        $parameterWith = $this->parseWith($stream);

        if ($parameterWith) {
            $nodes[static::NODE_WITH] = $parameterWith;
        }

        $stream->expect(Token::BLOCK_END_TYPE);

        return new ShopCmsSlotNode($cmsSlotKey, $nodes, $attributes, $token->getLine(), $this->getTag());
    }

    /**
     * @param \Twig\TokenStream $stream
     *
     * @return \Twig\Node\Node|null
     */
    protected function parseAutofulfilled(TokenStream $stream): ?Node
    {
        if (!$stream->nextIf(Token::NAME_TYPE, static::PARAMETER_NAME_AUTOFULFILLED)) {
            return null;
        }

        return $this->parser->getExpressionParser()->parseExpression();
    }

    /**
     * @param \Twig\TokenStream $stream
     *
     * @return \Twig\Node\Node|null
     */
    protected function parseRequired(TokenStream $stream): ?Node
    {
        if (!$stream->nextIf(Token::NAME_TYPE, static::PARAMETER_NAME_REQUIRED)) {
            return null;
        }

        return $this->parser->getExpressionParser()->parseExpression();
    }

    /**
     * @param \Twig\TokenStream $stream
     *
     * @return \Twig\Node\Node|null
     */
    protected function parseWith(TokenStream $stream): ?Node
    {
        if (!$stream->nextIf(Token::NAME_TYPE, static::PARAMETER_NAME_WITH)) {
            return null;
        }

        return $this->parser->getExpressionParser()->parseExpression();
    }
}
