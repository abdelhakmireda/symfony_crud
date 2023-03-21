<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\From\RegistrationType;
use Doctrine\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\ArticleType;
use symfony\form;
class SecurityController extends AbstractController
{
    /**
     * @Route("/insription", name="security_registration")
     */
    public function registration()
    {   $user = new User();
        $form = $this->createFrom(RegistrationType::class,$user);
        return $this->render('security/index.html.twig', [
            'controller_name' => 'SecurityController',
        ]);
    }
}
