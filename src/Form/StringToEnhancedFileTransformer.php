<?php

namespace VRia\Bundle\EnhancedFileBundle\Form;

use Symfony\Component\Form\DataTransformerInterface;

/**
 * Class StringToEnhancedFileTransformer
 * @package VRia\Bundle\EnhancedFileBundle\Form
 * @author Vladyslav Riabchenko <contact@vria.eu>
 */
class StringToEnhancedFileTransformer implements DataTransformerInterface
{
    public function transform($value)
    {
        return array('fileName' => $value, 'file' => null);
    }

    public function reverseTransform($value)
    {
        return $value['fileName'];
    }
}
