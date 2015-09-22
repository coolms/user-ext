<?php
/**
 * CoolMS2 User Extensions Module (http://www.coolms.com/)
 *
 * @link      http://github.com/coolms/user-ext for the canonical source repository
 * @copyright Copyright (c) 2006-2015 Altgraphic, ALC (http://www.altgraphic.com)
 * @license   http://www.coolms.com/license/new-bsd New BSD License
 * @author    Dmitry Popov <d.popov@altgraphic.com>
 */

namespace CmsUserExt\Factory\Controller;

use Zend\ServiceManager\FactoryInterface,
    Zend\ServiceManager\ServiceLocatorInterface,
    CmsUserExt\Mvc\Controller\UserController;

class UserControllerFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     *
     * @return UserController
     */
    public function createService(ServiceLocatorInterface $controllers)
    {
        $services = $controllers->getServiceLocator();
        return new UserController(
            $services->get('DomainServiceManager')->get('CmsUser\\Mapping\\UserInterface')
        );
    }
}
