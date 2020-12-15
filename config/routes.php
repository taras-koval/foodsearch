<?php

return array(

	'object/([0-9]+)' => 'object/view/$1',
	'object/([0-9]+)/page-([0-9]+)' => 'object/view/$1/$2',
	'object/([0-9]+)/del-com-([0-9]+)' => 'user/deleteComment/$1/$2',
	'objects/page-([0-9]+)' => 'object/index/$1',
	'objects' => 'object/index',

	'selection' => 'object/selection',
	'recommendations' => 'object/recommendations',
	
	'register' => 'user/register',
	'login' => 'user/login',
	'logout' => 'user/logout',

	'user/edit' => 'user/edit',
	'user/password' => 'user/password',
	'user/favorite' => 'user/favorite',
	'user/favorite/page-([0-9]+)' => 'user/favorite/$1',
	'user/favorite-add/([0-9]+)' => 'user/favoriteAdd/$1',
	'user/favorite-del/([0-9]+)' => 'user/favoriteDelete/$1',
	'user' => 'user/index',

	'admin/object' => 'admin/object_',
	'admin/object/page-([0-9]+)' => 'admin/object_/$1',
	'admin/object/add' => 'admin/objectAdd',
	'admin/object/edit/([0-9]+)' => 'admin/objectEdit/$1',
	'admin/object-del/([0-9]+)' => 'admin/objectDelete/$1',

	'admin/kitchen' => 'admin/kitchen',
	'admin/kitchen-del/([0-9]+)' => 'admin/kitchenDelete/$1',

	'admin/service' => 'admin/service',
	'admin/service-del/([0-9]+)' => 'admin/serviceDelete/$1',
	
	'admin/type' => 'admin/type',
	'admin/type-del/([0-9]+)' => 'admin/typeDelete/$1',

	'.+' => 'main/notFound',
	'' => 'main/index'
);

?>