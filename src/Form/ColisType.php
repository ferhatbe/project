<?php

namespace App\Form;

use App\Entity\Colis;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Intl\Intl;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ColisType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('paysDepart', ChoiceType::class, [
                'choices' => array_combine(array_values(Intl::getRegionBundle()->getCountryNames()),
                    array_values(Intl::getRegionBundle()->getCountryNames()))

            ])
            ->add('paysArrive',ChoiceType::class, [
                'choices' => array_combine(array_values(Intl::getRegionBundle()->getCountryNames()),
                    array_values(Intl::getRegionBundle()->getCountryNames())),

            ])
            ->add('villeDepart',null, array('label' => false))
            ->add('villeArrive',null, array('label' => false))
            ->add('dateDep')

            ->add('poids', ChoiceType::class, [
                'choices'  => [
                    ' Moins de 1kg' => 1,
                    ' Entre 1kg et 3kg' => 3,
                    ' Entre 3kg et 5kg' => 5,
                    ' Plus de 5kg' => 6,

                ]])
            ->add('description',TextareaType::class)
            ->add('type', ChoiceType::class, [
                'choices'  => [
                    'J\'expedie un colis' => 1,
                    'je transport un colis' => 2,

                ]])
            ->add('medicament', CheckboxType::class, [
                'label'    => 'Veuillez vérifier si à usage personnel et si l’ordonnance est obligatoire',
                'required' => true,
            ])
            ->add('objets', CheckboxType::class, [
                'label'    => 'Veuillez vérifier si l’objet est légalement transportable dans le pays de destination !',
                'required' => true,
            ])
            ->add('cgu', CheckboxType::class, [
                'label'    => 'J’ai lu et j’accepte les conditions générales',
                'required' => true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Colis::class,
        ]);
    }
}
