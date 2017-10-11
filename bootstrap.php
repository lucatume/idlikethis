<?php
$container = new tad_DI52_Container();

$container->register('idlikethis_ServiceProviders_Shortcodes');
$container->register('idlikethis_ServiceProviders_Endpoints');
$container->register('idlikethis_ServiceProviders_Scripts');
$container->register('idlikethis_ServiceProviders_CommentsTable');
$container->register('idlikethis_ServiceProviders_MetaBoxes');

return $container;
