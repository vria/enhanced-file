<?php

namespace VRia\Bundle\EnhancedFileBundle\Form;

use Symfony\Component\Form\DataTransformerInterface;

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
