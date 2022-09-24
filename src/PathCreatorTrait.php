<?php

namespace MeCab;

use FFI\CData;

trait PathCreatorTrait
{
    protected function maybePath(?CData $path): ?Path
    {
        if ($path === null) {
            return null;
        }
        return new Path($this->getTagger(), $path);
    }

    abstract protected function getTagger(): Tagger;
}
