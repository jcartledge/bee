<?php

class BuildTaskSet extends BeeTaskSet {
  /* delete files from build dir, copy src files to build and generate CSS files from templates */
  function default_task() {
    $this->depends_on('build:clean build:copy-files build:generate-css');
  }
  /* delete files from build dir */
  function clean_task() {
    $this->sh('rm -rf build/*');
  }
  /* delete files from build dir */
  function copy_files_task() {
    $this->depends_on('build:clean');
    $this->sh('cp -r src/* build/');
    $this->sh('rm -rf build/config build/tpl');
  }
  /* generate files from css */
  function generate_css_task() {
    $this->config->load('src/config/css.properties');
    $template = 'src/tpl/css';
    $css = $this->generate($template, $this->config['css']);
    @file_put_contents('build/css/global.css', $css);
  }
}
