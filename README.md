# Bee

Bee is a simple task runner a la Rake but in PHP and BASH.  
I wrote it because we were using Ant in a PHP project and it just felt way too heavy, and I don't think humans should have to write or edit XML.  

It probably lacks several important features of whatever you're using now, but it works OK for us.

That said, bee is very immature, does not do what it claims to, and may shatter.

## INSTALL:

 - From github

    $ git clone git@github.com:jcartledge/bee.git  
    $ cd bee
    $ ./install.sh

## USAGE:

Bee looks for tasksets which are collections of user-defined tasks.  
A taskset is a PHP class which extends BeeTaskSet, and a task is a method of the class with a name ending in '_task'.

An example taskset might look like this:

    <?php
    
    class BuildTaskSet extends BeeTaskSet {
      /* delete files from build dir, copy src files to build and generate CSS files from templates */
      function default_task() {
        $this->depends_on('build:clean build:copy-files build:generate-css');
      }
      /* delete files from build dir */
      function clean_task() {
        $this->sh('rm -r build/*');
      }
      /* delete files from build dir */
      function copy_files_task() {
        $this->depends_on('build:clean');
        $this->sh('cp -r src/* build/*');
        $this->sh('rm -r build/config build/tpl');
      }
      /* generate files from css
      function generate_css_task() {
        $this->config->load('src/config/css.properties');
        $template = 'src/tpl/css';
        $css = $this->generate($template, $this->config['css']);
        file_put_contents('build/css/global.css', $css);
      }
    }

?>

This defines 4 tasks, 3 of them named:

    $ bee build
    $ bee build:clean
    $ bee build:copy-files
    $ bee build:generate-css

Dependencies are defined within the task method by calling $this->depends_on. This ensures each dependency is only run once.  
This can be done anywhere in the task method but generally you'll want to ensure your task dependencies have run before doing anything else.

## TASKSET LOADING

Bee looks in several places for tasksets. As tasksets are loaded using PHPs require function, this is determined by looking on the PHP include path.  
Before looking, bee prepends the following locations to the include path:  

- .        (the current directory)  
- ./tasks  
- ~/.bee  
- /etc/bee/tasks  

In addition, if the environment variable BEE_TASKPATH is set, bee will look there first.  
Taskset files must be named according to the taskset they define - e.g. BuildTaskSet given above should be in build.php

## BUILT-IN TASKS

Bee defines a list task which is available from all user defined tasksets. For example, given the above taskset:

    $ bee build:list
    build:default                 delete files from build dir, copy src files to build and generate CSS files from templates
    build:clean                   delete files from build dir
    build:copy-files              delete files from build dir
    build:generate-css            generate files from css
     -- build:list done in 00:00

Note the comments preceding task methods are shown as descriptions.  

list is the default task for bee so calling bee with no task specified will list all available user-defined tasksets and tasks. This is exploited by the bash_completion script to provide TAB completion of taskset and task names (thanks to @neilang for this feature).
