<?php 
/**
 * CoolMS2 User Extensions Module (http://www.coolms.com/)
 *
 * @link      http://github.com/coolms/user-ext for the canonical source repository
 * @copyright Copyright (c) 2006-2015 Altgraphic, ALC (http://www.altgraphic.com)
 * @license   http://www.coolms.com/license/new-bsd New BSD License
 * @author    Dmitry Popov <d.popov@altgraphic.com>
 */

namespace CmsUserExt\Acl;

use Zend\Permissions\Acl\Acl,
    Zend\Permissions\Acl\Assertion\AssertionInterface,
    Zend\Permissions\Acl\Resource\ResourceInterface,
    Zend\Permissions\Acl\Role\RoleInterface,
    CmsUser\Mapping\UserInterface;

class UserActionAssertion implements AssertionInterface
{
    /**
     * @var UserInterface
     */
    protected $identity;

    /**
     * __construct
     *
     * @param UserInterface $authenticationService
     */
    public function __construct($identity)
    {
        $this->identity = $identity;
    }

    /**
     * {@inheritDoc}
     */
    public function assert(Acl $acl, RoleInterface $role = null, ResourceInterface $resource = null, $privilege = null)
    {
        if (!$this->identity) {
            return false;
        }

        if ($privilege === 'index') {
            return true;
        }
        if ($privilege === 'create') {
            return !$this->identity->getExtMetadata();
        }

        return $this->identity->getExtMetadata();
    }
}
