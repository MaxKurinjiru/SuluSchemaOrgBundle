<?php

/**
 * This file is part of Sulu SchemaOrg Bundle.
 *
 * (c) Pablo Lozano <lozanomunarriz@gmail.com>
 *
 *  This source file is subject to the MIT license that is bundled
 *  with this source code in the file LICENSE.
 */

namespace Plozmun\Bundle\SuluSchemaOrgBundle\Transformer;

class SimpleTransformer implements TransformerInterface
{
    public function transform($value)
    {
        return $value;
    }
}
