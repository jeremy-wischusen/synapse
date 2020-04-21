<?php

/**
 * Description of LogFile - Handles writing to log files.
 *
 * @author Jeremy Wischusen
 */
class LogFile {
    
    public $logDir = '/var/log/';
    public $ext = '.log';
    protected $fileName;
    protected $fileHandle;
    
    public function  __construct($fileName) {
        $this->fileName = $fileName;
    }
    
    public function write($msg) {
        if (!$this->fileHandle) {
            $this->openLog();
        }
        return fwrite($this->fileHandle, date('m/j/Y - h:i:s A') . ': ' . $msg . "\n");
    }

    public function getContents() {
        return file_get_contents($this->logDir . $this->fileName . $this->ext);
    }

    protected function openLog() {
        if (!$this->fileName) {
            throw new Exception('Log file name has not been set');
        } else {
            $this->fileHandle = fopen($this->logDir . $this->fileName . $this->ext, 'a');
        }
    }
    
    public function  __destruct() {
        if ($this->fileHandle) {
            fclose($this->fileHandle);
        }
    }
}

?>
