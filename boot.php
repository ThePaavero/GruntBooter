<?php

/**
 * GruntBooter command script
 *
 * @package GruntBooter
 * @author Pekka S. <nospam@astudios.org>
 * @link https://github.com/ThePaavero/GruntBooter
 * @license MIT
 */

require 'bin/QuickCLI.php';
require 'bin/GruntBooter.php';

$cli = new QuickCLI\QuickCLI('Grunt Booter');

$cli->line('Welcome to ' . $cli->getAppName(), 2, 'light_cyan');

$project_path  = $cli->prompt('Enter project base path', true);
$dev_name      = $cli->prompt('Enter developer name', true);
$project_name  = $cli->prompt('Enter project name (computer style)', true);

$gb = new GruntBooter\GruntBooter($project_path, $dev_name, $project_name);

$errors = $gb->runPreliminaryChecks();

if( ! empty($errors))
{
	$cli->line('Problems!');
	$cli->line(implode(PHP_EOL, $errors), 2, 'red');
	exit;
}

$cli->line('Generating package.json...');
$gb->generatePackageJson();

$cli->line('Generating Gruntfile.js...');
$gb->generateGruntFile();

$cli->line('Installing local Grunt...');
$gb->installGrunt();

$cli->line('Installing local Grunt dependencies...');
$gb->installGruntDependencies();

$cli->line('Done.', 2, 'green');
