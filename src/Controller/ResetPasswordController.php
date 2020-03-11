<?php

namespace App\Controller;

use App\Entity\User;
<<<<<<< HEAD
use App\Form\ResetPasswordType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
=======
use App\Form\PasswordResetType;
use App\Form\RegistrationFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
>>>>>>> master

class ResetPasswordController extends AbstractController
{
    /**
<<<<<<< HEAD
     * @Route("/reset", name="reset")
     */
    public function index()
    {
        return $this->render('set_password/reset.html.twig', [
            'controller_name' => 'ResetPasswordController',
        ]);
    }
}
=======
     * @Route("reset", name="reset")
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @return RedirectResponse|Response
     */
    public function reset(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        // similar to registration controller
        $user = new User();
        // Get entered email for check
        $userEmail = $request->request->get('password_reset'){'email'};
        
        $form = $this->createForm(PasswordResetType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {

            // If email in database, get it and update the password
            $userSelected = $this->getDoctrine()->getRepository(User::class)->findBy(['email' => $userEmail]);
            if ($userSelected) {
                $user = $userSelected[0];
                // encode the plain password
                $user->setPassword(
                    $passwordEncoder->encodePassword(
                        $user,
                        $form->get('password')->getData()
                    )
                );

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($user);
                $entityManager->flush();

                // do anything else you need here, like send an email

                return $this->redirectToRoute('app_login');
            }
            else {
                throw(new Exception('error Message'));
            }

        }

        return $this->render('reset_password/reset.html.twig', [
            'resetPasswordForm' => $form->createView(),
        ]);
    }
}
>>>>>>> master
