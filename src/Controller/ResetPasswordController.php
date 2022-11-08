<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;
use App\Entity\ResetPassword;
use Symfony\Component\Validator\Constraints\DateTime;

class ResetPasswordController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $em){
        $this->entityManager = $em;
    }

    /**
     * @Route("/mot-de-passe-oublier", name="reset_password")
     */
    public function index(Request $request): Response
    {
        if($this->getUser()) {
            return $this->redirectToRoute('home');
        }

        if($request->get('email')) {
            $user = $this->entityManager->getRepository(User::class)->findOneByEmail($request->get('email'));
            $restPassword = new ResetPassword();
            
            if($user) {
                
                $restPassword->setUser($user);
                $restPassword->setToken(uniqId());
                $restPassword->setCreatedAt(new \DateTime());

                $this->entityManager->persist($restPassword);
                $this->entityManager->flush();
            }

            $url = $this->generateUrl('update_password', [
                'token' => $restPassword->getToken()
            ]);

            dd($url);
        }

        
        return $this->render('reset_password/index.html.twig');
    }

    /**
     * @Route("/modifier-mot-de-passe/{token}", name="update_password")
     */
    public function updatePassword($token) {
        
        $reset = $this->entityManager->getRepository(ResetPassword::class)->findOneByToken($token);

        $now = new \DateTime();
        if($now < $reset->getCreatedAt()->modify('+ 10 minute')) {
            dd($reset->getCreatedAt()->modify('+ 10 minute'));
        }
        dd($now);
    }
}
