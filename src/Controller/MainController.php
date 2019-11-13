<?php

namespace App\Controller;

use App\Entity\Outing;
use App\Form\SearchType;
use App\Repository\ParticipantRepository;
use App\Repository\OutingRepository;
use Doctrine\ORM\EntityManagerInterface;

use MongoDB\BSON\Timestamp;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class MainController extends Controller
{
    /**
     * @Route("/", name="home")
     */
    public function home(EntityManagerInterface $em, Request $request)
    {
        $repo = $em->getRepository(Outing::class);

        //Retourne la liste par id - Category
        $list =$repo->findAll();

        //Formulaire de recherche
        $formSearch = $this->createForm(SearchType::class);
        $formSearch->handleRequest($request);

        if ($formSearch->isSubmitted() && $formSearch->isValid()) {

            $search = $formSearch->getData();

            $city = $search['city'];

            $organizerCheck = $search['outingOrganizer'];
            $outingInscription = $search['outingInscription'];
            $outingNot = $search['outingNot'];
            $outingPassed = $search['outingPassed'];

            /*dump($organizer);*/
            $user = $this->getUser();


            //filtre Organisateur:
            //isOrganizer
            if ($organizerCheck){
                $organizerCheck = $user->getId();
            }else{
                $organizerCheck = null;
            }

            //isSigned
            if($outingInscription){
                $outingInscription = true;
            }
            else{
                $outingInscription = false;
            }

            //isNotRegistered
            if($outingNot){
                $outingNot = true;
            }
            else{
                $outingNot = false;
            }

            //OutingPassed
            if($outingPassed){

                $outingPassed = true;
                /*$todayDate = mktime(date("H"), date("i"), date("s"), date("n"), date("j"), date("Y"));
                $thirtyDaysTimestamp = 2592000;
                $beginningOutingDate = 0;
                $isNotArchived = array();

                foreach($list as $dateArticle){
                   $dateArticle = $dateArticle->getDateHourBeginning()->getTimestamp();


                    //date de sortie + 30 jours;
                    $beginningOutingDateArchived = $dateArticle+$thirtyDaysTimestamp;

                        if ($beginningOutingDateArchived < $todayDate) {
                            $isNotArchived[] = false;
                        } else {
                            $isNotArchived[] = true;
                        }
                }*/
            }
            else{
                $outingPassed = false;
            }

            $cityId = $city->getId();


            $searchValue = $search['search'];



            $list = $em
                ->getRepository(Outing::class)
                ->findBySearch($searchValue, $cityId, $organizerCheck, $outingInscription, $outingNot, $outingPassed, $user);
            /*dump($searchValue, $cityId, $list);*/

            if(empty($list)){
                $message = "Aucune sortie ne correspond à votre recherche.";

                return $this->render("main/home.html.twig", ["list" => $list, "formSearch" => $formSearch->createView(), "alert" => $message]);
            }
        }

        return $this->render("main/home.html.twig",
            [
                "list" => $list,
                "formSearch" => $formSearch->createView()
            ]);

    }

    /**
     * @Route("/villes", name="cities")
     */
    public function cities()
    {
        return $this->render("main/cities.html.twig");
    }

    /**
     * @Route("/sites", name="site")
     */
    public function site()
    {
        return $this->render("main/site.html.twig");
    }

}

