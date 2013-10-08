<?php

namespace GruntBooter;

class GruntBooter {

	private $project_path;
	private $dev_name;
	private $project_name;
	private $project_title;

	public function __construct($_project_path, $_dev_name, $_project_name)
	{
		$this->project_path  = str_replace('\\', '/', $_project_path);
		$this->dev_name      = $_dev_name;
		$this->project_title = $_project_name;
		$this->project_name  = $_project_name;

		$this->runPreliminaryChecks();
	}

	public function runPreliminaryChecks()
	{
		if(file_exists($this->project_path . 'package.json'))
		{
			// TODO
		}
		// TODO...
	}

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

	public function installGrunt()
	{
		chdir($this->project_path);
		exec('npm install grunt');
	}

	public function installGruntDependencies()
	{
		chdir($this->project_path);
		exec('npm install grunt');
		exec('npm install');

		chdir($this->project_path . 'node_modules/grunt');
		exec('npm install');
	}

}
