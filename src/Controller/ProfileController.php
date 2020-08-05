<?php

namespace App\Controller;

use App\Form\ProfileType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ProfileController extends AbstractController
{
    /**
     * @Route("/profile")
     */
    public function profile()
    {
        $form = $this->createForm(ProfileType::class);

        return $this->render('profile/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
