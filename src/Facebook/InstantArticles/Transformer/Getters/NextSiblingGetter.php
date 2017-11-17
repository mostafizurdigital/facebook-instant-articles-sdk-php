<?hh // strict
/**
 * Copyright (c) 2016-present, Facebook, Inc.
 * All rights reserved.
 *
 * This source code is licensed under the license found in the
 * LICENSE file in the root directory of this source tree.
 */
namespace Facebook\InstantArticles\Transformer\Getters;

use Facebook\InstantArticles\Validators\Type;

class NextSiblingGetter extends AbstractGetter
{
    public function createFrom(array<string, string> $properties): this
    {
        if (array_key_exists('selector', $properties)) {
            $this->withSelector($properties['selector']);
        }
        if (array_key_exists('attribute', $properties)) {
            $this->withAttribute($properties['attribute']);
        }
        return $this;
    }

    public function get(\DOMNode $node): mixed
    {
        $elements = $this->findAll($node, $this->selector);
        if ($elements !== null && $elements->length > 0 && $elements->item(0) !== null) {
            $element = $elements->item(0);
            $element = $element->nextSibling;
            if ($element !== null) {
                if ($this->attribute !== null) {
                    return $element->getAttribute($this->attribute);
                }
                return $element->textContent;
            }
        }
        return null;
    }
}
