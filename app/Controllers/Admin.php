<?php

namespace App\Controllers;

use App\Libraries\imageloader;
use App\Models\Muser;
use App\Models\Muserrole;
use Config\App;

class Admin extends BaseController
{
	public function __construct()
	{
		header("Access-Control-Allow-Origin: *");
		header('Access-Control-Allow-Headers:Origin, X-Requested-With, Content-Type, Accept');
		$this->role = new Muserrole();
		$this->muser = new Muser();

		$this->themeadmin();
	}
	public function index()
	{
		return view('dashboard');
	}

	public function viewupload(){
		return view('testupload');
	}


	public function testupload(){
		$image = $this->request->getFile('image');
		$imgloader = new imageloader();

		$imgupload = $imgloader->uploadfile($image);

	
		echo "test";
		dd($imgupload);
	}

	public function vadduser()
	{

		$id = $this->request->getGet('id');
		// dd($id);
		if (!empty($id)) {
			$data['user'] = $this->muser->find($id);
		}
		$data['role'] = $this->role->findall();
		$data['validation'] = \Config\Services::validation();

		// echo "<pre>";
		// print_r($data);
		// echo "</pre>";
		// die();
		return view('admin/vadduser', $data);
	}


	public function adduser()
	{
		//dd($this->request->getVar());

		if (!$this->validate([
			'name' => [
				'rules' => 'required',
				'errors' => [
					'required' => '{field} nama harus diisi'
				]
			],
			'Password' => [
				'rules' => 'required|min_length[4]',
				'errors' => [
					'required' => '{field} Password harus diisi',
					'min_length' => 'Password diisi minimal 4 karakter'
				]
			],
			'Repassword' => [
				'rules' => 'required|min_length[4]|matches[Password]',
				'errors' => [
					'required' => '{field} Repassword harus diisi',
					'min_length' => 'Password diisi minimal 4 karakter',
					'matches' => 'Repassword tidak sama'
				]
			]
		])) {
			$validation =  \Config\Services::validation();
			return redirect()->to('/Home/vadduser')->withInput()->with('validation', $validation);
		}

		// dd("masuk sini");

		$id = $this->request->getVar('id');
		$name = $this->request->getVar('name');
		$email = $this->request->getVar('email');
		$password = $this->request->getVar('Password');
		$phonenumber = $this->request->getVar('Phonenumber');
		$is_active = $this->request->getVar('is_active');
		$role = $this->request->getVar('role');
		$is_active = ($is_active == 'on') ? true : false;


		if (!empty($id)) {
			$arrWhere = array(
				'userid' => $id
			);
			$arrData =  array(
				'username' => $name,
				'password' => md5($password),
				'email'	=> $email,
				'nomer' => $phonenumber,
				'user_role' => $role,
				'is_active' => $is_active,
				'updated_at' => date('Y-m-d  H:i:s'),
				'updated_by' => session()->get('username')
			);
			//dd("masuk sini");
			$this->muser->updateuser($arrData, $arrWhere);
			set_header_message('success', 'user', 'user berhasil diedit');
			return redirect()->to('/Admin/vuser');
		} else {
			$arrData =  array(
				'username' => $name,
				'password' => md5($password),
				'email'	=> $email,
				'nomer' => $phonenumber,
				'user_role' => $role,
				'is_active' => $is_active,
				'updated_by' => date('Y-m-d  H:i:s'),
				'created_by' => session()->get('username')
			);
			//dd($arrData);
			$this->muser->save($arrData);
			set_header_message('success', 'user', 'user berhasil ditambahkan');
			return redirect()->to('/Admin/vuser');
		}
	}

	public function vuser()
	{
		return view('admin/vlistuser');
	}

	public function datauser()
	{
		$arrWhere = array();
		$arrOrder = array();
		$where = "";
		$arrField = array("username", "nomer", "email", "role_name", "created_at", "is_active");

		//Value From Datatables
		$intDraw = (int)$_GET['draw'];
		$strTableSearch = $_GET['search']["value"];
		$strStart = $_GET['start'];
		$arrTableOrder = $_GET['order'];

		//Condition
		if ($strTableSearch != "") {
			$arrWhere['username'] = $strTableSearch;
		}

		//Order
		if ($intDraw == 1) {
			$arrOrder["created_at"] = "Desc";
		} else {
			foreach ($arrTableOrder as $arrTemp) {
				$strField = $arrField[(int)$arrTemp['column']];
				$arrOrder[$strField] = $arrTemp['dir'];
			}
		}

		// echo var_dump($strField); die();
		//Limit & offset
		// $intLimit = 10;
		$intLimit = $_GET['length'];
		$intOffset = $strStart;
		//  echo "<pre>"; print_r($arrWhere); echo "</pre>";
		// echo "<pre>"; print_r($intOffset); echo "</pre>";

		$iTotal = $this->muser->countAll();
		$intRows = $this->muser->where($arrWhere)
			->limit($intLimit, $intOffset)
			->countAll();


		$arrData = $this->muser->select('*,(SELECT role_name from user_role where role_id=user_role)as role_name')
			->where($arrWhere)
			->limit($intLimit, $intOffset)
			->get()
			->getResultArray();

		$arrValue = array();
		$arrAll = array();

		$iFilteredTotal = $intRows;
		foreach ($arrData as $objNews) {
			$arrValue = array();


			foreach ($arrField as $strValue) {
				switch ($strValue) {
					case "created_at":
						array_push($arrValue, date("d-M-Y h:i", strtotime($objNews['created_at'])));
						break;
					case "is_active":
						($objNews['is_active'] == 1) ? $bol = 'Active' : $bol = 'Disable';
						array_push($arrValue, $bol);
						break;
					default:
						array_push($arrValue, $objNews[$strValue]);
				}
			}

			//Button
			$strButton = "<a href=" . base_url('admin/vadduser?id=' . $objNews['userid']) . " class='sbtn btn-flat btn-md btn-info'><button class='btn btn-primary'>Edit</button></a>";
			$strButton .= "<a href=" . base_url('admin/deleteuser/' . $objNews['userid']) . " class='sbtn btn-flat btn-md btn-info'><button class='btn btn-danger'>Delete</button></a>";
			$strButton .= "";
			array_push($arrValue, $strButton);

			array_push($arrAll, $arrValue);
		}

		$output = array(
			"iTotalRecords" => $iTotal,
			"iTotalDisplayRecords" => $iFilteredTotal,
			"aaData" => $arrAll
		);

		echo json_encode($output);
		die();
	}


	public function deleteuser($id)
	{
		$this->muser->delete($id);

		session()->setFlashdata('message_header', array(
			'tipe' => 'success',
			'title' => 'user',
			'message' => 'user berhasil didelete',
		));
		return redirect()->to('/Admin/vuser');
	}
}
