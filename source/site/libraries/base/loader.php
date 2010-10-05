<?php
defined('_JEXEC') or die();

jimport('joomla.filesystem.folder');
jimport('joomla.filesystem.file');

class XiptLoader
{
        //here we will try to register all MC and libs and helpers
        function addAutoLoadFolder($folder, $type, $prefix='Xipt')
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
                        	$className='XiptFactory';
                        JLoader::register($className, $folder.DS.$file);
                }
        }
        
        function addAutoLoadFile($class,$file)
        {
        	JLoader::register($class, $file);
        }
        
		function addAutoLoadViews($baseFolders, $format, $prefix='Xipt')
		{
			foreach(JFolder::folders($baseFolders) as $folder )
			{
				//e.g. XiController + Product
				$className 	= JString::ucfirst($prefix)
							. JString::ucfirst('View')
							. JString::ucfirst($folder);

				$fileName	= JString::strtolower("view.$format.php");
				JLoader::register($className, $baseFolders.DS.$folder.DS.$fileName);
			}
		}
}
