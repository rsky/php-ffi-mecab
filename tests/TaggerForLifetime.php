<?php

namespace MeCab;

class TaggerForLifetime extends Tagger
{
    public function __destruct()
    {
        parent::__destruct();

        throw new DebugException('destructed!');
    }
}
