<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ProfileType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ProfileController extends AbstractController
{
    /**
     * @Route("/profile")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function profile(Request $request)
    {
        /** @var User $user */
        $user = $this->getUser();
        $form = $this->createForm(ProfileType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $avatar */
            $avatar = $form->get('avatar')->getData();
            if ($avatar) {
                $originalFilename = pathinfo($avatar->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $avatar->guessExtension();

                try {
                    $avatar->move(
                        $this->getParameter('avatars_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }
                $user->setAvatar($newFilename);
            }
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('app_profile_profile');
        }

        return $this->render('profile/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    private function generateUniqueFileName(): string
    {
        return md5(uniqid());
    }
}
