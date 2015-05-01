<?php

namespace Yustplayit\WebBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('empresa','text');
        $builder->add('email', 'email');
        $builder->add('telefono', 'number');
        $builder->add('consulta', 'textarea');
        $builder->add('enviar', 'submit');
    }

    public function getName()
    {
        return 'contact';
    }
}

