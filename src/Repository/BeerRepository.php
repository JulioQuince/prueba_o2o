<?php

namespace App\Repository;

use App\Entity\Beer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Beer|null find($id, $lockMode = null, $lockVersion = null)
 * @method Beer|null findOneBy(array $criteria, array $orderBy = null)
 * @method Beer[]    findAll()
 * @method Beer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BeerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Beer::class);
    }

    public function getByFood($food){
        $client = new \GuzzleHttp\Client();

        $response = $client->request('GET', 'https://api.punkapi.com/v2/beers', ['query' => 'food='.$food]);

        $status = $response->getStatusCode();

        if($status != "200"){
            return "false";
        }

        $json_data = $response->getBody()->getContents();

        return $json_data;

    }

    public function getFoods(){
        $client = new \GuzzleHttp\Client();

        $response = $client->request('GET', 'https://api.punkapi.com/v2/beers');

        $status = $response->getStatusCode();

        if($status != "200"){
            return "false";
        }

        $json_data = $response->getBody()->getContents();

        return $json_data;
    }
}
