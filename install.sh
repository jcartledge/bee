#!/usr/bin/env bash
if [ "$TERM" == "cygwin" ]
  then
    ln -s `pwd`/src/bee-cygwin  /usr/local/bin/bee
    ln -s `pwd`/src/bee         /usr/local/bin/bee.php
  else
    sudo ln -s `pwd`/src/bee    /usr/local/bin/bee
fi
