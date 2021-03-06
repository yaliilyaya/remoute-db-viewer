<?php


namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;


class DataBaseType extends AbstractType
{
    public const METHOD_EDIT_TYPE = 'edit';

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('alias', TextType::class)
            ->add('host', TextType::class)
            ->add('port', TextType::class)
            ->add('user', TextType::class)
            ->add('password', TextType::class)
            ->add('db', TextType::class)
            ->add('charset', TextType::class);

        $method = $options['method'];
        if ($method === self::METHOD_EDIT_TYPE)
        {
            $builder->add('edit', SubmitType::class, ['label' => 'Edit Connect Data Base']);
        }
        else
        {
            $builder->add('save', SubmitType::class, ['label' => 'Connect Data Base']);
        }

        $builder->getForm();


    }
}