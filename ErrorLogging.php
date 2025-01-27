<?php
/** \file ErrorLogging.php
 * Implements an error logger.
 * Creates a log file upon loging attempt.
 * File name can be changed by changing GMSP_LOG_FILE_NAME definition
 */

/* Make sure we don't expose any info if called directly */
if ( !function_exists( 'add_action' ) ) {
	die("This application is not meant to be called directly!");
}

define( "GMSP_LOG_FILE_NAME", plugin_dir_path(__FILE__) . "/gmsp_log_file.log");

/* TODO: Take care of big log files */
/* TODO: Implement time stamps */

class gmsp_LogFile {
	public function Error( $message) {
		fwrite( $this->_logFileHandle,
			$this->getTimeStamp() . " " ."ERROR: " . $message . "\n"
		);
	}

	public function Warning( $message) {
		fwrite( $this->_logFileHandle,
			$this->getTimeStamp() . " " . "WARNING: " . $message . "\n"
		);
	}

	public function Info( $message) {
		fwrite( $this->_logFileHandle, 
			$this->getTimeStamp(). " " . "INFO: " . $message . "\n"
		);
	}

	 public static function getInstance() {
		if( null == gmsp_LogFile::$_errorLogInstance) {
			gmsp_LogFile::$_errorLogInstance = new gmsp_LogFile();
			gmsp_LogFile::$_errorLogInstance->_logFileHandle = 
				fopen( gmsp_LogFile::$_errorLogInstance->_logFileName, 'a');
		 	/* TODO: Check if we have actualy opened a file */
		}

		return gmsp_LogFile::$_errorLogInstance;
	}

	private function __construct() {
	}

	public function __destruct() {
		if( $this->_logFileHandle != null) {
			fclose( $this->_logFileHandle);
		}
	}

	private function getTimeStamp() {
		return date( "h:i:s d.m.y");
	}
	
	private $_logTimeStamp = "";
	private $_logFileName = GMSP_LOG_FILE_NAME;
	private $_logFileHandle = null;
	private static $_errorLogInstance = null;
};

?>