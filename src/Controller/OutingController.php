<?php

namespace App\Controller;

use App\Entity\Outing;
use App\Entity\Participant;
use App\Form\CreateOutingType;
use App\Form\ParticipantType;
use App\Repository\OutingRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class OutingController extends Controller
{

    /**
     * @Route("/create/outing", name="index_outing")
     */
    public function index()
    {
        return $this->render('create_outing/index.html.twig', [
            'controller_name' => 'CreateOutingController',
        ]);
    }

    /**
     * @Route("/subscribed/{id}", name="subscribe_outing")
     */
    public function addNewParticipant(OutingRepository $repo, Outing $outing, EntityManagerInterface $em){
        $user = $this->getUser();
        if ($outing->addParticipants($user)){
            $this->addFlash("success", "Inscription validée !");
            $nbRegistrationsMax = $outing->getNbRegistrationsMax();
            $nbRegistrations = $outing->getParticipants()->count();
            if($nbRegistrations>=$nbRegistrationsMax){
                $outing->setStatus(2);
            }
            else{
                $outing->setStatus(1);
            }
            $outing->statusManager();
            $outing->statusInfosManager();
            $em->persist($outing);
            $em->flush();
        }
        else {$this->addFlash("success", "Utilisateur déjà inscrit !");
        }
    }

    /**
     * @Route("/unsubscribed/{id}", name="unsubscribe_outing")
     */
    public function deleteParticipant(OutingRepository $repo, Outing $outing, EntityManagerInterface $em){
        $user = $this->getUser();

        if ($outing->deleteParticipants($user)){

            $this->addFlash("success", "Désistement enregistré !");

            $nbRegistrationsMax = $outing->getNbRegistrationsMax();
            $nbRegistrations = $outing->getParticipants();
            $nbRegistrationNow = $nbRegistrations->count();

            if($nbRegistrationNow>=$nbRegistrationsMax){
                $outing->setStatus(2);
            }
            else{
                $outing->setStatus(1);
            }
            $outing->statusManager();
            $outing->statusInfosManager();
            $em->persist($outing);
            $em->flush();

        }
        else {$this->addFlash("success", "Problème lors de l'annulation !");
        }

    }

    /**
     * @Route("/subscription/{id}", name="subscription_outing")
     */
    public function subscriptionParticipant(OutingRepository $repo, Outing $outing, EntityManagerInterface $em, Request $request){
        $user = $this->getUser();

        if($outing->participantIsPresent($user)){
            $this->deleteParticipant($repo, $outing, $em);
        }
        else{
            $this->addNewParticipant($repo, $outing, $em);
        }
        return $this->redirectToRoute("home");

    }

    /**
     * @Route("/view/{id}", name="view")
     */
    public function outingView(Outing $outing, EntityManagerInterface $em, Request $request){
        $user = $this->getUser();
        $id = $outing->getId();

        $oneOuting = $em->getRepository(Outing::class)->find($id);
        $participants = $outing->getParticipants();
        if($outing->isOrganizer($user)){
           return $this->render("outing/viewUpdateOuting.html.twig",
                [
                    "outing" => $oneOuting,
                    "participants" => $participants
                ]
            );
        }
        return $this->render("outing/viewOuting.html.twig",
            [
            "outing" => $oneOuting,
            "participants" => $participants
            ]
            );
    }



    /**
     * @Route("/createouting", name="create_outing")
     */
    public function addNewOuting(Request $request)
    {
        $user = $this->getUser();
        $outing = new Outing();

        $createOutingForm = $this->createForm(CreateOutingType::class, $outing, array(
            'action' => $this->generateUrl($request->get('_route'))
        ))
            ->handleRequest($request);

        if ($createOutingForm->isSubmitted() && $createOutingForm->isValid()){

            $participants = new ArrayCollection();
            $participants->add($user);
            $outing->setParticipants($participants);
            $outing->setOrganizer($user);

            if(isset($_POST['saveBtn'])){
                $outing->setStatus(0);
            }

            if(isset($_POST['publishBtn'])){
                $outing->setStatus(1);
            }

            $outing->statusManager();
            $outing->statusInfosManager();

            $this->getDoctrine()->getManager()->persist($outing);
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash("success", "La sortie est bien enregistrée.");
            return $this->redirectToRoute("home");

        }
        return $this->render("outing/createouting.html.twig", ["form" => $createOutingForm->createView()]);
    }

}

