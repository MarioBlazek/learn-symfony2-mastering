<?php

namespace MB\ApplicationBundle\Tests\Entity;

use MB\ApplicationBundle\Entity\QuoteGateway;
use MB\ApplicationBundle\Entity\QuoteRepository;
use MB\ApplicationBundle\Entity\QuoteFactory;

class QuoteRepositoryTest extends \PHPUnit_Framework_TestCase
{
    const CONTENT = '<KnightOfNi> Ni!';

    private $repository;

    public function setUp()
    {
        $filename = '/tmp/fortune_database_test.txt';
        $gateway = new QuoteGateway($filename);
        $factory = new QuoteFactory();
        $this->repository = new QuoteRepository($gateway, $factory);
    }

    public function testItPersistsTheQuote()
    {
        $quote = $this->repository->insert(self::CONTENT);
        $id = $quote['quote']['id'];
        $quotes = $this->repository->findAll();
        $foundQuote = $quotes['quotes'][$id];

        $this->assertSame(self::CONTENT, $foundQuote['content']);
    }
}