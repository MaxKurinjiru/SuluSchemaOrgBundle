<?php

/**
 * This file is part of Sulu SchemaOrg Bundle.
 *
 * (c) Pablo Lozano <lozanomunarriz@gmail.com>
 *
 *  This source file is subject to the MIT license that is bundled
 *  with this source code in the file LICENSE.
 */

namespace Plozmun\Bundle\SuluSchemaOrgBundle\Twig;

use Plozmun\Bundle\SuluSchemaOrgBundle\HttpFoundation\SchemaAttributes;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class SchemaOrgExtension extends AbstractExtension
{
    private SchemaAttributes $attributes;

    public function __construct(SchemaAttributes $attributes)
    {
        $this->attributes = $attributes;
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('sulu_schema_org', [$this, 'buildSchema'])
        ];
    }

    /**
     * @param string $key
     * @param mixed $data
     */
    public function buildSchema(string $key, $data): void
    {
        $this->attributes->addAttribute($key, $data);
    }
}
