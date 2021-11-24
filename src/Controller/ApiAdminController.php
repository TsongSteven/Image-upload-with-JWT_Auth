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
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\User\UserInterface;


class ApiAdminController extends AbstractController
{

    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }
    /**
     * @Route("/api/admin/post", name="api_post", methods={"POST"})
     */
    public function post_api(Request $request, SluggerInterface $slug, TokenStorageInterface $token): Response
    {   
        // $user = $this->security->getUser();
        // dd($token);

        $posts = new ImageStock(); 
        
        $parameter = json_decode($request->getContent(), true);
        // dd($request->get('image_name'));
        $image_file = $request->files->get('image_name');
        $tags = $request->get('tags');
        // dd($tags); 
        $originalFileName = pathinfo($image_file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFileName = $slug->slug($originalFileName);
        $newFileName = $safeFileName.'-'.uniqid().'.'.$image_file->guessExtension();
        $image_file->move(
            $this->getParameter('images'),
            $newFileName
        );
        $posts->setImageName($newFileName);
        $tags_array = explode(" ", $tags);
        // dd($tags_array);
        foreach($tags_array as $tag){
            $tag_object = new Tags();
            $posts->addTag($tag_object->setTagName($tag));
        }
        
        $em = $this->getDoctrine()->getManager();
        $em->persist($posts);
        $em->flush();
        return $this->json([
                'Inserted Successfully!!'
        ]);
    }
}
