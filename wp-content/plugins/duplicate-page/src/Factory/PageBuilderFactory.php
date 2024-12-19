<?php

namespace DuplicatePage\Factory;

use DuplicatePage\Contracts\IPageBuilder;
use DuplicatePage\PageBuilder\ElementorBuilder;

class PageBuilderFactory {
    private static $builders = [];

    public static function getBuilder($post_id): ?IPageBuilder {
        // Initialize builders if not done yet
        if (empty(self::$builders)) {
            self::$builders[] = new ElementorBuilder();
        }

        // Find first supporting builder
        foreach (self::$builders as $builder) {
            if ($builder->isSupported($post_id)) {
                return $builder;
            }
        }

        return null;
    }
}
