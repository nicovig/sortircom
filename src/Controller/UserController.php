<?php

namespace App\Controller;

use App\Entity\Participant;
use App\Form\ParticipantType;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


class UserController extends Controller
{
    /**
     * @Route("/profile", name="update_profile")
     */
    public function updateParticipant(Request $request,
                             EntityManagerInterface $em)
    {
        $user = $this->getUser();
        $form = $this->createForm(ParticipantType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($user);
            $em->flush();

            $this->addFlash("success", "Compte modifié avec succès !");
            return $this->redirectToRoute("update_profile");
        }

        return $this->render("user/profile.html.twig", ["form" => $form->createView()]);
    }
}