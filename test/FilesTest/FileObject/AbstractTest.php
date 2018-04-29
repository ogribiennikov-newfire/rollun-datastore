<?php

namespace rollun\test\files\FileObject;

use rollun\files\FileObject;
use rollun\files\FileManager;
use rollun\installer\Command;

abstract class AbstractTest extends \PHPUnit_Framework_TestCase
{

    protected function getFileObject($flags = 0)
    {
        $fileManager = new FileManager;
        $dirName = $this->makeDirName();
        $fileManager->createDir($dirName);
        $filename = $this->makeFileName();
        $fullFilename = $fileManager->joinPath($dirName, $filename);
        $stream = $fileManager->createAndOpenFile($fullFilename, true);
        $fileManager->closeStream($stream);
        $fileObject = new FileObject($fullFilename);
        $fileObject->setFlags($flags);
        return $fileObject;
    }

    protected function fillFile(FileObject $fileObject, $stringsArray)
    {
        $fileObject->ftruncate(0);
        foreach ($stringsArray as $string) {
            $fileObject->fwrite(rtrim($string, "\n\r") . "\n");
            $fileObject->fflush();
        }
        $fileObject->fseek(0);
    }

    protected function makeFileName()
    {
        $name = pathinfo($name = get_class($this) . '.txt')['basename'];
        return $name;
    }

    protected function makeDirName()
    {
        $fileManager = new FileManager;
        $dataDir = Command::getDataDir();
        $pathArray = explode('\\', strtolower(__NAMESPACE__));
        array_shift($pathArray);
        $subDir = implode('/', $pathArray);
        $dirName = $fileManager->joinPath($dataDir, $subDir);
        return $dirName;
    }

}