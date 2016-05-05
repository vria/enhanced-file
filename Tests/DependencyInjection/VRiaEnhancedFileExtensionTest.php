<?php

namespace VRia\Bundle\EnhancedFileBundle\Test\DependencyInjection;


use Symfony\Component\DependencyInjection\ContainerBuilder;
use VRia\Bundle\EnhancedFileBundle\DependencyInjection\VRiaEnhancedFileExtension;

class VRiaEnhancedFileExtensionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @return ContainerBuilder
     */
    public function testLoadExtention()
    {
        $container = new ContainerBuilder();
        $container->setParameter('twig.form.resources', array('form_div_layout.html.twig'));

        $loader = new VRiaEnhancedFileExtension();
        $loader->load(array(), $container);
        $this->assertTrue($container->hasDefinition('vria.form.type.enhanced_file'));

        return $container;
    }

    /**
     * @depends testLoadExtention
     */
    public function testDefinitionHasCorrectClass(ContainerBuilder $container)
    {
        $definition = $container->getDefinition('vria.form.type.enhanced_file');

        $this->assertEquals('VRia\Bundle\EnhancedFileBundle\Form\EnhancedFileType', $definition->getClass());
    }

    /**
     * @depends testLoadExtention
     */
    public function testFormLayoutAdded(ContainerBuilder $container)
    {
        $this->assertEquals(array('form_div_layout.html.twig', 'VRiaEnhancedFileBundle:Form:div_layout.html.twig'),
            $container->getParameter('twig.form.resources'));
    }
}
