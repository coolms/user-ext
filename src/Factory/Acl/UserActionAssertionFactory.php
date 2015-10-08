<?php
/**
 * CoolMS2 User Extensions Module (http://www.coolms.com/)
 *
 * @link      http://github.com/coolms/user-ext for the canonical source repository
 * @copyright Copyright (c) 2006-2015 Altgraphic, ALC (http://www.altgraphic.com)
 * @license   http://www.coolms.com/license/new-bsd New BSD License
 * @author    Dmitry Popov <d.popov@altgraphic.com>
 */

namespace CmsUserExt\Factory\Acl;

use Zend\Authentication\AuthenticationServiceInterface,
    Zend\ServiceManager\FactoryInterface,
    Zend\ServiceManager\ServiceLocatorInterface,
    CmsUserExt\Acl\UserActionAssertion;

class UserActionAssertionFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     *
     * @return UserActionAssertion
     */
    public function createService(ServiceLocatorInterface $assertions)
    {
        $services = $assertions->getServiceLocator();
        return new UserActionAssertion(
            $services->get(AuthenticationServiceInterface::class)->getIdentity()
        );
    }
}
