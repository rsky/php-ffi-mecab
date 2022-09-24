<?php

namespace MeCab;

class NodeTest extends MeCabBaseTestCase
{
    private Node $node;

    protected function setUp(): void
    {
        parent::setUp();

        $this->node = $this->createTagger()->parseToNode('全ては猫様のために');
    }

    public function testPrev(): void
    {
        $this->assertNull($this->node->prev());
    }

    public function testNext(): void
    {
        $this->assertInstanceOf(Node::class, $this->node->next());
    }

    public function testENext(): void
    {
        $this->assertNull($this->node->eNext());
    }

    public function testBNext(): void
    {
        $this->assertNull($this->node->bNext());
    }

    public function testSurface(): void
    {
        $this->assertSame('', $this->node->surface());
    }

    public function testFeature(): void
    {
        $this->assertSame('BOS/EOS,*,*,*,*,*,*,*,*', $this->node->feature());
    }

    public function testId(): void
    {
        $this->assertSame(0, $this->node->id());
    }

    public function testLength(): void
    {
        $this->assertSame(0, $this->node->length());
    }

    public function testRLength(): void
    {
        $this->assertSame(0, $this->node->rLength());
    }

    public function testRcAttr(): void
    {
        $this->assertSame(0, $this->node->rcAttr());
    }

    public function testLcAttr(): void
    {
        $this->assertSame(0, $this->node->lcAttr());
    }

    public function testPosId(): void
    {
        $this->assertSame(0, $this->node->posId());
    }

    public function testCharType(): void
    {
        $this->assertSame(0, $this->node->charType());
    }

    public function testStat(): void
    {
        $this->assertSame(NodeStat::BOS, $this->node->stat());
    }

    public function testIsBest(): void
    {
        $this->assertTrue($this->node->isBest());
    }

    public function testAlpha(): void
    {
        $this->assertSame(0.0, $this->node->alpha());
    }

    public function testBeta(): void
    {
        $this->assertSame(0.0, $this->node->beta());
    }

    public function testProb(): void
    {
        $this->assertSame(0.0, $this->node->prob());
    }

    public function testWCost(): void
    {
        $this->assertSame(0, $this->node->wCost());
    }

    public function testCost(): void
    {
        $this->assertSame(0, $this->node->cost());
    }
}
