<?php

namespace App\Form;


use App\Entity\City;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;



class SearchType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('city', EntityType::class, [
                'class' => City::class,
                'choice_label' => 'name',
                'label' => 'Ville:', 'attr'=>['class'=>'posVille']])

            ->add('search', TextType::class, ['label' => 'Votre recherche:', 'required'=>false, 'attr'=>['class'=>'posChampsRecherche']])
            /*->add('dateHourBeginning', DateTimeType::class, array(
                  'widget' => 'choice',
                  'years' => range(date('Y'), date('Y')+5),
                  'months' => range(date('m'), date('m')+12),
                  'days' => range(date('d'), date('d')+31)),
                  ['label' => 'Date et heure de la sortie:', 'required' => true])
            ->add('deadlineRegistration', DateType::class , ['label' => 'Date limite d\'inscription:', 'required' => true])*/
            ->add('outingOrganizer', CheckboxType::class, ['label' => 'Sorties dont je suis l\'organisateur/trice', 'required'=>false])
            ->add('outingInscription', CheckboxType::class, ['label' => 'Sorties auquelles je suis inscrit/e', 'required'=>false])
            ->add('outingNot', CheckboxType::class, ['label' => 'Sorties auquelles je ne suis pas inscrit/e', 'required'=>false])
            ->add('outingPassed', CheckboxType::class, ['label' => 'Sorties passées', 'required'=>false])
            ->add('Valider', SubmitType::class, ['attr'=>['class'=>'posValide']]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            //'data_class' => array(),
        ]);
    }
}
