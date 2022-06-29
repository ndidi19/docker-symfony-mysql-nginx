<?php

namespace App\Controller\Admin;

use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/users', name: 'admin_users_')]
class UserController extends AbstractController {

    #[Route('/', name: 'index')]
    public function index(UserRepository $userRepository): Response {
        $users = $userRepository->findAll();
        return $this->render('admin/users/index.html.twig', compact('users'));
    }
}