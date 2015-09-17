<?php

namespace MlankaTech\AppBundle\Twig;


/**
 * UcwordsExt
 *
 * Twig extension to bring native php function ucwords into twig
 *
 * @author  Mfana Ronald Conco <ronald.conco@mlankatech.co.za>
 * @package MlankaTechAppBundle
 * @subpackage Twig
 * @version 0.0.1
 */

class UcwordsExt extends \Twig_Extension
{
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('ucwords', array($this, 'formatString')),
        );
    }

    public function formatString($str)
    {
        return \ucwords($str);
    }

    public function getName()
    {
        return 'ucwords_ext';
    }
}