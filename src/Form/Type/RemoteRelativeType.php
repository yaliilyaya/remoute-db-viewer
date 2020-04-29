<?php


namespace App\Form\Type;

use App\Entity\RemoteTableColumn;
use App\Repository\RemoteTableColumnRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;


class RemoteRelativeType extends AbstractType
{
    public const METHOD_EDIT_TYPE = 'edit';

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) :void
    {
        $builder
            ->add('columnFrom', EntityType::class, [
                'class' => RemoteTableColumn::class,
                'choice_label' => [$this, 'extractColumnLabel'],
                'query_builder' => static function (RemoteTableColumnRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.id', 'ASC');
                },
            ])
            ->add('columnTo', EntityType::class, [
                'class' => RemoteTableColumn::class,
                'choice_label' => [$this, 'extractColumnLabel'],
                'query_builder' => static function (RemoteTableColumnRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.id', 'ASC');
                },
                ])
            //    ->add('query', TextType::class, ['required' => false])
        ;

        $method = $options['method'];
        if ($method === self::METHOD_EDIT_TYPE)
        {
            $builder->add('edit', SubmitType::class, ['label' => 'Edit relative']);
        }
        else
        {
            $builder->add('save', SubmitType::class, ['label' => 'Create relative']);
        }

        $builder->getForm();
    }

    public function extractColumnLabel(RemoteTableColumn $column) {
        return sprintf('%s - %s', $column->getTable()->getLabel(), $column->getLabel());
    }
}