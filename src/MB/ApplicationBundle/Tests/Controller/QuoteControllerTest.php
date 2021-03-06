<?php

namespace MB\ApplicationBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class QuoteControllerTest extends WebTestCase
{
    private function post($uri, array $data)
    {
        $headers = array('CONTENT_TYPE' => 'application/json');
        $content = json_encode($data);
        $client = static::createClient(array('environment' => 'test'));
        $client->request('POST', $uri, array(), array(), $headers, $content);

        return $client->getResponse();
    }

    private function get($uri)
    {
        $headers = array('CONTENT_TYPE' => 'application/json');
        $client = static::createClient();
        $client->request('GET', $uri, array(), array(), $headers);

        return $client->getResponse();
    }

    public function testSubmitNewQuote()
    {
        $response = $this->post('/api/quotes', array('content' => '<KnightOfNi> Ni!'));
        $this->assertSame(Response::HTTP_CREATED, $response->getStatusCode());
    }

    public function testSubmitEmptyQuote()
    {
        $response = $this->post('/api/quotes', array('content' => ''));
        $this->assertSame(Response::HTTP_UNPROCESSABLE_ENTITY, $response->getStatusCode());
    }

    public function testSubmitNoQuote()
    {
        $response = $this->post('/api/quotes', array());
        $this->assertSame(Response::HTTP_UNPROCESSABLE_ENTITY, $response->getStatusCode());
    }

    public function testListingAllQuotes()
    {
        $response = $this->get('/api/quotes');

        $this->assertSame(Response::HTTP_OK, $response->getStatusCode());
    }
}