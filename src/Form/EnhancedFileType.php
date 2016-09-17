<?php

namespace VRia\Bundle\EnhancedFileBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class EnhancedFileType
 * @package VRia\Bundle\EnhancedFileBundle\Form
 * @author Vladyslav Riabchenko <contact@vria.eu>
 */
class EnhancedFileType extends AbstractType
{
    /**
     * Builds the form.
     *
     * This method is called for each type in the hierarchy starting from the
     * top most type. Type extensions can further modify the form.
     *
     * @see FormTypeExtensionInterface::buildForm()
     *
     * @param FormBuilderInterface $builder The form builder
     * @param array                $options The options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('fileName', 'hidden')
            ->add('file', 'file', array(
                'label' => false
            ))
            ->addModelTransformer(new StringToEnhancedFileTransformer())
            ->addEventListener(FormEvents::PRE_SUBMIT, function(FormEvent $event) use ($options) {
                $data = $event->getData();

                if ($data['file'] instanceof UploadedFile) {
                    if ($options['delete_previous_file']) {
                        $oldFilePath = $options['directory_path'] . '/' . $data['fileName'];
                        if (is_file($oldFilePath)) {
                            unlink($oldFilePath);
                        }
                    }

                    $fileName = md5(uniqid()) . '.' . $data['file']->guessClientExtension();
                    $data['file']->move($options['directory_path'], $fileName);
                    $data['fileName'] = $fileName;
                }

                $event->setData($data);
            });
    }

    /**
     * Finishes the form view.
     *
     * This method gets called for each type in the hierarchy starting from the
     * top most type. Type extensions can further modify the view.
     *
     * When this method is called, views of the form's children have already
     * been built and finished and can be accessed. You should only implement
     * such logic in this method that actually accesses child views. For everything
     * else you are recommended to implement {@link buildView()} instead.
     *
     * @see FormTypeExtensionInterface::finishView()
     *
     * @param FormView      $view    The view
     * @param FormInterface $form    The form
     * @param array         $options The options
     */
    public function finishView(FormView $view, FormInterface $form, array $options)
    {
        $fileName = $form->get('fileName')->getData();
        $view->vars['download_url'] = $fileName ? $options['public_directory_path'] . $fileName : null;

        $view->children['file']->vars = array_replace($view->vars, $view->children['file']->vars);
    }

    /**
     * Configures the options for this type.
     *
     * @param OptionsResolverInterface $resolver The resolver for the options
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'compound' => true,
            'delete_previous_file' => true
        ));

        $resolver->setRequired(array(
            'directory_path',
            'public_directory_path'
        ));
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'enhanced_file';
    }
}
