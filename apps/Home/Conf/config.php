<?php
return array(
	//'配置项'=>'配置值'
	'VIEW_PATH'=>'./views/',//视图位置
	'TMPL_PARSE_STRING' => array(
		'__IMG__'    => __ROOT__ . '/res/images',
		'__CSS__'    => __ROOT__ . '/res/css',
		'__JS__'     => __ROOT__ . '/res/js',
		'__MODULE__'=>__ROOT__.'/res/module'
	)  ,
	
	////默认错误跳转对应的模板文件
	'TMPL_ACTION_ERROR' => '/Msg/error',
	//默认成功跳转对应的模板文件
	'TMPL_ACTION_SUCCESS' => '/Msg/success',


	//活动申请表上传地址
	'ACTIVE_APPLY_UPLOAD_PATH'=>__ROOT__.'/upload/activeapply',


	//文件上传配置
	'APPLY_UPLOAD_CONFIG'=>array(
		'maxSize'=>3145728,// 设置附件上传大小
		'exts'=>array('doc'),// 设置附件上传类
		'savePath'=>'./activeapply',
		'autoSub'=>'true',
		'subName'=>array("date','Ymd"),
		'saveName'=>'',
	),


);