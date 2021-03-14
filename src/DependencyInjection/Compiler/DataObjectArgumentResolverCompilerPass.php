<?php

namespace App\DependencyInjection\Compiler;

use App\Request\DataObjectArgumentResolverInterface;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class DataObjectArgumentResolverCompilerPass implements CompilerPassInterface
{

    public function process(ContainerBuilder $container)
    {
        $container->registerForAutoconfiguration(DataObjectArgumentResolverInterface::class)
            ->addTag('controller.argument_value_resolver');
    }
}
