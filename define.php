<?php
	
	// ====================== PATHS ===========================
	define ('DS'				, '/');
	define ('ROOT_PATH'			, dirname(__FILE__));						// Định nghĩa đường dẫn đến thư mục gốc
	define ('LIBRARY_PATH'		, ROOT_PATH . DS . 'libs' . DS);			// Định nghĩa đường dẫn đến thư mục thư viện
	define ('PUBLIC_PATH'		, ROOT_PATH . DS . 'public' . DS);			// Định nghĩa đường dẫn đến thư mục public							
	define ('APPLICATION_PATH'	, ROOT_PATH . DS . 'application' . DS);		// Định nghĩa đường dẫn đến thư mục public							
	define ('TEMPLATE_PATH'		, PUBLIC_PATH . 'template' . DS);		// Định nghĩa đường dẫn đến thư mục public							
	
	define	('ROOT_URL'			, 'zvn-php-offline-15-project-tranmanhhoang' . DS);
	define	('APPLICATION_URL'	, ROOT_URL . 'application' . DS);
	define	('PUBLIC_URL'		,  'public' . DS);
	define	('TEMPLATE_URL'		, PUBLIC_URL . 'template' . DS);
	
	define	('DEFAULT_MODULE'		, 'default');
	define	('DEFAULT_CONTROLLER'	, 'index');
	define	('DEFAULT_ACTION'		, 'index');

	// config
	define('TIME_LOGIN' 		, 5000);

	// ====================== DATABASE ===========================
	define ('DB_HOST'			, 'localhost');
	define ('DB_USER'			, 'root');						
	define ('DB_PASS'			, '');						
	define ('DB_NAME'			, 'php-offline-project');						
	define ('DB_TABLE'			, 'user');						
	define ('TABLE_USER'		, 'user');						
	define ('TABLE_GROUP'		, 'group');						
	define ('TABLE_PRIVILEGE'	, 'privilege');						
