<?php
/**
 * Created by PhpStorm.
 * User: Bapi Roy <mail2bapi@astrosoft.co.in>
 * Date: 6/2/20
 */
require_once "TreeWalker.php";

/**
 * Class Jsoncomparer
 */
class Jsoncomparer
{
    private $comparer;
    private $originalContent;
    private $newContent;
    private $outputDirectory = 'output';

    public function __construct(array $setting)
    {
        $this->comparer = new TreeWalker($setting);
    }

    /**
     * Compare just two files and save json file in assign output directory (default: output/)
     * @param string $originalFile
     * @param string $newFile
     * @param boolean $fileOutput
     * @throws Exception
     * @return mixed
     */
    public function compareFile($originalFile='', $newFile='', $fileOutput=false){
        if ((file_exists($originalFile)) && (file_exists($newFile))) {
            // Both File exist

            // Getting File content
            $originalContent = file_get_contents($originalFile);
            $newContent =  file_get_contents($newFile);

            // Comparing the files
            $comparedContent = $this->comparer->getdiff($originalContent, $newContent);

            // Saving compared data into a new file
            if($fileOutput){
                $newFileName = $this->outputDirectory.'/'.basename($originalFile, '.json').'_compared.json';
                file_put_contents($newFileName, $comparedContent);
            }

            return json_decode($comparedContent, true);

        } else {
            throw new Exception("File ".$originalFile." or file ".$newFile." does not exist");
        }
    }

    /**
     * @param $originalContent
     * @param $newContent
     * @return mixed
     */
    public function compareObject($originalContent, $newContent){
        // Comparing the files
        $comparedContent = $this->comparer->getdiff($newContent, $originalContent);
        return json_decode($comparedContent, true);
    }

    /**
     * Compare all the files present in two directories and save json files in assign output directory (default: output/)
     * @param string $originalDir
     * @param string $newDir
     * @param boolean $fileOutput
     * @throws Exception
     * @return mixed
     */
    public function compareDirectories($originalDir='', $newDir='', $fileOutput=false){
        if ((is_dir($originalDir)) && (is_dir($newDir))) {
            // Both Directory exist

            // List New dir files
            $newDirFiles = scandir($newDir);
            unset($newDirFiles[0]);
            unset($newDirFiles[1]);

            // List Original dir files
            $orgDirFiles = scandir($originalDir);
            unset($orgDirFiles[0]);
            unset($orgDirFiles[1]);

            foreach ($orgDirFiles as $orgFile){

                // Check same file exist in new directory
                if (in_array($orgFile, $newDirFiles)) {
                    // Found, let's compare
                    $this->compareFile($originalDir.'/'.$orgFile, $newDir.'/'.$orgFile, $fileOutput);
                }
            }
        } else {
            throw new Exception("Directory ".$originalDir." or file ".$newDir." does not exist");
        }
    }

    /**
     * @param string $outputDirectory
     */
    public function setOutputDirectory($outputDirectory)
    {
        if (!is_dir($outputDirectory)){
            if (!mkdir($outputDirectory, 0777, true)) {
                die('Failed to create directory...');
            }
        }
        $this->outputDirectory = $outputDirectory;
    }


}




