<?php

namespace App\Controllers\admin;

use App\Controllers\BaseController;
use App\Models\Muserrole;

use App\Libraries\Treeviewdata;
use App\Models\Mmenus;
use App\Models\Mrolemenu;

class Module extends BaseController
{
    public function __construct()
    {
        header("Access-Control-Allow-Origin: *");
        header('Access-Control-Allow-Headers:Origin, X-Requested-With, Content-Type, Accept');
        $this->menus = new Mmenus();

        $this->mroles = new Muserrole();
        $this->mrolemenu = new Mrolemenu();
        $this->themeadmin();
    }

    public function index()
    {
        $menus = new Mmenus();

        $mrole = new Muserrole();
        $resutListModul = $menus->getmodule(session()->get("role"))->getResult();

        $arrLstTemp = array();
        foreach ($resutListModul as $objModule) {

            if (!isset($arrLstTemp[$objModule->parentid])) {
                $arrLstTemp[$objModule->parentid] = array();
            }

            array_push($arrLstTemp[$objModule->parentid], $objModule);
        }

        $treeviewdata = new Treeviewdata();
        $lastmodule = $treeviewdata->ArrangeModuleTreeData(0, $arrLstTemp);


        $arrData['lstModule'] = $lastmodule;
        $arrData['arrAkses'] = array();
        $arrWhere = array();
        $arrData['data'] = $mrole
        ->where($arrWhere)
        ->get()
        ->getResult();

       return view('admin/vmodule', $arrData);
    }


    public function listGroup()
    {

        $arrWhere = array();
        $arrOrder = array();
        $where = "";
        $arrField = array("role_name");

        //Value From Datatables
        $intDraw = (int)$_GET['draw'];
        $strTableSearch = $_GET['search']["value"];
        $strStart = $_GET['start'];
        $arrTableOrder = $_GET['order'];

        //Condition
        $arrWhere = array();

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
        $mrole = new Muserrole();

        $iTotal = $mrole->countAll();
        $intRows = $mrole->where($arrWhere)
        ->limit($intLimit, $intOffset)
        ->countAll();


        $arrData = $mrole
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
           
                array_push($arrValue, $objNews[$strValue]);
            }

            //Button
            $strButton = "<i class='fa fa-pencil' aria-hidden='true'><a href=" . base_url('admin/editgroup?id=' . $objNews['role_id']) . " >edit</a></i>";
            $strButton .=
            "<i class='fa fa-trash' aria-hidden='true'><a href=" . base_url('admin/delgroup?id=' . $objNews['role_id']) . " onclick=\"return confirm('Anda ingin menghapus data tersebut?')\">del</a></i>";
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


    public function deletegroup(){
        $id = $this->request->getGet('id');

        $mrole = new Muserrole();

       $mrole->where('role_id',$id);
       $mrole->delete();
        $message = "User Group berhasil di delete";


        echo '<script>
			alert("' . $message . '");
			location = "' . site_url('admin/module') . '";
		</script>';


    }



    public function editgroup(){
        $id = $this->request->getGet('id');

        $GroupId = (int)$id;
        $arrData = array(
            "role_id" =>"",
            "role_name" =>""
        );

        $mrole = new Muserrole();

        $objGroup = $mrole->get()->getResult();

        $arrData['group'] = $objGroup;

        $arrOrder["role_id"] = "DESC";

        $arrData['data'] =
        $mrole->where('role_id',$id)
        ->get()->getResult();

        if (count($arrData['data']) > 0) {
            foreach ($arrData['data'] as $arrGroup) {
                if ($arrGroup->role_id == $GroupId) {
                    foreach ($arrGroup as $strField => $strValue) {
                        $arrData[$strField] = $strValue;
                    }
                }
            }
        }

        $arrAkses = array();
       // dd($GroupId);
        $arrwhere = array('id_role' => $GroupId);
        $arrLstAksesModule = $this->mrolemenu->where($arrwhere)
        ->get()
        ->getResult();
        //->getCompiledSelect();

   
        foreach ($arrLstAksesModule as $objAksesModule) {
            array_push($arrAkses, $objAksesModule->id_menu);
        }

        $mrole = new Muserrole();
        $resutListModul = $this->menus->getmodule(session()->get("role"))->getResult();
        $arrLstTemp = array();

        foreach ($resutListModul as $objModule) {

            if (!isset($arrLstTemp[$objModule->parentid])) {
                $arrLstTemp[$objModule->parentid] = array();
            }

            array_push($arrLstTemp[$objModule->parentid], $objModule);
        }

        $treeviewdata = new Treeviewdata();
        $lastmodule = $treeviewdata->ArrangeModuleTreeData(0, $arrLstTemp);


        $arrData['lstModule'] = $lastmodule;
        $arrData['arrAkses'] = $arrAkses;

        $arrData['GroupId'] = $GroupId;
        $arrData['Module'] = $this->menus->findall();



        // echo "<pre>";
        // print_r($arrData);
        // echo "</pre>";
        // die();

        return view('admin/vmodule', $arrData);
    }


    public function savegroup(){
        $strGroupName = $this->request->getPost('txtGroupName');
        $strGroupID = $this->request->getPost('txtGroupId');
        $arrModuleAkses = $this->request->getPost('chkModule');
        $arrWhere = array("GroupId" => $strGroupID);
        $arrGroup = array('GroupName' => $strGroupName);

        $strMessage ="";
        if ($strGroupID != "") {

            $arrWhere = array("role_id" => $strGroupID);
            $arrGroup = array('role_name' => $strGroupName);

            $this->mroles->update($arrWhere,$arrGroup);

            if(count($arrModuleAkses)>0){
                $this->mrolemenu->where('id_role', $strGroupID)
                            ->delete();

                foreach ($arrModuleAkses as $value) {
                    $data = array(
                        'id_role' => $strGroupID,
                        'id_menu' => $value,
                        'created_by' => session()->get('username')
                    );
             
                   $this->mrolemenu->save($data);
                  
                }

                $strMessage = "Data has been edit";
            }


        }else{
            $data = array(
                'role_name' => $strGroupName,
                'is_active' => 1,
                'created_by' => session()->get('username')
            );
            $id = $this->mroles->insert($data);
            //dd($id);

            foreach ($arrModuleAkses as $value) {
                $data = array(
                    'id_role' => $id,
                    'id_menu' => $value,
                    'created_by' => session()->get('username')
                );

                $this->mrolemenu->save($data);
            }
            $strMessage = "Data has been add";

        }

        echo '<script>
			alert("' . $strMessage . '");
			location = "' . base_url('admin/module') . '";
		</script>';

    }
}
