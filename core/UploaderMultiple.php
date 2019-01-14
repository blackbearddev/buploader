<?php
    namespace BlackBeard\BUploader;

    use BlackBeard\BUploader\Uploader;

    class UploaderMultiple extends Uploader
    {
        private $results;

        function __construct($path, $mime=array("all"), $size=5, $id=null, $deleteold=false)
        {
            parent::__construct($path, $mime, $size, $id, $deleteold);
        }

        public function setMultipleValues($files=array())
        {
            foreach($files['name'] as $i => $file):
                $this->filename = $files['name'][$i];
                $this->filetype = $files['type'][$i];
                $this->filesize = $files['size'][$i];
                $this->tmp = $files['tmp_name'][$i];
                $this->results[] = $this->upload();
            endforeach;
        }

        public function uploadAll()
        {
            return $this->results;
        }
    }