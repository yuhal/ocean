<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-09-29
 * Time: 14:17
 */

namespace app\site\controller;


class Page extends Base
{
	/**
     * 404页面
     */
    public function page404()
    {
    	return view('page404');
    }

    /**
     * 500页面
     */
    public function page500()
    {
    	return view('page500');
    }
}