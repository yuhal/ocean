<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-09-29
 * Time: 14:17
 */

namespace app\site\controller;


class Index extends Base
{
    public function index()
    {
    	 return $this->fetch();
    }
}