<?php

/*
 * This file is part of the BxMarket package.
 *
 * (c) Xavier Buillit
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image as ImageConstraint  ;
use Symfony\Component\Validator\Constraints\File as FileConstraint ;

class ImageType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $imageConstraint = new ImageConstraint(['minHeight'=> 200 , 'minWidth'=>200]);
        $fileConstraint  = new FileConstraint(['maxSize'   => 2048000 ]);
        $builder
            ->add('file', 'file', [
                'required' => false,
                'by_reference' => false,
                'constraints' => [$imageConstraint , $fileConstraint]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Image'
        ));
    }

    public function getName()
    {
        return 'image';
    }
}