<?php

namespace MeCab;

class NodeTest extends MeCabBaseTestCase
{
    private Node $bos;
    private Node $first;

    protected function setUp(): void
    {
        parent::setUp();

        $this->bos = $this->createTagger()->parseToNode(self::SAMPLE_TEXT);
        $this->first = $this->bos->next();
    }

    public function testPrev(): void
    {
        $prev = $this->first->prev();
        $this->assertInstanceOf(Node::class, $prev);
        $this->assertSame(NodeStat::BOS, $prev->stat());
        $this->assertSame('', $prev->surface());
    }

    public function testNext(): void
    {
        $next = $this->first->next();
        $this->assertInstanceOf(Node::class, $next);
        $this->assertSame(NodeStat::NOR, $next->stat());
        $this->assertSame('は', $next->surface());
    }

    public function testENext(): void
    {
        $eNext = $this->first->eNext();
        $this->assertNull($eNext);
    }

    public function testBNext(): void
    {
        $bNext = $this->first->bNext();
        $this->assertInstanceOf(Node::class, $bNext);
        $this->assertSame(NodeStat::NOR, $bNext->stat());
        $this->assertSame('全', $bNext->surface());
    }

    public function testRPath(): void
    {
        $rPath = $this->first->rPath();
        $this->assertNull($rPath);
    }

    public function testLPath(): void
    {
        $lPath = $this->first->lPath();
        $this->assertNull($lPath);
    }

    public function testSurface(): void
    {
        $all = $this->first;
        $cat = $all->next()->next();
        $for = $cat->next()->next()->next();

        $this->assertSame('全て', $all->surface());
        $this->assertSame('ため', $for->surface());
        $this->assertSame('猫', $cat->surface());
    }

    public function testFeature(): void
    {
        $all = $this->first;
        $cat = $all->next()->next();
        $for = $cat->next()->next()->next();

        $this->assertSame('名詞,副詞可能,*,*,*,*,全て,スベテ,スベテ', $all->feature());
        $this->assertSame('名詞,非自立,副詞可能,*,*,*,ため,タメ,タメ', $for->feature());
        $this->assertSame('名詞,一般,*,*,*,*,猫,ネコ,ネコ', $cat->feature());
    }

    public function testId(): void
    {
        $this->assertSame(0, $this->bos->id());
    }

    public function testLength(): void
    {
        $this->assertSame(0, $this->bos->length());
    }

    public function testRLength(): void
    {
        $this->assertSame(0, $this->bos->rLength());
    }

    public function testRcAttr(): void
    {
        $this->assertSame(0, $this->bos->rcAttr());
    }

    public function testLcAttr(): void
    {
        $this->assertSame(0, $this->bos->lcAttr());
    }

    public function testPosId(): void
    {
        $this->assertSame(0, $this->bos->posId());
    }

    public function testCharType(): void
    {
        $this->assertSame(0, $this->bos->charType());
    }

    public function testStat(): void
    {
        $this->assertSame(NodeStat::BOS, $this->bos->stat());
    }

    public function testIsBest(): void
    {
        $this->assertTrue($this->bos->isBest());
    }

    public function testAlpha(): void
    {
        $this->assertSame(0.0, $this->bos->alpha());
    }

    public function testBeta(): void
    {
        $this->assertSame(0.0, $this->bos->beta());
    }

    public function testProb(): void
    {
        $this->assertSame(0.0, $this->bos->prob());
    }

    public function testWCost(): void
    {
        $this->assertSame(0, $this->bos->wCost());
    }

    public function testCost(): void
    {
        $this->assertSame(0, $this->bos->cost());
    }
}
