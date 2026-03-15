<?php

declare(strict_types = 1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpClient\CurlHttpClient;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TestController extends AbstractController {

    #[Route('/curl-client-test')]
    public function test() : Response {
        $defaultOptions = ['verify_host' => false, 'verify_peer' => false];
        $client = new CurlHttpClient($defaultOptions,6,50);
        $max = 10;
        $htmls = [];
        $jsons = [];
        #simulates resettable environment, e.g., messenger
        for ($i = 0; $i < $max; $i++) {
            #request that returns push responses
            $request = $client->request('GET', 'https://nghttpx:8443/index.html');
            $responseBody = $request->getContent();
            $htmls[] = $responseBody;
            #another routine
            $request = $client->request('GET', 'https://nghttpx:8443/test.json');
            $responseBody = $request->getContent();
            $jsons[] = $responseBody;

            #reset the client before processing the next message
            $client->reset();
        }
        #high chance that responses will contain the pushed responses content
        return $this->json(['jsons' => $jsons, 'htmls' => $htmls]);
    }
}
