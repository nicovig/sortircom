<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use phpDocumentor\Reflection\Types\Boolean;
use App\Entity\Participant;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OutingRepository")
 */
class Outing
{
    /**
     * @ORM\Column(type="datetime")
     */
    private $dateHourBeginning;
    function _construct(){
        $this->dateHourBeginning = new \Date();
    }

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="integer")
     */
    private $duration;

    /**
     * @ORM\Column(type="datetime")
     */
    private $deadlineRegistration;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbRegistrationsMax;

    /**
     * @ORM\Column(type="text")
     */
    private $outingInfos;

    /**
     * @ORM\Column(type="boolean")
     */
    private $active;

    /**
     * @ORM\Column(type="integer", length=50)
     */
    private $status;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $statusInfos;


    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Site")
     */
    private $site;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Participant")
     */
    private $organizer;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\City")
     */
    private $city;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Place")
     */
    private $place;
    //PLACE = lieu

    /**
     * @var ArrayCollection
     * @ORM\ManyToMany(targetEntity="App\Entity\Participant")
     */
    private $participants;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Place")
     */
    private $street;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\City")
     */
    private $postalCode;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Place")
     */
    private $latitude;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Place")
     */
    private $longitude;

    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function setLatitude(string $latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }


    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    public function setLongitude(string $longitude): self
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getPostalCode(): ?int
    {
        return $this->postalCode;
    }

    public function setPostalCode(string $postalCode): self
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    public function getPlace(): ?Place
    {
        return $this->place;
    }

    public function setPlace(Place $place): self
    {
        $this->place = $place;

        return $this;
    }

    public function getOrganizer(): ?Participant
    {
        return $this->organizer;
    }

    public function setOrganizer(Participant $organizer): self
    {
        $this->organizer = $organizer;

        return $this;
    }

    public function getParticipants()
    {
        return $this->participants;
    }

    public function setParticipants(ArrayCollection $participants): self
    {
        $this->participants = $participants;

        return $this;
    }

    //CITY = ville où l'evenement se déroule
    public function getCity(): ?City
    {
        return $this->city;
    }

    public function setCity(City $city): self
    {
        $this->city = $city;

        return $this;
    }

    //SITE = ville organisatrice
    public function getSite(): ?string
    {
        return $this->site;
    }

    public function setSite(string $site): self
    {
        $this->site = $site;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDateHourBeginning(): ?\DateTime
    {
        return $this->dateHourBeginning;
    }

    public function setDateHourBeginning(\DateTime $dateHourBeginning): self
    {
        $this->dateHourBeginning = $dateHourBeginning;

        return $this;
    }

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function setDuration(int $duration): self
    {
        $this->duration = $duration;

        return $this;
    }

    public function getDeadlineRegistration(): ?\DateTime
    {
        return $this->deadlineRegistration;
    }

    public function setDeadlineRegistration(\DateTime $deadlineRegistration): self
    {
        $this->deadlineRegistration = $deadlineRegistration;

        return $this;
    }

    public function getNbRegistrationsMax(): ?int
    {
        return $this->nbRegistrationsMax;
    }

    public function setNbRegistrationsMax(int $nbRegistrationsMax): self
    {
        $this->nbRegistrationsMax = $nbRegistrationsMax;

        return $this;
    }

    public function getOutingInfos(): ?string
    {
        return $this->outingInfos;
    }

    public function setOutingInfos(string $outingInfos): self
    {
        $this->outingInfos = $outingInfos;

        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }
    public function setDateBeginning(\DateTime $dateHourBeginning): self
    {
        $this->dateHourBeginning = $dateHourBeginning;

        return $this;
    }

    public function getActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;
        return $this;
    }


    public function getStatusInfos(): ?string
    {
        return $this->statusInfos;
    }

    public function setStatusInfos(string $statusInfos): self
    {
        $this->statusInfos = $statusInfos;
        return $this;
    }


    public function addParticipants(Participant $participant){

        $isPresent = false;
        if($this->participantIsPresent($participant)){
            $isPresent = false;
        }
        else {$isPresent = true;
            $this->participants->add($participant);
        }

        return $isPresent;
    }
    public function deleteParticipants(Participant $participant){

        $isDelete = false;
        if($this->participantIsPresent($participant)){
            $this->participants->removeElement($participant);
            $isDelete = true;
        }
        else {$isDelete = false;
        }

        return $isDelete;
    }
    //si participant est dans la sortie renvoit vrai
    public function participantIsPresent(Participant $participant){
        $isPresent = false;
        if($this->getParticipants()->contains($participant)){
            $isPresent = true;
        }
        else {
            $isPresent = false;
        }
        return $isPresent;

    }

    public function isOutDated(){

        //boolean de renvoit
        $isOutDated = false;

        //récupération de la date du jour au format timestamp
        $todayDate = mktime(date("H"), date("i"), date("s"), date("n"), date("j"), date("Y"));

        //valeur de la sortie en timestamp
        $beginningOutingDate = $this->getDateHourBeginning()->getTimestamp();

        if($beginningOutingDate<$todayDate){
            $isOutDated=false;
        }
        else{
            $isOutDated = true;
        }
        return $isOutDated;

    }

    //si passé en BDD en actif
    public function isOpen(){
        $isOpen = false;
        if ($this->active==true){
            $isOpen = true;
        }
        else{
            $isOpen = false;
        }
        return $isOpen;
    }

    //si organizer
    public function isOrganizer(Participant $participant){
        $isOrganizer = false;

        $organizer = $this->getOrganizer();

        if( $organizer == $participant ){
            $isOrganizer = true;
        }
        else {
            $isOrganizer = false;
        }

        return  $isOrganizer;

    }
    //savoir si la sortie est pleine
    public function isNotFull(){
        $isFull = false;
        $nbRegistrationsMax = $this->getNbRegistrationsMax();
        $nbRegistrations = $this->getParticipants()->count();

        if($nbRegistrations<$nbRegistrationsMax){
            $isFull = true;
        }
        else{
            $isFull = false;
        }

        return $isFull;
    }

    //renvoit vrai si la sortie est archivée
    public function isNotArchived(){

        //boolean de renvoit
        $isNotArchived = false;

        //récupération de la date du jour au format timestamp
        $todayDate = mktime(date("H"), date("i"), date("s"), date("n"), date("j"), date("Y"));

        //valeur de 30 jours en timestamp
        $thirtyDaysTimestamp = 2592000;
        $beginningOutingDate = 0;
        //condition = si la sortie n'est pas déjà passée
        //valeur de la date des sorties déjà passées en timestamp

        $beginningOutingDate = $this->getDateHourBeginning()->getTimestamp();

        //date de sortie + 30 jours;
        $beginningOutingDateArchived = $beginningOutingDate+$thirtyDaysTimestamp;

        if($beginningOutingDateArchived<$todayDate){
            $isNotArchived=false;
        }
        else{
            $isNotArchived = true;
        }
        return $isNotArchived;

    }


    public function statusManager(){
        $status = $this->getStatus();
        switch ($status){
            //différents status : se référer au diag de classe
            //'Créée' => la sortie est créée mais pas encore active : sujette à modifications
            case 0: $this->setActive(false);
                break;
            //'Ouverte' => la sortie est ouverte et active
            case 1: $this->setActive(true);
                break;
            //'Clotûrée' => la sortie a atteint la limite de participants
            case 2: $this->setActive(true);
                break;
            //'Activité en cours' => la sortie est en train d'avoir lieu
            case 3: $this->setActive(false);
                break;
            //'Passée' => l'évenement est passé
            case 4: $this->setActive(false);
                break;
            //'Annulée' =l'évenement a été annulée par l'organizer
            case 5: $this->setActive(false);
                break;
        }
    }

    public function statusInfosManager(){
        $status = $this->getStatus();
        switch ($status){
            //différents status : se référer au diag de classe
            //'Créée' => la sortie est créée mais pas encore active : sujette à modifications
            case 0: $this->setStatusInfos('Créée');
                break;
            //'Ouverte' => la sortie est ouverte et active
            case 1: $this->setStatusInfos('Ouverte');
                break;
            //'Clotûrée' => la sortie a atteint la limite de participants
            case 2: $this->setStatusInfos('Clotûrée');
                break;
            //'Activité en cours' => la sortie est en train d'avoir lieu
            case 3: $this->setStatusInfos('Activité en cours');
                break;
            //'Passée' => l'évenement est passé
            case 4: $this->setStatusInfos('Passée');
                break;
            //'Annulée' =l'évenement a été annulée par l'organizer
            case 5: $this->setStatusInfos('Annulée');
                break;
        }
    }


}
