<?php

namespace Stasmo\BirchBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class GetQuoteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text')
            ->add('eventType', 'choice', array(
                'choices'   => array('Wedding' => 'Wedding', 'Birthday' => 'Birthday', 'Holiday Event' => 'Holiday Event', 'Fundraiser' => 'Fundraiser',
                                     'Corporate' => 'Corporate', 'Other' => 'Other'),
                'required'  => true,
                'expanded'  => true
            ))
            ->add('phoneNumber', 'text')
            ->add('eventStart', 'time')
            ->add('eventEnd', 'time')
            ->add('eventDate', 'date', array('data' => new \DateTime()))
            ->add('emailAddress', 'email')
        	->add('numberOfGuests', 'integer');
    }

    public function getName()
    {
        return 'getQuote';
    }
}
