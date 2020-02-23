<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin", name="admin")
 */
class AdminActionController extends AbstractController
{
    /**
     * @Route("/", name="_user_list")
     */
    public function index()
    {
        return $this->render('admin/index.html.twig', [

        ]);
    }

    /**
     * @Route("/user/{user}", name="_user_details")
     */
    public function show($user)
    {
        return $this->render('admin/show.html.twig', [

        ]);
    }

    /**
     * @Route("/user/create", name="_user_create")
     */
    public function create()
    {
        return $this->render('admin/create.html.twig', [

        ]);
    }


    /**
     * @Route("/user/{user}/update", name="_user_update")
     */
    public function update($user)
    {
        return $this->render('admin/update.html.twig', [

        ]);
    }

    /**
     * @Route("/user/delete", name="_user_delete")
     */
    public function delete()
    {

    }
}
