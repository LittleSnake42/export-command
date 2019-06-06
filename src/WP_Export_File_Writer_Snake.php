<?php

class WP_Export_File_Writer_Snake extends WP_Export_Base_Writer_Snake {
	private $f;
	private $file_name;

	public function __construct( $formatter, $file_name ) {
		parent::__construct( $formatter );
		$this->file_name = $file_name;
	}

	public function export() {
		$this->f = fopen( $this->file_name, 'w' );
		if ( ! $this->f ) {
			throw new WP_Export_Exception_Snake( "WP Export: error opening {$this->file_name} for writing." );
		}

		try {
			parent::export();
		} catch ( WP_Export_Exception_Snake $e ) {
			throw $e;
		} catch ( WP_Export_Term_Exception_Snake $e ) {
			throw $e;
		}

		fclose( $this->f );
	}

	protected function write( $xml ) {
		$res = fwrite( $this->f, $xml );
		if ( false === $res ) {
			throw new WP_Export_Exception_Snake( __( 'WP Export: error writing to export file.' ) );
		}
	}
}
