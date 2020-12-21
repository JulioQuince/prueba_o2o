<?php

namespace App\Controller;

use App\Entity\Beer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class BeerController extends AbstractController
{
    /**
     * @Route("/beers/{food}", name="getBeersByFood")
     */
    public function getByFood($food): Response
    {
        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];

        $serializer = new Serializer($normalizers,$encoders);

        $filtered_beers_json = $this->getDoctrine()->getRepository(Beer::class)->getByFood($food);

        if($filtered_beers_json != null){
            $filtered_beers_array = json_decode($filtered_beers_json);

            $reponse_filtered_beers_array = array();

            foreach ($filtered_beers_array as $filtered_beers_object){
                $beer = new Beer();
                $beer->setId($filtered_beers_object->id);
                $beer->setName($filtered_beers_object->name);
                $beer->setDescription($filtered_beers_object->description);

                $reponse_filtered_beers_array[] = $beer;
            }

            $json_content = $serializer->serialize($reponse_filtered_beers_array,'json');

            $response = new Response(json_encode($json_content));
            $response->headers->set('Content-Type', 'application/json');

            return $response;
        }

        return new JsonResponse(null);
    }

    /**
     * @Route("/beers", name="getBeers")
     */
    public function getBeers(){
        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];

        $serializer = new Serializer($normalizers,$encoders);

        $beers_json = $this->getDoctrine()->getRepository(Beer::class)->getFoods();

        if($beers_json != null){
            $beers_array = json_decode($beers_json);

            $reponse_beers_array = array();

            foreach ($beers_array as $beers_object){
                $beer = new Beer();
                $beer->setId($beers_object->id);
                $beer->setName($beers_object->name);
                $beer->setDescription($beers_object->description);
                $beer->setImage($beers_object->image_url);
                $beer->setTagline($beers_object->tagline);
                $beer->setFirstBrewed($beers_object->first_brewed);

                $reponse_beers_array[] = $beer;
            }

            $json_content = $serializer->serialize($reponse_beers_array,'json');

            $response = new Response(json_encode($json_content));
            $response->headers->set('Content-Type', 'application/json');

            return $response;
        }

        return new JsonResponse(null);
    }
}
