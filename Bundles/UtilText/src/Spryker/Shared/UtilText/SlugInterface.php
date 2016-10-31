<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Shared\UtilText;

interface SlugInterface
{

    /**
     * @param string $value
     *
     * @return string
     */
    public function generate($value);

}
