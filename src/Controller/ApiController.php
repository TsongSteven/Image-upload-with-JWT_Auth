<?php

namespace App\Controller;

use App\Entity\Tags;
use App\Entity\ImageStock;
use App\Repository\ImageStockRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\File\Stream;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class ApiController extends AbstractController
{
    /**
     * @Route("/", name="a_pi")
     */
    public function index(): Response
    {
        $array = [
            'Urls'=>'Test Urls',
            "/api/fetch/search_name" => "Fetch Image with name/tags",
            "/api/login" => "Login Path",
            "/api/admin/post" => "Post Image"
        ];

        return $this->json($array);
    }


    // /**
    //  * @Route("/api/fetchall", name="api_fetchall", methods={"GET"})
    //  */
    // public function fetchall_api(){
    //     $posts = new ImageStock();
    //     $posts = $this->getDoctrine()->getRepository(ImageStock::class)->findAll();
    //     // foreach($posts as $post){
    //     //     $res = $post;
    //     // }
    //     // $tags = $res->getTags();
    //     // $imp_tags = explode(" ",$tags);
    //     dump($posts);
    //     return $this->json($posts);
    // } 

    /**
     * @Route("/api/fetch/{search_name}", name="api_fetch", methods={"GET"})
     */
    public function fetch_api($search_name, ImageStockRepository $repo){
 
        $posts = $repo->tagOrName($search_name);
        $image_path = $this->getParameter('images');
        
        foreach($posts as $post){
            $image = file_get_contents($image_path .'/'.$post->getImageName());
            $res = [
                'id' => $post->getId(),
                'image_name' => $post->getImageName(),
                'image_file_base64' => base64_encode($image)
            ];
        }
        if(!$posts ){
            return $this->json("Image Not Found");
        }
        return $this->json($res);
    }           
}
