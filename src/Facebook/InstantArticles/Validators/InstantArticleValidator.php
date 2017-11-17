<?hh // strict
/**
 * Copyright (c) 2016-present, Facebook, Inc.
 * All rights reserved.
 *
 * This source code is licensed under the license found in the
 * LICENSE file in the root directory of this source tree.
 */
namespace Facebook\InstantArticles\Validators;

use Facebook\InstantArticles\Elements\Element;
use Facebook\InstantArticles\Elements\InstantArticle;
use Facebook\InstantArticles\Elements\ChildrenContainer;
use Facebook\InstantArticles\Elements\Paragraph;
use Facebook\InstantArticles\Transformer\Warnings\ValidatorWarning;

/**
 * Class that navigates thru InstantArticle object tree to validate it and report
 * warnings related to each object tree.
 */
class InstantArticleValidator
{
    /**
     * This method navigates thru the tree structure and validates the article content.
     *
     * @param InstantArticle $article The article that will be checked.
     * @return array of string with the warnings raised during the check.
     */
    public static function check(InstantArticle $article): Vector<ValidatorWarning>
    {
        $warnings = Vector {};
        return self::getReport($article->getContainerChildren(), $warnings);
    }

    /**
     * Auxiliary method to do a recursive checker that will raise all warnings
     * related to the element tree about the Instant Article.
     * @param array $elements Element[] to all elements that will be checked.
     * @param array $warnings string[] to all warnings related to the elements informed.
     */
    public static function getReport(Vector<Element> $elements, Vector<ValidatorWarning>$warnings): Vector<ValidatorWarning>
    {
        foreach ($elements as $element) {
            if (!$element->isValid() && $element->isEmptyValidationEnabled()) {
                // Adds a warning to the result report.
                $warnings->add(new ValidatorWarning($element));
            }
            if ($element instanceof ChildrenContainer) {
                self::getReport($element->getContainerChildren(), $warnings);
            }
        }
        return $warnings;
    }
}
