<?php

namespace MeCab;

enum NodeStat: int
{
    /**
     * Normal node defined in the dictionary.
     */
    case NOR = 0;

    /**
     * Unknown node not defined in the dictionary.
     */
    case UNK = 1;

    /**
     * Virtual node representing a beginning of the sentence.
     */
    case BOS = 2;

    /**
     * Virtual node representing a end of the sentence.
     */
    case EOS = 3;

    /**
     * Virtual node representing a end of the N-best enumeration.
     */
    case EON = 4;
}
