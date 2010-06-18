<?php
defined('_JEXEC') or die();

jimport('joomla.filesystem.folder');
jimport('joomla.filesystem.file');

class XiPTLoader
{
        //here we will try to register all MC and libs and helpers
        function addAutoLoadFolder($folder, $type, $prefix='XiPT')
        {
                foreach(JFolder::files($folder) as $file )
                {
                        if($file===strtolower('index.html'))
                        	continue;
                         if($file===strtolower('aclrule.php'))
                        	continue;
                        $className      = JString::ucfirst($prefix)
                                                . JString::ucfirst($type)
                                                . JString::ucfirst(JFile::stripExt($file));
                        
                        if($file===strtolower('xiptcore.php'))
                        	$className='XiFactory';
                        JLoader::register($className, $folder.DS.$file);
                }
        }
        
        function addAutoLoadFile($class,$file)
        {
        	JLoader::register($class, $file);
        }
}
