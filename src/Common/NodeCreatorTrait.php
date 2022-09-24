<?php

namespace MeCab\Common;

use FFI\CData;
use MeCab\Node;
use MeCab\Tagger;

trait NodeCreatorTrait
{
    protected function maybeNode(?CData $node): ?Node
    {
        if ($node === null) {
            return null;
        }
        return new Node($this->getTagger(), $node);
    }

    abstract protected function getTagger(): Tagger;
}
