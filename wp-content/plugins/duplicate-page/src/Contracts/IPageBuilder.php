<?php

namespace DuplicatePage\Contracts;

interface IPageBuilder {
    public function isSupported($post_id): bool;
    public function duplicateContent($from_post_id, $to_post_id): bool;
}
