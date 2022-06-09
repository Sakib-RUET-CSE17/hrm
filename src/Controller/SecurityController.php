<?php

namespace App\Controller;

use App\Entity\Admin;
use App\Repository\AdminRepository;
use App\Security\AppAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    private function getJwtKey($client): string
    {
        try {
            $response = $client->request(
                'GET',
                'https://www.googleapis.com/robot/v1/metadata/x509/securetoken@system.gserviceaccount.com',
            );
            $content = $response->toArray();
            // dd($content);
            $key = array_values($content)[0];
            // $key

            return $key;
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    #[Route(path: '/firebase_auth/{authToken}/{email}', name: 'firebase_auth')]
    public function firebaseAuth(
        Request $request,
        $authToken,
        $email,
        AdminRepository $userRep,
        UserAuthenticatorInterface $userAuthenticator,
        AppAuthenticator $authenticator,
        EntityManagerInterface $entityManager,
        HttpClientInterface $client,
        RequestStack $requestStack
    ) {
        $session = $requestStack->getSession();
        $key = $session->get('jwtKey');
        if (!$key) {
            $key = $this->getJwtKey($client);
            $session->set('jwtKey', `$key`);
        }
        // dd($key);
        $decoded = JWT::decode($authToken, new Key($key, 'RS256'));
        $uid = $decoded->user_id;

        $user = $userRep->findOneBy(['firebaseUid' => $uid]);

        if ($user) {
        } else {
            $user = new Admin();
            $user->setRoles(['ROLE_ADMIN']);
            $user->setFirebaseUid($uid);
            $user->setUsername($email);
            $entityManager->persist($user);
            $entityManager->flush();
        }

        return $userAuthenticator->authenticateUser(
            $user,
            $authenticator,
            $request
        );
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
