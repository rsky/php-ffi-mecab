<?php

namespace MeCab;

use FFI\CData;

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
