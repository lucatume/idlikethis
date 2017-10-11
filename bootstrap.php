<?php
$container = new tad_DI52_Container();

function idlikethis_body_class(array $classes){
	$classes[] = 'idlikethis';
	return $classes;
}
add_filter('body_class','idlikethis_body_class');

$container->register('idlikethis_ServiceProviders_Shortcodes');
$container->register('idlikethis_ServiceProviders_Endpoints');
$container->register('idlikethis_ServiceProviders_Scripts');
$container->register('idlikethis_ServiceProviders_CommentsTable');
$container->register('idlikethis_ServiceProviders_MetaBoxes');

return $container;
