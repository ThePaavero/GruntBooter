<?php

namespace GruntBooter;

/**
 * GruntBooter class
 *
 * @package GruntBooter
 * @author Pekka S. <nospam@astudios.org>
 * @link https://github.com/ThePaavero/GruntBooter
 * @license MIT
 */
class GruntBooter {

	private $project_path;
	private $dev_name;
	private $project_name;
	private $project_title;

	/**
	 * Cosntructor
	 * @param string $_project_path e.g. '/var/www/projectx'
	 * @param string $_dev_name     e.g. 'Charlie Sheen'
	 * @param string $_project_name e.g. 'project_x'
	 */
	public function __construct($_project_path, $_dev_name, $_project_name)
	{
		$this->project_path  = str_replace('\\', '/', $_project_path) . '/';
		$this->dev_name      = $_dev_name;
		$this->project_title = $_project_name;
		$this->project_name  = $_project_name;

		$this->runPreliminaryChecks();
	}

	/**
	 * Try to detect basic problems before doing anything
	 * @return array
	 */
	public function runPreliminaryChecks()
	{
		$errors = array();

		if( ! is_writable($this->project_path))
		{
			$errors[] = 'Project path is not writable or does not exist. Aborting.';
		}

		if(file_exists($this->project_path . 'package.json'))
		{
			$errors[] = 'package.json file already exists!';
		}

		if(file_exists($this->project_path . 'Gruntfile.js'))
		{
			$errors[] = 'Gruntfile.js file already exists!';
		}

		return $errors;
	}

	/**
	 * Generate file package.json
	 * @return null
	 */
	public function generatePackageJson()
	{
		$template = file_get_contents('bin/templates/package.template.json');

		$tokens = array(
				'[PROJECT_TITLE]',
				'[PROJECT_AUTHOR]'
			);
		$replace_with = array(
				$this->project_title,
				$this->dev_name
			);

		$parsed = str_replace($tokens, $replace_with, $template);
		file_put_contents($this->project_path . 'package.json', $parsed);
	}

	/**
	 * Generate file Gruntfile.js
	 * @return null
	 */
	public function generateGruntFile()
	{
		$template = file_get_contents('bin/templates/Gruntfile.template.js');

		$tokens = array(
				'[PROJECT_NAME]'
			);
		$replace_with = array(
				$this->project_name
			);

		$parsed = str_replace($tokens, $replace_with, $template);
		file_put_contents($this->project_path . 'Gruntfile.js', $parsed);
	}

	/**
	 * Install Grunt locally using npm install
	 * @return null
	 */
	public function installGrunt()
	{
		chdir($this->project_path);
		exec('npm install grunt');
	}

	/**
	 * Install Grunt's dependencies using npm install
	 * @return null
	 */
	public function installGruntDependencies()
	{
		chdir($this->project_path);
		exec('npm install grunt');
		exec('npm install');

		chdir($this->project_path . 'node_modules/grunt');
		exec('npm install');
	}

}
