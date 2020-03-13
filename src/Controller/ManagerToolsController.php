<?php

namespace App\Controller;

use App\Entity\Ticket;
use App\Entity\User;
use App\Form\RegistrationFormType;
use Doctrine\ORM\Query\ResultSetMapping;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ManagerToolsController extends AbstractController
{
    /**
     * @Route("/tools", name="manager_tools")
     */
    public function aRegister(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {

        $session = $request ->getSession(); // to work with the sessions
        $email = $session->get('email');
        $man = $this->getDoctrine()->getRepository(User::class)->findOneBy(['email' => $email]);

        $user = new User();
        // Only added these two lines

        $user->setTime(new \DateTime());
        // Manager has to choose to make agent one or two
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // encode the plain password
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('password')->getData()
                )

            );
            if(isset($_POST['one'])) {
                $user->setRoles(['ROLE_AGENT']);
            }
            else {
                $user->setRoles(['ROLE_AGENT_TWO']);
            }
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            // do anything else you need here, like send an email
        }
        $role = array("ROLE_AGENT");

        $agents = $this->getDoctrine()->getRepository(User::class)->findByRole();

        return $this->render('manager_tools/tools.html.twig', [
            'registrationForm' => $form->createView(), 'managerName' => $man, 'agents' => $agents,
        ]);
    }
}
