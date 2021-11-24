<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasher;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Security;

class LoginController extends AbstractController
{

    /**
     * @var Security
     */
    private $security;

    public function __construct(Security $security)
    {
       $this->security = $security;
    }

    /**
    * @Route("/api/login", name="login", methods={"POST"})
    */
   public function login(JWTTokenManagerInterface $jwt, UserRepository $userRepo, UserPasswordHasherInterface $encoder, Request $request)
   {
    $parameter = json_decode($request->getContent(), true);
                $user = $userRepo->findOneBy([
                    'username'=>$parameter['username'],
            ]);

            if (!$user || !$encoder->isPasswordValid($user, $parameter['username'])) {
                    return $this->json([
                        'message' => 'username or password is wrong.',
                    ]);
            }
            return $this->json([
                'message' => 'Logged In!',
                'token' => $jwt->create($user),
            ]);      
 
   }
    /**
    * @Route("/api/register", name="register", methods={"POST"})
    */   
   public function register(Request $request, UserPasswordHasherInterface $encoder)
   {
       $em = $this->getDoctrine()->getManager();
       $parameter = json_decode($request->getContent(), true);
       $username = $parameter["username"];
       $password = $parameter["password"];

       if (empty($username) || empty($password) ){
           return $this->respondValidationError("Invalid Username or Password");
       }
       $user = new User();
       $user->setPassword($encoder->hashPassword($user, $password));
       $user->setUsername($username);
       $em->persist($user);
       $em->flush();
       return $this->json(sprintf('User %s successfully created', $user->getUsername()));
   } 

    /**
     * @Route("/api/logout", name="app_logout", methods={"GET"})
     */
    public function logout(): void
    {
        throw new \Exception('Logged Out');
    }     
}
