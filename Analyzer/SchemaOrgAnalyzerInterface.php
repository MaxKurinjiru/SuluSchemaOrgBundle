<?php

/**
 * This file is part of Sulu SchemaOrg Bundle.
 *
 * (c) Pablo Lozano <lozanomunarriz@gmail.com>
 *
 *  This source file is subject to the MIT license that is bundled
 *  with this source code in the file LICENSE.
 */

namespace Plozmun\Bundle\SuluSchemaOrgBundle\Analyzer;

use Symfony\Component\HttpFoundation\Request;

interface SchemaOrgAnalyzerInterface
{
    const TAG = 'sulu.schema_org';

    public function analyze(Request $request): void;
}
