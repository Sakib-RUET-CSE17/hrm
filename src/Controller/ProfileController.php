<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class ProfileController extends AbstractController
{
    private $tokenStorage;

    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    #[IsGranted('ROLE_EMPLOYEE')]
    #[Route('/profile', name: 'app_profile')]
    public function index(): Response
    {
        /** @var User */
        $user = $this->tokenStorage->getToken()->getUser();
        $employee = $user->getEmployee();
        return $this->render('profile/index.html.twig', [
            'employee' => $employee,
        ]);
    }
}
