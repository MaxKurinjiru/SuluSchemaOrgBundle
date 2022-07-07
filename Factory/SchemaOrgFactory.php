<?php

/**
 * This file is part of Sulu SchemaOrg Bundle.
 *
 * (c) Pablo Lozano <lozanomunarriz@gmail.com>
 *
 *  This source file is subject to the MIT license that is bundled
 *  with this source code in the file LICENSE.
 */

namespace Plozmun\Bundle\SuluSchemaOrgBundle\Factory;

use Spatie\SchemaOrg\BaseType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Plozmun\Bundle\SuluSchemaOrgBundle\Builder\BuilderInterface;
use Plozmun\Bundle\SuluSchemaOrgBundle\Extension\ExtensionChain;
use Plozmun\Bundle\SuluSchemaOrgBundle\HttpFoundation\SchemaAttributes;
use Plozmun\Bundle\SuluSchemaOrgBundle\Mapper\StructureMapper;

class SchemaOrgFactory
{
    const TWIG_KEY = '<!-- SCHEMAS -->';

    /**
     * @var BuilderInterface[]
     */
    private array $builders;

    private StructureMapper $structureMapper;
    private SchemaAttributes $attributes;
    private ExtensionChain $extensionChain;

    public function __construct(
        StructureMapper $structureMapper,
        SchemaAttributes $attributes,
        ExtensionChain $extensionChain
    ) {
        $this->structureMapper = $structureMapper;
        $this->attributes = $attributes;
        $this->extensionChain = $extensionChain;
    }

    public function addBuilder(BuilderInterface $builders): void
    {
        $this->builders[] = $builders;
    }

    public function build(Request $request, Response $response): void
    {
        /** @var BaseType[] $schemas */
        $schemas = [];

        if ($structure = $request->attributes->get('structure')) {
            $schemas = $this->structureMapper->parseStructure($structure);
        }

        foreach ($this->attributes->getAttributes() as $key => $attributes) {
            foreach ($this->builders as $builder) {
                if ($builder->support($key)) {
                    foreach ($attributes as $attribute) {
                        $schemas[$key] = $builder->build($key, $attribute);
                    }
                }
            }
        }

        foreach ($schemas as $schema) {
            $this->extensionChain->extend($schema, $schemas);
        }

        if ($content = $response->getContent()) {
            $content = $this->appendSchemas($schemas, $content);
            $response->setContent($content);
        }
    }

    private function appendSchemas(array $schemas, string $content): string
    {
        $data = '';
        foreach ($schemas as $schema) {
            $data .= $schema->toScript();
        }
        $pos = strripos($content, self::TWIG_KEY);
        // Not pos for Web debug toolbar
        if (!$pos) {
            return $content;
        }
        return substr($content, 0, $pos).$data.substr($content, $pos);
    }
}
