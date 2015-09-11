<?php
/**
 * CoolMS2 User Extensions Module (http://www.coolms.com/)
 *
 * @link      http://github.com/coolms/user-ext for the canonical source repository
 * @copyright Copyright (c) 2006-2015 Altgraphic, ALC (http://www.altgraphic.com)
 * @license   http://www.coolms.com/license/new-bsd New BSD License
 * @author    Dmitry Popov <d.popov@altgraphic.com>
 */

namespace CmsUserExt\Mvc\Controller;

use Zend\Http\PhpEnvironment\Response,
    Zend\Mvc\Controller\AbstractActionController,
    Zend\Mvc\Controller\Plugin\FlashMessenger,
    Zend\View\Model\ViewModel,
    CmsCommon\Service\DomainServiceInterface;

class UserController extends AbstractActionController
{
    /**
     * @var DomainServiceInterface
     */
    protected $userExtService;

    /**
     * __construct
     */
    public function __construct(DomainServiceInterface $userExtService)
    {
        $this->userExtService = $userExtService;
    }

    /**
     * {@inheritDoc}
     */
    public function indexAction()
    {   
        if ($this->cmsAuthentication()->getIdentity()->getExtMetadata()) {
            return $this->redirect()->toRoute(null, ['action' => 'update']);
        }

        return $this->redirect()->toRoute(null, ['action' => 'create']);
    }

    /**
     * Create extended individual information
     *
     * @return ViewModel|Response
     */
    public function createAction()
    {
        $identity = $this->cmsAuthentication()->getIdentity();
        if ($identity->getExtMetadata()) {
            return $this->redirect()->toRoute(null, ['action' => 'update']);
        }

        $url = $this->url()->fromRoute(null, ['action' => 'create']);
        $prg = $this->prg($url, true);
        // Return early if prg plugin returned a response
        if ($prg instanceof Response) {
            return $prg;
        } elseif ($prg !== false) {
            $post = $prg;
        } else {
            $post = [];
        }

        $form = $this->userExtService->getForm();

        $viewModel = new ViewModel();
        
        if ($post) {
            $validationGroup = [
                'extMetadata' => [
                    'gender',
                    'description',
                    'annotation',
                    'individualAddress',
                    'contactMetadata' => [
                        'phones',
                        'emails',
                        'websites',
                        'messengers',
                        'socialNetworks',
                    ],
                ],
            ];
            $form->setValidationGroup($validationGroup);
            
            if ($service->save($post)) {

                $this->flashMessenger()
                    ->setNamespace($form->getName() . '-' . FlashMessenger::NAMESPACE_SUCCESS)
                    ->addMessage('Data has been successfully saved');

                $url = $this->url()->fromRoute(null, ['action' => 'update']);
                $form->setAttribute('action', $url);
                $viewModel->setTemplate('cms-user-ext/user/update');
            }
        }
        
        return $viewModel->setVariables(compact('form'));
    }

    /**
     * Update extended individual information
     *
     * @return ViewModel|Response
     */
    public function updateAction()
    {
        $identity = $this->cmsAuthentication()->getIdentity();
        if (!($data = $identity->getExtMetadata())) {
            return $this->redirect()->toRoute(null, ['action' => 'create']);
        }

        $url = $this->url()->fromRoute(null, ['action' => 'update']);
        $prg = $this->prg($url, true);
        // Return early if prg plugin returned a response
        if ($prg instanceof Response) {
            return $prg;
        } elseif ($prg !== false) {
            $post = $prg;
        } else {
            $post = [];
        }

        $form = $this->userExtService->getForm();
        $form->setAttribute('action', $url);
        $form->bind($data);
        $form->setElementGroup([
            'gender',
            'description',
            'annotation',
            'individualAddress',
            'contactMetadata' => [
                'phones',
                'emails',
                'websites',
                'messengers',
                'socialNetworks',
            ],
        ]);

        $viewModel = new ViewModel();

        if ($post && $form->setData($post)->isValid()) {
            $data = $form->getData();
            $this->userExtService->getMapper()->save($data);

            $this->flashMessenger()
                ->setNamespace($form->getName() . '-' . FlashMessenger::NAMESPACE_SUCCESS)
                ->addMessage('Data has been successfully saved');
        }

        return $viewModel->setVariables(compact('form'));
    }
}
