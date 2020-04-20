<?php

namespace Fourxxi\SecurityMessageBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
//        TODO
        $treeBuilder = new TreeBuilder('security_message');
        return $treeBuilder;
    }
}