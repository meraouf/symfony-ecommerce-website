<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class RegisterController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/inscription", name="register")
     */
    public function index(Request $request, UserPasswordEncoderInterface $encoder): Response
    {
        //étape 1 reliage  entity ($user) avec form
        $user = new User();
        $form = $this->createForm(RegisterType::class,$user); // form lié a l'instance user

      //etape 2 persistance données
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            $pwd = $user->getPassword();
            $password = $encoder->encodePassword($user, $pwd);

            $user->setPassword($password);

            $this->entityManager->persist($user);  // enregistrer dans la BDD  (figer)
            $this->entityManager->flush();  // enregister sur BDD
        }
        // étape 1 BIS  affichage de formulaire dans TWIG
        return $this->render('register/index.html.twig',[
            'form'=>$form->createView()
        ]);
    }
}
