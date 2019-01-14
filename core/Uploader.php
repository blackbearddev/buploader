<?php

    namespace BlackBeard\BUploader;
    
    class Uploader{

        protected $filename;
        protected $filetype;
        protected $filesize;
        protected $tmp;
        protected $id;
        protected $deleteold;

        private $mime;
        private $size;
        private $path;

        function __construct($path, $mime=array("all"), $size=1, $id=null, $deleteold=false)
        {
            $this->mime = $mime;
            $this->size = $size;
            $this->path = $path;
            $this->id = $id;
            $this->deleteold = $deleteold;
            
        }
        

        public function setSingleValue($file=array())
        {   
           
            //$_FILES;
            $this->filename = $file['name'];
            $this->filetype = $file['type'];
            $this->filesize = $file['size'];
            $this->tmp = $file['tmp_name'];
        }

        public function upload()
        {
            if(!$this->verifyExtension()):
                return 1;
            elseif(!$this->verifyFileFileSize()):
                return 2;
            else:
                $this->verifyFolder();
                $this->verifyFilename();
                $this->uploadThis();
                return $this->path  . $this->filename;
            endif;    
        }

        //UPLOADER
        private function uploadThis()
        {
            move_uploaded_file($this->tmp, $this->path . $this->filename);
            chmod($this->path . $this->filename, 0777);
        }


        //verify folders exists if not create it;
        private function verifyFolder()
        {
            if(!file_exists($this->path)):
               mkdir($this->path, 0777);
               chmod($this->path, 0777);
            endif;    
        }

        private function verifyFilename()
        {
            if(!is_null($this->id)):
                $part = explode(".", $this->filename);
                $this->filename = $this->id . "." . $part[1];
            endif;

            if(file_exists($this->path . $this->filename)):
                chmod($this->path . $this->filename, 0777); //Change the file permissions if allowed
                if($this->deleteold):
                    unlink($this->path . $this->filename); //remove the file 
                else:
                    $part = explode(".", $this->filename);
                    $this->filename = $part[0] . '-' . date("dmYhms"). '.'. $part[1];
                endif;    
            endif;    
        }

         // Verify file size - 5MB maximum
        private function verifyFileFileSize()
        {
            if($this->filesize==0) return false;
            $maxsize= $this->size * 1024 * 1024;
           
            if($this->filesize > $maxsize):
                return false;
            else:
                return true;
            endif;        
        }


        //Verify file extension/
        private function verifyExtension()
        {
            $ext = pathinfo($this->filename, PATHINFO_EXTENSION);
            if(!array_key_exists($ext, $this->setMimeTypeArr($this->mime))):
                 return false;
            else:
                return true;        
            endif;    
        }

        //set mime type
        private function setMimeType()
        {
            $mimes =  array(
                "jpg" => "image/jpg", 
                "jpeg" => "image/jpeg", 
                "gif" => "image/gif",
                "png" => "image/png",
                "pdf" => "application/pdf",
                "swf" => "application/x-shockwave-flash",
                "7z"  => "7z application/x-7z-compressed",
                "avi" => "video/x-msvideo",
                "dwf" => "model/vnd.dwf",
                "bmp" => "image/bmp",
                "torrent" => "application/x-bittorrent",
                "css" => "text/css",
                "csv" => "text/csv",
                "deb" => "application/x-debian-package",
                "java" => "text/x-java-source,java",
                "json" => "application/json",
                "js" => "application/javascript",
                "mp4" => "application/mp4"
            );

            if($this->mime=="all"):
                return $mimes;
            else:
               foreach($mimes as $k => $m):
                    if($k===$this->mime):
                        return array($k => $m);
                    endif;    
               endforeach;
               return $mimes; 
            endif;     

        }

        public function setMimeTypeArr()
        {
            $mimes =  array(
                "jpg" => "image/jpg", 
                "jpeg" => "image/jpeg", 
                "gif" => "image/gif",
                "png" => "image/png",
                "pdf" => "application/pdf",
                "swf" => "application/x-shockwave-flash",
                "7z"  => "7z application/x-7z-compressed",
                "avi" => "video/x-msvideo",
                "dwf" => "model/vnd.dwf",
                "bmp" => "image/bmp",
                "torrent" => "application/x-bittorrent",
                "css" => "text/css",
                "csv" => "text/csv",
                "deb" => "application/x-debian-package",
                "java" => "text/x-java-source,java",
                "json" => "application/json",
                "js" => "application/javascript",
                "mp4" => "application/mp4"
            );
                $fil = array();

                if($this->mime[0]=="all"):
                    return $mimes;
                else:
                    foreach($mimes as $k => $m):
                        if(in_array($k, $this->mime)):
                           $fil += array($k=>$m);
                        endif;    
                    endforeach;    
                endif;    
                return $fil;
        }

    }