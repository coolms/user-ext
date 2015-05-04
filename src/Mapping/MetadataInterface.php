<?php
/**
 * CoolMS2 User Extensions Module (http://www.coolms.com/)
 *
 * @link      http://github.com/coolms/user-ext for the canonical source repository
 * @copyright Copyright (c) 2006-2015 Altgraphic, ALC (http://www.altgraphic.com)
 * @license   http://www.coolms.com/license/new-bsd New BSD License
 * @author    Dmitry Popov <d.popov@altgraphic.com>
 */

namespace CmsUserExt\Mapping;

use CmsCommon\Mapping\Common\AnnotatableInterface,
    CmsCommon\Mapping\Common\DescribableInterface;

interface MetadataInterface extends AnnotatableInterface, DescribableInterface
{
    /**
     * Get gender
     *
     * @return string
     */
    public function getGender();

    /**
     * Set gender
     *
     * @param string $gender
     */
    public function setGender($gender);
}
