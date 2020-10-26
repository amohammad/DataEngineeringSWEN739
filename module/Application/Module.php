<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Application\View\Helper\BundleForm;
use Application\View\Helper\Slides;
use Application\View\Helper\Settings;
use Application\View\Helper\DisplayImage;
use Application\View\Helper\FlashMessages;
use Application\View\Helper\MenuItems;

class Module
{
    public function getServiceConfig()
    {
        return array(
            'initializers' => array(
                function ($instance, $sm) {
                    if ($instance instanceof \Zend\Db\Adapter\AdapterAwareInterface) {
                        $instance->setDbAdapter($sm->get('Zend\Db\Adapter\Adapter'));
                    }
                }
            ),
            'invokables' => array(
            ),
            'factories' => array(
            	//Models
            	'Application\Model\Main' => function ($sm) {
            		return new \Application\Model\Main($sm);
            	},
            	//Forms
//             	'Application\Form\ContactForm' => function ($sm) {
//             	   return new \Application\Form\ContactForm($sm->get('Doctrine\ORM\EntityManager'));
//             	},
            )
        );
    }
    
    public function onBootstrap(MvcEvent $e)
    {
    	$serviceManager = $e->getApplication()->getServiceManager();
    	$viewModel = $e->getApplication()->getMvcEvent()->getViewModel();
    	
    	$settingModel = $serviceManager->get('CPanel\Model\Setting');
    	$settings = $settingModel->getSettings(null, 1);
    	$viewModel->settings = $settings;
//     	$siteImageLogo = $settingModel->getSettingByCode('logo');
//     	$viewModel->siteImageLogo = $siteImageLogo;
        $eventManager        = $e->getApplication()->getEventManager();
        
        $doctrineEntityManager = $serviceManager->get('doctrine.entitymanager.orm_default');
        $doctrineEventManager  = $doctrineEntityManager->getEventManager();
        
        //This checks to see if the user is logged in.
        $eventManager->attach(MvcEvent::EVENT_DISPATCH, array($this, 'checkLogin'), 100);
        
        if ($_SERVER['APPLICATION_ENV'] != 'development') {
            $eventManager->attach('route', array($this, 'doHttpsRedirect'));
        }
        
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
        
        // Attache listener to set creation and updating sessions
        $doctrineEventManager->addEventListener(
            array(
                \Doctrine\ORM\Events::prePersist,
                \Doctrine\ORM\Events::postPersist
            ),
            new \Application\Listener\EntityListener($serviceManager)
            );
    }
    
    public function doHttpsRedirect(MvcEvent $e) {
        $sm = $e->getApplication()->getServiceManager();
        $uri = $e->getRequest()->getUri();
        $controller = $e->getRouteMatch()->getParam('controller');
        $action =  $e->getRouteMatch()->getParam('action');
        $securedPages = array('zfcuser', 'Admin', 'admin');
        
        if (in_array($controller, $securedPages)) {
            $scheme = $uri->getScheme();
            if ($scheme != 'https') {
                $uri->setScheme('https');
                $response = $e->getResponse();
                $response->getHeaders()->addHeaderLine('Location', $uri);
                $response->setStatusCode(302);
                $response->sendHeaders();
                return $response;
            }
        }
    }
    
    //This function is attached to a listener to see if the user is not currently logged in
    //If they are not logged in they will be redirected to the login page. This check will happen through the
    //application so there is no need to keep checking in other modules
    public function checkLogin(MvcEvent $e)
    {
    	$session = new \Zend\Session\Container('defaults');
    	$this->route = $e->getRouteMatch();
    	$this->matchedRouteName = explode('/', $this->route->getMatchedRouteName());
    	$this->route_root = $this->matchedRouteName[0];
    	$sm = $e->getApplication()->getServiceManager();
    
    	$zfcServiceEvents = $sm->get('ZfcUser\Authentication\Adapter\AdapterChain')->getEventManager();
    
    	$zfcServiceEvents->attach(
    		'authenticate',
    		function ($e) use ($session) {
    			$session->offsetSet('sessionstart', $_SERVER['REQUEST_TIME']);
    		}
    	);
    
    	//if request need permession page (in the c-panel module)
    	if ($this->route_root == 'c-panel') {
	    	$auth = $sm->get('zfcuser_auth_service');
	    	if (!$auth->hasIdentity() && $this->route_root != 'zfcuser') {
	    		$response = new \Zend\Http\PhpEnvironment\Response();
	    		$response->getHeaders()->addHeaderLine('Location', '/user/login');
	    		$response->setStatusCode(302);
	    		$response->sendHeaders();
	    		$e->stopPropagation(true);
	    		return $response;
	    	} elseif ($auth->hasIdentity() && $session->offsetGet('sessionstart') < ($_SERVER['REQUEST_TIME'] - 3600) && $this->route_root != 'zfcuser') {
	    		$response = new \Zend\Http\PhpEnvironment\Response();
	    		$response->getHeaders()->addHeaderLine('Location', '/user/logout');
	    		$response->setStatusCode(302);
	    		$response->sendHeaders();
	    		$e->stopPropagation(true);
	    		return $response;
	    	} elseif ($auth->hasIdentity()) {
	    		$session->offsetSet('sessionstart', $_SERVER['REQUEST_TIME']);
	    	}
    	}
    }
    
    public function getViewHelperConfig()
    {
    	return array(
    		'factories' => array(
				'bundleForm' => function ($sm) {
    				return new BundleForm();
    			},
				'slides' => function ($sm) {
    				return new Slides($sm);
    			},
				'settings' => function ($sm) {
    				return new Settings($sm);
    			},
				'menuItems' => function ($sm) {
    				return new MenuItems($sm);
    			},
				'displayImage' => function ($sm) {
    				return new DisplayImage();
    			},
    			'flashMessage' => function ($sm) {
					$flashmessenger = $sm->getServiceLocator()
					    				 ->get('ControllerPluginManager')
					    				 ->get('flashmessenger');
    				$message = new FlashMessages();
    				$message->setFlashMessenger($flashmessenger);
    				return $message ;
    			}
    		),
    	);
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
}
