<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class AttendanceController extends AbstractController
{
    private $tokenStorage;

    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    #[IsGranted('ROLE_EMPLOYEE')]
    #[Route('/attendance', name: 'app_attendance')]
    public function index(): Response
    {
        /** @var User */
        $user = $this->tokenStorage->getToken()->getUser();
        $attendances = $user->getEmployee()->getAttendances();
        return $this->render('attendance/index.html.twig', [
            'attendances' => $attendances,
        ]);
    }
}
