<?php


namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;


class RemoteTableColumnType extends AbstractType
{
    public const METHOD_EDIT_TYPE = 'edit';

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id', TextType::class,  ['disabled' => true])
            ->add('label', TextType::class)
            ->add('name', TextType::class,  ['disabled' => true])
            ->add('type', TextType::class)
            ->add('description', TextareaType::class, ['required' => false])
            ->add('isViewList', CheckboxType::class, ['required' => false])
            ->add('isViewDetail', CheckboxType::class, ['required' => false])
            ->add('isViewPopup', CheckboxType::class, ['required' => false]);

        $method = $options['method'];
        if ($method === self::METHOD_EDIT_TYPE)
        {
            $builder->add('edit', SubmitType::class, ['label' => 'Edit']);
        }
        else
        {
            $builder->add('save', SubmitType::class, ['label' => 'Create']);
        }

        $builder->getForm();
    }
}