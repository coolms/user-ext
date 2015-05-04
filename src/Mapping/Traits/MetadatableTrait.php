<?php
/**
 * CoolMS2 User Extensions Module (http://www.coolms.com/)
 *
 * @link      http://github.com/coolms/user-ext for the canonical source repository
 * @copyright Copyright (c) 2006-2015 Altgraphic, ALC (http://www.altgraphic.com)
 * @license   http://www.coolms.com/license/new-bsd New BSD License
 * @author    Dmitry Popov <d.popov@altgraphic.com>
 */

namespace CmsUserExt\Mapping\Traits;

use CmsUserExt\Mapping\MetadataInterface;

trait MetadatableTrait
{
    /**
     * @var MetadataInterface
     *
     * @Form\ComposedObject({
     *      "target_object":"CmsUserExt\Mapping\MetadataInterface",
     *      "options":{
     *          "label":"Individual metadata",
     *          "name":"extMetadata",
     *          "partial":"cms-user-ext/metadata/fieldset",
     *          "text_domain":"CmsUserExt",
     *      }})
     */
    protected $extMetadata;

    /**
     * @param MetadataInterface $metadata
     */
    public function setExtMetadata(MetadataInterface $metadata)
    {
        $this->extMetadata = $metadata;
        if (!$metadata->getUser()) {
            $metadata->setUser($this);
        }
    }

    /**
     * @return MetadataInterface
     */
    public function getExtMetadata()
    {
        return $this->extMetadata;
    }
}
