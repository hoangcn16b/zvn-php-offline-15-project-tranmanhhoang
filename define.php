<?php
	
	// ====================== PATHS ===========================
	define ('DS'					, '/');
	define ('ROOT_PATH'				, dirname(__FILE__));						// đến thư mục gốc
	define ('LIBRARY_PATH'			, ROOT_PATH . DS . 'libs' . DS);			// đến thư mục thư viện
	define ('LIBRARY_EXT_PATH'		, LIBRARY_PATH . DS . 'extends' . DS);		// đến thư mục thư viện
	define ('PUBLIC_PATH'			, ROOT_PATH . DS . 'public' . DS);			// đến thư mục public							
	define ('UPLOAD_PATH'			, PUBLIC_PATH . 'files' . DS);			// đến thư mục thư thư viện
	define ('APPLICATION_PATH'		, ROOT_PATH . DS . 'application' . DS);		// đến thư mục public							
	define ('TEMPLATE_PATH'			, PUBLIC_PATH . 'template' . DS);		// đến thư mục public							
	define ('SCRIPT_PATH'			, PUBLIC_PATH  . 'scripts' . DS);		// đến thư  
	

	define	('ROOT_URL'				,  DS);
	define	('APPLICATION_URL'		,  DS. 'zvn-php-offline-15-project-tranmanhhoang' . 'application' . DS);
	define	('PUBLIC_URL'			,  'public' . DS);
	define	('TEMPLATE_URL'			, PUBLIC_URL . 'template' . DS);
	
	define	('DEFAULT_MODULE'		, 'frontend');
	define	('DEFAULT_CONTROLLER'	, 'index');
	define	('DEFAULT_ACTION'		, 'index');

	// img URL
	define ('UPLOAD_URL'			, 'public' . DS . 'files' . DS);		// đến thư mục thư thư viện

	//ckEditor
	define ('CKEDITOR_PATH'			, 'public' . DS . 'ckeditor' . DS);		// đến thư mục thư viện
	//services layout
	define	('SERVICE_LAYOUT'			, TEMPLATE_URL . 'frontend' . DS . 'html' . DS );

	// config
	define('TIME_LOGIN' 			, 5000);

	// ====================== DATABASE ===========================
	define ('DB_HOST'				, 'localhost');
	define ('DB_USER'				, 'root');						
	define ('DB_PASS'				, '');						
	define ('DB_NAME'				, 'php-offline-project');						
	define ('DB_TABLE'				, 'user');						
	define ('TABLE_USER'			, 'user');						
	define ('TABLE_GROUP'			, 'group');						
	define ('TABLE_CATEGORY'		, 'category');						
	define ('TABLE_PRIVILEGE'		, 'privilege');						
	define ('TABLE_BOOK'			, 'book');						
	define ('TABLE_SLIDER'			, 'slider');						
