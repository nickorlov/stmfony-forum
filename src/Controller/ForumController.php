<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ForumController extends AbstractController
{
    /**
     * @Route("/")
     */
    public function home()
    {
        /** @var User $user */
        $user = $this->getUser();

        return $this->render('forum/homepage.html.twig', [
            'user' => $user->getFirstName()
        ]);
    }
}
