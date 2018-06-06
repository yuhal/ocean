<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-09-29
 * Time: 14:17
 */

namespace app\site\controller;
use think\Request;
use think\Image;

class MaterialSdk extends Base
{
    /**
     * 初始化操作
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Sdk配置
     * @param id
     */
	public function index($id){
        $sdk = $this->Sdk->getSdkByWhere(array('sdk_id'=>$id));
        if(empty($sdk)){
            $this->redirect('/error');
        }
        $this->assign('sdk',$sdk);
        $this->assign('action',$id);
	    return $this->fetch();
	}

    /**
     * 编辑Sdk
     * @param id
     */
    public function edit(){
        if(request()->isAjax()){
            $data = input('post.');
            $sdk_info = explode(',', rtrim($data['sdk_info'],','));
            $sdk = $this->Sdk->getSdkByWhere(array('sdk_id'=>$data['id']));
            $sdk_keys = array_keys($sdk['sdk_info']);
            $info = array();
            foreach ($sdk_keys as $key => $value) {
                $info[$value] = $sdk_info[$key];
            }
            $re = $this->Sdk->save(['sdk_info'=>json_encode($info)],['sdk_id'=>$data['id']]);
            if($re || ($re===0)){
                $this->success('保存成功');
            }else{
                $this->error('保存失败');
            }     
        }
        $this->redirect('/error');
    }
  
}