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

interface MetadatableInterface
{
    /**
     * @param MetadataInterface $metadata
     * @return self
     */
    public function setExtMetadata(MetadataInterface $metadata);

    /**
     * @return MetadataInterface
     */
    public function getExtMetadata();
}
