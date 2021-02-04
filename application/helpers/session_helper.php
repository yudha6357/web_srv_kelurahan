<?php

function validator()
{
  if (!isset($_SESSION['name'],$_SESSION['email'])) {
    redirect('auth');
  }

  return;
}