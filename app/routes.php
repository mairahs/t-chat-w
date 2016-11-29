<?php
	
	$w_routes = array(
		['GET', '/', 'Default#home', 'default_home'],
		['GET', '/test', 'Test#monAction', 'test_index'],
		['GET', '/users', 'User#listUsers', 'users_list'],
		['GET|POST', '/salon/[i:id]', 'Salon#seeSalon', 'see_salon'],
		['GET|POST','/login','User#login','login'],      // le nom de la route nous est imposé par le framework
		['GET', '/logout','User#logout','logout']

	);