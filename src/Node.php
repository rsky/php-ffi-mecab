<?php

namespace MeCab;

use FFI;
use FFI\CData;

class Node
{
    /**
     * @param Tagger $tagger Nodeはメモリ上ではTaggerに保持されているので
     *                       Nodeが生きている限りは親のTaggerが解放されないように所有する
     */
    public function __construct(private readonly Tagger $tagger, private readonly CData $node)
    {
    }

    private function maybeNode(?CData $node): ?Node
    {
        if ($node === null) {
            return null;
        }
        return new self($this->tagger, $node);
    }

    /**
     * pointer to the previous node.
     */
    public function prev(): ?Node
    {
        return $this->maybeNode($this->node->prev);
    }

    /**
     * pointer to the next node.
     */
    public function next(): ?Node
    {
        return $this->maybeNode($this->node->next);
    }

    /**
     * pointer to the node which ends at the same position.
     */
    public function eNext(): ?Node
    {
        return $this->maybeNode($this->node->enext);
    }

    /**
     * pointer to the node which starts at the same position.
     */
    public function bNext(): ?Node
    {
        return $this->maybeNode($this->node->bnext);
    }

    /**
     * surface string
     */
    public function surface(): string
    {
        $length = $this->length();
        $surface = FFI::new(sprintf('char[%d]', $length + 1));
        FFI::memcpy($surface, $this->node->surface, $length);
        $surface[$length] = "\0";

        return FFI::string($surface);
    }

    /**
     * feature string
     */
    public function feature(): string
    {
        return FFI::string($this->node->feature);
    }

    /**
     * unique node id
     */
    public function id(): int
    {
        return $this->node->id;
    }

    /**
     * length of the surface form.
     */
    public function length(): int
    {
        return $this->node->length;
    }

    /**
     * length of the surface form including white space before the morph.
     */
    public function rLength(): int
    {
        return $this->node->rlength;
    }

    /**
     * right attribute id
     */
    public function rcAttr(): int
    {
        return $this->node->rcAttr;
    }

    /**
     * left attribute id
     */
    public function lcAttr(): int
    {
        return $this->node->lcAttr;
    }

    /**
     * unique part of speech id. This value is defined in "pos.def" file.
     */
    public function posId(): int
    {
        return $this->node->posid;
    }

    /**
     * character type
     */
    public function charType(): int
    {
        return $this->node->char_type;
    }

    /**
     * status of this model.
     * This value is NodeStat::NOR, NodeStat::UNK, NodeStat::BOS, NodeStat::EOS, or NodeStat::EON.
     */
    public function stat(): NodeStat
    {
        return NodeStat::from($this->node->stat);
    }

    /**
     * whether this node is best node.
     */
    public function isBest(): bool
    {
        return $this->node->isbest === 1;
    }

    /**
     * forward accumulative log summation.
     * This value is only available when MECAB_MARGINAL_PROB is passed.
     */
    public function alpha(): float
    {
        return $this->node->alpha;
    }

    /**
     * backward accumulative log summation.
     * This value is only available when MECAB_MARGINAL_PROB is passed.
     */
    public function beta(): float
    {
        return $this->node->beta;
    }

    /**
     * marginal probability.
     * This value is only available when MECAB_MARGINAL_PROB is passed.
     */
    public function prob(): float
    {
        return $this->node->prob;
    }

    /**
     * word cost.
     */
    public function wCost(): int
    {
        return $this->node->wcost;
    }

    /**
     * best accumulative cost from bos node to this node.
     */
    public function cost(): int
    {
        return $this->node->cost;
    }
}
