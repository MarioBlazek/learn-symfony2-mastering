<?php

namespace MB\ApplicationBundle\Tests\Entity;

use MB\ApplicationBundle\Entity\Quote;
use MB\ApplicationBundle\Entity\QuoteGateway;
use MB\ApplicationBundle\Entity\QuoteRepository;
use MB\ApplicationBundle\Entity\QuoteFactory;
use Prophecy\PhpUnit\ProphecyTestCase;

class QuoteRepositoryTest extends ProphecyTestCase
{
    const ID = 42;
    const CONTENT = '<KnightOfNi> Ni!';

    private $repository;
    private $gateway;

    public function setUp()
    {
        parent::setUp();

        $gatewayClassName = 'MB\ApplicationBundle\Entity\QuoteGateway';
        $this->gateway = $this->prophesize($gatewayClassName);
        $factory = new QuoteFactory();
        $this->repository = new QuoteRepository($this->gateway->reveal(), $factory);
    }

    public function testItPersistsTheQuote()
    {
        $quote = new Quote(self::ID, self::CONTENT);
        $this->gateway->insert(self::CONTENT)->willReturn($quote);
        $this->repository->insert(self::CONTENT);

        $this->gateway->findAll()->willReturn(array($quote));
        $quotes = $this->repository->findAll();
        $foundQuote = $quotes['quotes'][self::ID];

        $this->assertSame(self::CONTENT, $foundQuote['content']);
    }
}