<?php
return array(
	//'配置项'=>'配置值'
	'URL_ROUTER_ON' => true,
	// 允许访问模块
	'MODULE_ALLOW_LIST' => array('Home', 'Webadmin'),
	// 默认模块
	'DEFAULT_MODULE' => 'Home',
	// 数据库配置
	// 'DB_TYPE' => 'mysql',
	// 'DB_HOST' => 'bdm246823676.my3w.com',
	// 'DB_NAME' => 'bdm246823676_db',
	// 'DB_USER' => 'bdm246823676',
	// 'DB_PWD' => 'daohe86ysgs',
	// 'DB_PORT' => 3306,
	'DB_TYPE' => 'mysql',
	'DB_HOST' => 'localhost',
	'DB_NAME' => 'zjyx',
	'DB_USER' => 'root',
	'DB_PWD' => 'root',
	'DB_PORT' => 3306,
	// 'DB_CONFIG1'=>array(
	// 	'DB_TYPE'=>'mysql',
	// 	'DB_HOST'=>'qdm180698380.my3w.com',
	// 	'DB_NAME'=>'qdm180698380_db',
	// 	'DB_USER'=>'qdm180698380',
	// 	'DB_PWD'=>'lndx86daohe',
	// 	'DB_PORT'=>3306,
	// ),
	'DB_PREFIX' => 'tp_',
	// 页面Trace,调试辅助工具
	'SHOW_PAGE_TRACE' => false,
	// 设置伪静态后缀,默认为html
	'URL_HTML_SUFFIX' => 'html',
	// 设置默认的视图层名称
	'DEFAULT_V_LAYER' => 'Theme',
	'VIEW_PATH' => 'Application/Theme/',
	'URL_MODEL' => 2,
	'PAGE_ROLLPAGE' => 5, // 分页显示页数
	'PAGE_LISTROWS' => 20, // 分页每页显示记录数
	'__PUBLIC__' => __ROOT__ . '/Public/',
);