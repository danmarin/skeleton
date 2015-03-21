<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Process;
use Vortex\Config\Config;

class DBImportCommand extends Command {

	private $config;


	protected function configure() {
		$this
			->setName( 'db:import' )
			->setDescription( 'Import Database' )
			->addArgument( 'file', InputArgument::REQUIRED, 'Import database from file.' );
	}

	protected function execute( InputInterface $input, OutputInterface $output ) {
		$file = $input->getArgument( 'file' );

		// Get database configuration so we can export the database
		$this->config = new Config();
		$stage = $this->config->get( 'stage' );

		$dbUser = $this->config->get( $stage, 'username' );
		$dbPass = $this->config->get( $stage, 'password' );
		$dbName = $this->config->get( $stage, 'database' );

		if ( $file ) {
			$file = $this->config->get( 'dbs_path' ) . '/' . $file . '.sql';
			$output->writeln( '<info>Importing database from ' . $file . ' to DB: '.$dbName.'</info>' );

			$process = new Process( 'mysql -u"' . $dbUser . '" -p"' . $dbPass . '" ' . $dbName . ' < ' . $file );
			$process->run();

			if ( ! $process->isSuccessful() ) {
				throw new \RuntimeException( $process->getErrorOutput() );
			}

			$output->writeln( $process->getOutput() );
		}
	}

}
