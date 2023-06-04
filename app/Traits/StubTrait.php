<?php

namespace App\Traits;

use Illuminate\Support\Pluralizer;

trait StubTrait
{
    /**
    **
    * Map the stub variables present in stub to its value
    *
    *
    */
   public function getStubVariables($path=null)
   {
       return [
           'CLASS_NAME'         => $this->getSingularClassName($this->name),
           'PLURAL_NAME'        => Pluralizer::plural($this->getSingularClassName($this->name)),
           'NAME'               => lcfirst($this->getSingularClassName($this->name)),
           'LOWER_PLURAL_NAME'  => lcfirst(Pluralizer::plural($this->getSingularClassName($this->name)))
       ];
   }

    /**
     * Get the stub path and the stub variables
     *
     *
     */
    public function getSourceFile($item,$path=null)
    {
        return $this->getStubContents($this->getStubPath($item), $this->getStubVariables($path));
    }


    /**
     * Return the Singular Capitalize Name
     * @param $name
     * @return string
     */
    public function getSingularClassName($name)
    {
        return ucwords(Pluralizer::singular($name));
    }

    /**
     * Build the directory for the class if necessary.
     *
     * @param  string  $path
     * @return string
     */
    protected function makeDirectory($path)
    {
        if (! $this->files->isDirectory($path)) {
            $this->files->makeDirectory($path, 0777, true, true);
        }

        return $path;
    }

    /**
     * Replace the stub variables(key) with the desire value
     *
     * @param $stub
     * @param array $stubVariables
     * @return bool|mixed|string
     */
    public function getStubContents($stub , $stubVariables = [])
    {
        $contents = file_get_contents($stub);
        foreach ($stubVariables as $search => $replace)
        {
            $contents = str_replace('{{'.$search.'}}' , $replace, $contents);
        }

        return $contents;

    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        foreach($this->items as $item=>$path){
            $path = $path;
            $this->makeDirectory($path["dir"]);

            $contents = $this->getSourceFile($item,$path);
            if (!$this->files->exists($path["dir"].$path['file'])) {
                $this->files->put($path["dir"].$path['file'], $contents);
            }else{

            }
        }

    }

}
