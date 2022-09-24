<?php

namespace MeCab;

use FFI\CData;
use MeCab\Common\NodeCreatorTrait;
use MeCab\Common\PathCreatorTrait;

/**
 * FIXME: mecab_lattice_*系APIのラッパーを実装するまで利用できない
 * (非推奨のmecab_nbest_*系APIは実装しない)
 */
class Path
{
    use NodeCreatorTrait;
    use PathCreatorTrait;

    /**
     * @param Tagger $tagger Pathはメモリ上ではTaggerに保持されているので
     *                       Pathが生きている限りは親のTaggerが解放されないように所有する
     */
    public function __construct(private readonly Tagger $tagger, private readonly CData $path)
    {
    }

    protected function getTagger(): Tagger
    {
        return $this->tagger;
    }

    /**
     * pointer to the right node
     */
    public function rNode(): ?Node
    {
        return $this->maybeNode($this->path->rnode);
    }

    /**
     * pointer to the next right path
     */
    public function rNext(): ?Path
    {
        return $this->maybePath($this->path->rnext);
    }

    /**
     * pointer to the left node
     */
    public function lNode(): ?Node
    {
        return $this->maybeNode($this->path->lnode);
    }

    /**
     * pointer to the next left path
     */
    public function lNext(): ?Path
    {
        return $this->maybePath($this->path->lnext);
    }

    /**
     * local cost
     */
    public function cost(): int
    {
        return $this->path->cost;
    }

    /**
     * marginal probability
     */
    public function prob(): float
    {
        return $this->path->prob;
    }
}
