<?php

namespace Plozmun\Bundle\SuluSchemaOrgBundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Plozmun\Bundle\SuluSchemaOrgBundle\DependencyInjection\Compiler\ExtensionPass;
use Plozmun\Bundle\SuluSchemaOrgBundle\DependencyInjection\Compiler\AnalyzerPass;
use Plozmun\Bundle\SuluSchemaOrgBundle\DependencyInjection\Compiler\BuilderPass;
use Plozmun\Bundle\SuluSchemaOrgBundle\DependencyInjection\Compiler\TransformerPass;
use Plozmun\Bundle\SuluSchemaOrgBundle\Extension\ExtensionInterface;

/**
 * Entry-point for university-bundle.
 */
class SuluSchemaOrgBundle extends Bundle
{
    public function build(ContainerBuilder $container): void
    {
        parent::build($container);
        $container->registerForAutoconfiguration(ExtensionInterface::class)
            ->addTag('sulu.schema_org.extension')
        ;

        $container->addCompilerPass(new AnalyzerPass());
        $container->addCompilerPass(new BuilderPass());
        $container->addCompilerPass(new ExtensionPass());
        $container->addCompilerPass(new TransformerPass());
    }
}
