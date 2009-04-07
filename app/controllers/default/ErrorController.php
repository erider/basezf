<?php
/**
 * ErrorController.php
 *
 * @category   MyProject_Controller
 * @package    MyProject
 * @copyright  Copyright (c) 2008 MyProject
 * @author     Harold Thétiot (hthetiot)
 */

class ErrorController extends BaseZF_Framework_Controller_Action
{
    /**
     * Set default layout of controller
     * @var string
     */
    protected $_defaultLayout = 'error';

    /**
     * Error object provide by zend controller plugins error
     * @var object
     */
    protected $_error_handler;

    /**
     * preDispatch for Controller
     *
     * @return void
     */
    public function initController()
    {
        // Grab the error object from the request
        $this->_error_handler = $this->_getParam('error_handler');
		$this->view->error_handler = $this->_error_handler;

        // get current config
        $config = MyProject::registry('config');

        // throw Exception and do not display end user error if debug is enable
		$errorFoward = $this->_getParam('error_foward');

		if (
			// has an error but no forward error
			!empty($this->_error_handler) && $errorFoward !== true &&

			// dev env and remote debug
			($config->debug->enable || isset($_COOKIE[$config->debug->cookie_name]))
		) {
			$this->getRequest()->setParam('error_debug', true);

			throw $this->_error_handler->exception;
        }
    }

    /**
     * errorAction() is the action that will be called by the "ErrorHandler"
     * plugin.  When an error/exception has been encountered
     * in a ZF MVC application (assuming the ErrorHandler has not been disabled
     * in your bootstrap) - the Errorhandler will set the next dispatchable
     * action to come here.  This is the "default" module, "error" controller,
     * specifically, the "error" action.  These options are configurable.
     *
     * @see http://framework.zend.com/manual/en/zend.controller.plugins.html
     *
     * @return void
     */
    public function errorAction()
    {

        // set header (disable json/ajax)
        $response = $this->getResponse();

        // force error 404 from throw exception width code 404
        if ($this->_error_handler->exception->getCode() == 404) {
            $this->_error_handler->type = Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ACTION;
        }

        $this->layout->setLayout($this->_defaultLayout);

        // $errors will be an object set as a parameter of the request object, type is a property
        switch ($this->_error_handler->type) {

            // not found error (controller or action not found or exception code is 404)
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_CONTROLLER:
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ACTION:
            {
                $response->setHttpResponseCode(404);
                $this->_forward('notfound');
                $this->view->message = __('Page not found');
                break;
            }

            // application error by default
            default:
            {
                $response->setHttpResponseCode(500);
                $this->_forward('applicationerror');
                $this->view->message = __('Application error');
                break;
            }
        }

        // send error handler to view
        $this->view->error_handler = $this->_error_handler;
    }

    /**
     * Display error to end user and report it by mail if enable
     *
     * @return void
     */
    public function applicationerrorAction()
    {
        // get current config
        $config = MyProject::registry('config');

		// if report is enable sent exception info by mail
        if ($config->debug->report->enable) {

            BaseZF_Error_Handler::sendExceptionByMail(
                $this->_error_handler->exception,
                $config->debug->report->from,
                $config->debug->report->to
            );
        }
    }

    /**
     * Display page not found to end User
     *
     * @return void
     */
    public function notfoundAction()
    {

    }
}
