<?php

class ArgsTaskSet extends BeeTaskSet {

  function default_task($name) {
    $this->log($name);
  }
  function simple_task($a, $b, $c, $d = 1) {
    print_r(array(
      'a' => $a, 'b' => $b, 'c' => $c, 'd' => $d
    ));
  }
}
