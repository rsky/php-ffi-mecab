<?php

namespace MeCab\Common;

use FFI\CData;
use MeCab\Path;
use MeCab\Tagger;

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
