<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route(name="security")
 */
class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="_login")
     */
    public function index()
    {
        return $this->render('security/login.html.twig', [

        ]);
    }
}
