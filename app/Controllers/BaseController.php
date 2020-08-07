<?php
namespace App\Controllers;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 *
 * @package CodeIgniter
 */

use CodeIgniter\Controller;
use Config\Services;
use CoinMarketCap;

class BaseController extends Controller
{

	/**
	 * An array of helpers to be loaded automatically upon
	 * class instantiation. These helpers will be available
	 * to all other controllers that extend BaseController.
	 *
	 * @var array
	 */
	protected $helpers = [];

	/**
	 * Access to current session.
	 *
	 * @var \CodeIgniter\Session\Session
	 */
	public $session;

	/**
	 * access to database
	 * @var [type]
	 */
	public $db;

	/**
	 * init current cryptocurrency exchange
	 * @var [type]
	 */
	public $exchange;

	/**
	 * [$cmc coinmarketcap instance]
	 * @var [type]
	 */
	public $cmc;

	/**
	 * Constructor.
	 */
	public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
	{
		// Do Not Edit This Line
		parent::initController($request, $response, $logger);

		//--------------------------------------------------------------------
		// Preload any models, libraries, etc, here.
		//--------------------------------------------------------------------
		// E.g.:
		// $this->session = \Config\Services::session();

		// load layout helper
		helper('layout_helper');

		// start session
		$this->session = Services::session();

		// load auth settings
		$this->config = config('Auth');

		// load database connection
		$this->db = db_connect();

		// init cryptocurrency exchange
		$this->ccxt = $this->initExchange();

		// init coinmarketcap instance
		$this->cmc = new CoinMarketCap\Api('f3fc4e0e-c8bc-47c3-bc89-0492d682a5bb');

	}

	/**
	 * get exchange data from session and init 
	 * @return [type] [description]
	 */
	public function initExchange() {
		$apiData = $this->session->get('apiData');

        $data = [];


        if($apiData['key']) {
            $data = [
                'apiKey' => $apiData['key'], // ←------------ replace with your keys
                'secret' => $apiData['secret'],
                'verbose' => false,
                'options' => array('defaultType' => empty($apiData['type']) ? 'spot' : $apiData['type'])
            ];
        }

        //pp($api, 1);
        

        
        $exchange = "\\ccxt\\" . strtolower(empty($apiData['exchange']) ? 'Binance' : $apiData['exchange']);

        if($exchange)
        {
            return new $exchange($data);
        }
        else {
        	return false;
        }
	}

	public function sessionMsg()
    {
        $sessionMsg = $this->session->get('sessionMsg');

        $this->session->remove('sessionMsg');

        if ($sessionMsg == null) {
            return '<script type="text/javascript">function sessionMsg(){}; </script>';
        }

        $script = '
        <script type="text/javascript">
            function sessionMsg(){
                toastr.options = {
                    "closeButton": true,
                    "debug": false,
                    "onclick": null,
                    "positionClass": "toast-top-full-width",
                    "showDuration": "1000",
                    "hideDuration": "1000",
                    "timeOut": "5000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "swing",
                    "showMethod": "slideDown",
                    "hideMethod": "slideUp"
                }

                toastr.'.$sessionMsg['type'].'("'.$sessionMsg['message'].'")
            }
        </script>';

        return $script;
    }

}
