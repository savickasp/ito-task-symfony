<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin", name="admin")
 * @IsGranted("ROLE_ADMIN")
 */
class AdminActionController extends AbstractController
{
    /**
     * @Route("/", name="_user_list")
     */
    public function index(UserRepository $userRepository)
    {
        $users = $userRepository->findAll();

        if (!$users) {
            throw $this->createNotFoundException(
                'No users found'
            );
        }
        return $this->render('admin/index.html.twig', [
            'users' => $users,
        ]);
    }

    /**
     * @Route("/user/create", name="_user_create", methods={"get", "post"})s
     */
    public function create(Request $request, UserRepository $userRepository, EntityManagerInterface $em)
    {
        $error = '';

        if ($request->isMethod('POST')) {

            if ($request->get('password') !== '') {

                if ($request->get('password') === $request->get('password_confirm')) {

                    if ($request->get('name') !== '') {

                        if ($request->get('email') !== '') {

                            if (!$userRepository->findOneBy(['id' => $request->get('email')])) {

                                $user = new User();
                                $user->setName($request->get('name'));
                                $user->setemail($request->get('email'));
                                $user->setPassword($request->get('password'));
                                $user->setRoles(['ROLE_USER']);
                                $user->setActive(1);
                                $user->setLastLogin();

                                $em->persist($user);
                                $em->flush();

                                return $this->redirectToRoute('admin_user_list');
                            } else {
                                $error = 'User with this email alrady exists';
                            }
                        } else {
                            $error = 'Email field is required';

                        }
                    } else {
                        $error = 'Name field is required';
                    }
                } else {
                    $error = 'Passwords doesnt match';
                }
            } else {
                $error = 'Password fields is required';
            }
        }
        return $this->render('admin/create.html.twig', [
            'error' => $error,
        ]);
    }

    /**
     * @Route("/user/{id}", name="_user_details")
     */
    public function show(int $id, UserRepository $userRepository)
    {
        $user = $userRepository->findOneBy(['id' => $id]);

        if (!$user) {
            throw $this->createNotFoundException(
                'This user doesnt exists'
            );
        }

        return $this->render('admin/show.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/user/{id}/update", name="_user_update", methods={"post", "get"})
     */
    public function update(int $id, Request $request, EntityManagerInterface $em)
    {
        $user = $em->getRepository(User::class)->findOneBy(['id' => $id]);

        $error = '';

        if ($request->isMethod('POST')) {

            if ($request->get('password') !== '') {

                if ($request->get('password') === $request->get('password_confirm')) {

                    if ($request->get('name') !== '') {

                        if ($request->get('email') !== '') {

                            $user->setName($request->get('name'));
                            $user->setPassword($request->get('password'));

                            $em->flush();

                            return $this->redirectToRoute('admin_user_details', ['id' => $id]);
                        } else {
                            $error = 'Email field is required';

                        }
                    } else {
                        $error = 'Name field is required';
                    }
                } else {
                    $error = 'Passwords doesnt match';
                }
            } else {
                $error = 'Password fields is required';
            }
        }

        if (!$user) {
            throw $this->createNotFoundException(
                'This user doesnt exists'
            );
        }

        return $this->render('admin/update.html.twig', [
            'error' => $error,
            'user' => $user,
        ]);
    }

    /**
     * @Route("/user/{id}/delete", name="_user_delete")
     */
    public function delete(int $id, Request $request, EntityManagerInterface $em)
    {
        $error = '';

        $user = $em->getRepository(User::class)->findOneBy(['id' => $id]);

        if (!$user) {
            throw $this->createNotFoundException(
                'This user doesnt exists'
            );
        }

        if ($request->isMethod('POST')) {

            if ($request->get('string') === $request->get('confirm_string')) {

                $em->remove($user);
                $em->flush();

                return $this->redirectToRoute('admin_user_list');
            } else {
                $error = 'confirmation doesnt match';
            }
        }

        return $this->render('admin/delete.html.twig', [
            'confirmation' => rand(100000, 999999),
            'error' => $error,
            'user' => $user,
        ]);
    }
}
