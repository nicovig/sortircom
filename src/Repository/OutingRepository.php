<?php

namespace App\Repository;

use App\Entity\Outing;
use App\Entity\Participant;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Outing|null find($id, $lockMode = null, $lockVersion = null)
 * @method Outing|null findOneBy(array $criteria, array $orderBy = null)
 * @method Outing[]    findAll()
 * @method Outing[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OutingRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Outing::class);
    }

    public function findBySearch($value, $city, $organizer, $outingInscription, $outingNot, $outingPassed, $idUser)
    {

        $params = [];

        if(($outingInscription || $outingNot) && !($outingInscription && $outingNot)){
            $dql  = 'SELECT o FROM App\Entity\Outing o JOIN o.city c JOIN o.participants p WHERE 1=1 ';
        }
        else{
            $dql  = 'SELECT o FROM App\Entity\Outing o JOIN o.city c WHERE 1=1 ';
        }


        if( $organizer != null ){
            $dql  .= 'AND o.organizer = :organizer ';
            $params['organizer'] = $idUser;
        }

        if(!empty($value)){
            $dql  .= 'AND o.name LIKE :value ';
            $params['value'] = '%'.$value.'%';
        }

        if(!empty($city) && $city > 0){
            $dql  .= 'AND o.city = :city ';
            $params['city'] = $city;
        }

        if($outingInscription && !$outingNot){
            $dql  .= 'AND p = :user ';
            $params['user'] = $idUser;
        }

        if($outingNot == true && !$outingInscription){
            $dql .= 'AND p <> :user';
            $params['user'] = $idUser;

            // AND :user not in(SELECT :user FROM p WHERE o.id = o)

        }

        if($outingPassed == true){
           // if($isNotArchived == false) {
                $isArchive = 4;
                $dql .= 'AND o.status = :isArchive';
                $params['isArchive'] = $isArchive;
           // }
        }
        dump($dql);

        $query = $this->getEntityManager()->createQuery($dql);
        $query->setParameters($params);
        return $query->getResult();
    }


    //affiche toutes les sorties
    public function allOuting(){
        $em = $this->getEntityManager();
        $repo = $em->getRepository(Outing::class);
        $list =$repo->findAll();
        return $list;
    }



}
