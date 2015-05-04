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
    Zend\View\Model\ViewModel;

class UserController extends AbstractActionController
{
    /**
     * {@inheritDoc}
     */
    public function indexAction()
    {
        $identity = $this->cmsUserAuthentication()->getIdentity();
        $url = $this->url()->fromRoute('cms-user/ext');
        
        if (!$identity) {
            return $this->redirect()->toRoute('cms-user/login', [],
                ['query' => ['redirect' => rawurldecode($url)]]
            );
        }
        
        if ($identity->getExtMetadata()) {
            return $this->redirect()->toRoute('cms-user/ext', ['action' => 'update']);
        }
        
        return $this->redirect()->toRoute('cms-user/ext', ['action' => 'create']);
    }

    /**
     * Create extended individual information
     * 
     * @return ViewModel|Response
     */
    public function createAction()
    {
        $identity = $this->cmsUserAuthentication()->getIdentity();
        $url = $this->url()->fromRoute('cms-user/ext', ['action' => 'create']);
        
        if (!$identity) {
            return $this->redirect()->toRoute('cms-user/login', [],
                ['query' => ['redirect' => rawurldecode($url)]]
            );
        } elseif ($identity->getExtMetadata()) {
            return $this->redirect()->toRoute('cms-user/ext', ['action' => 'update']);
        }
        
        $prg = $this->prg($url, true);
        // Return early if prg plugin returned a response
        if ($prg instanceof Response) {
            return $prg;
        } elseif ($prg !== false) {
            $post = $prg;
        } else {
            $post = [];
        }
        
        $service = $this->cmsUser();
        $form = $service->getForm();
        $form->bind($identity);
        
        $viewModel = new ViewModel();
        
        if ($post) {
            $validationGroup = [
                'user' => [
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
                ],
            ];
            if ($form->hasCaptcha()) {
                $validationGroup[] = $form->getCaptchaElementName();
            }
            if ($form->hasCsrf()) {
                $validationGroup[] = $form->getCsrfElementName();
            }
            $form->setValidationGroup($validationGroup);
            
            if ($service->save($post)) {
                
                $this->flashMessenger()
                    ->setNamespace($form->getName() . '-' . FlashMessenger::NAMESPACE_SUCCESS)
                    ->addMessage('Data has been successfully saved');
                
                $url = $this->url()->fromRoute('cms-user/ext', ['action' => 'update']);
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
        $identity = $this->cmsUserAuthentication()->getIdentity();
        $url = $this->url()->fromRoute('cms-user/ext', ['action' => 'update']);
        
        if (!$identity) {
            return $this->redirect()->toRoute('cms-user/login', [],
                ['query' => ['redirect' => rawurldecode($url)]]
            );
        } elseif (!$identity->getExtMetadata()) {
            return $this->redirect()->toRoute('cms-user/ext', ['action' => 'create']);
        }
        
        $prg = $this->prg($url, true);
        // Return early if prg plugin returned a response
        if ($prg instanceof Response) {
            return $prg;
        } elseif ($prg !== false) {
            $post = $prg;
        } else {
            $post = [];
        }
        
        $service = $this->cmsUser();
        $form = $service->getForm();
        $form->bind($identity);
        
        $viewModel = new ViewModel();
        
        if ($post) {
            $validationGroup = [
                'user' => [
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
                ],
            ];
            if ($form->hasCaptcha()) {
                $validationGroup[] = $form->getCaptchaElementName();
            }
            if ($form->hasCsrf()) {
                $validationGroup[] = $form->getCsrfElementName();
            }
            $form->setValidationGroup($validationGroup);
            
            if ($service->save($post)) {
                $this->flashMessenger()
                    ->setNamespace($form->getName() . '-' . FlashMessenger::NAMESPACE_SUCCESS)
                    ->addMessage('Data has been successfully saved');
            }
        }
        
        return $viewModel->setVariables(compact('form'));
    }
}
