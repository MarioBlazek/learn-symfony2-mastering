<?php

namespace MB\ApplicationBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route as Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class QuoteController extends Controller
{
    /**
     * @Route("/api/quotes", name="api_quotes_add", methods={"POST"})
    */
    public function submitAction(Request $request)
    {
        $postedValues = $request->request->all();

        if (empty($postedValues['content'])) {
            $answer = array('message' => 'Missing required parameter: content');

            return new JsonResponse($answer, Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $quoteRepository = $this->container->get('mb_application.quote_repository');
        $quote = $quoteRepository->insert($postedValues['content']);

        return new JsonResponse($quote, Response::HTTP_CREATED);
    }

    /**
     * @Route("/api/quotes", name="api_qoutes_show", methods={GET})
     */
    public function listAction()
    {
        $quoteRepository = $this->get('mb_application.quote_repository');
        $quotes = $quoteRepository->findAll();

        return new JsonResponse($quotes, Response::HTTP_OK);
    }
}