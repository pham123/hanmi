<?php
session_start();
ob_start();
date_default_timezone_set('Asia/Ho_Chi_Minh');
setcookie(
    "hanmi",
    "8400a17d1d3a92967a2e63b5522baaaa",
    time() + (10 * 365 * 24 * 60 * 60)
  );