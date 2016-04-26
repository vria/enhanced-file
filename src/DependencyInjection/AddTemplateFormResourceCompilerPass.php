<?php

namespace VRia\Bundle\EnhancedFileBundle\DependencyInjection;


use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class AddTemplateFormResourceCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $formThemesParameter = $container->getParameter('twig.form_themes');
    }
}
