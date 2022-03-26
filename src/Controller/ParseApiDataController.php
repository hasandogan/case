<?php

namespace App\Controller;

use App\Util\Resolver;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ParseApiDataController extends AbstractController
{
    private $resolver;
    private $client;
    private $entityManager;
    public function __construct(Resolver $resolver,HttpClientInterface $client,EntityManagerInterface $entityManager)
    {
        $this->resolver = $resolver;
        $this->client = $client;
        $this->entityManager = $entityManager;
    }

    public function parseApiData($url)
    {
        $payload = [
            'url' => $url,
            'client' => $this->client,
            'entityManager' => $this->entityManager
        ];
        $link = [
            'TrResolver' => '5d47f24c330000623fa3ebfa',
            'EnResolver' => '5d47f235330000623fa3ebf7'
        ];
        $explodeUrl = explode('v2/', $url);
        $this->resolver->send(array_search($explodeUrl[1], $link), $payload);

    }

}
