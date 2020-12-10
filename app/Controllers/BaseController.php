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

use App\Libraries\Treeviewdata;
use App\Models\Mmenus;
use CodeIgniter\Controller;

class BaseController extends Controller
{

	/**
	 * An array of helpers to be loaded automatically upon
	 * class instantiation. These helpers will be available
	 * to all other controllers that extend BaseController.
	 *
	 * @var array
	 */
	protected $helpers = ['system_helper'];

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
		session();
	}

	public function themeadmin(){
		$menus = new Mmenus();

		
		$resutListModul= $menus->getmodule(session()->get("role"))->getResult();

		$arrLstTemp = array();
		foreach ($resutListModul as $objModule) {

			if (!isset($arrLstTemp[$objModule->parentid])) {
				$arrLstTemp[$objModule->parentid] = array();
			}

			array_push($arrLstTemp[$objModule->parentid], $objModule);
		}

		$treeviewdata = new Treeviewdata();
		$lastmodule = $treeviewdata->ArrangeModuleTreeData(0, $arrLstTemp);
		$data = array(
			'username' => session()->get("username"),
			'email' => session()->get("email"),
			'role' => session()->get("role")
		);

		$data['lstModule'] = $lastmodule;

		return view('navbar', $data);
	}
}
