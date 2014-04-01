<?php

$css = <<<EOF
.fam-flag {
  padding: 0;
  width: 16px;
  height: 11px;
  background-repeat: no-repeat;
  background-position: center;
  display: inline-block;
}
EOF;
$css .= PHP_EOL;

if( !empty($argv[1]) ) {
  $imageDir = $argv[1];
} else if( is_dir('icons/') ) {
  $imageDir = 'icons/';
} else {
  $imageDir = '.';
}
if( !empty($argv[2]) ) {
  $mode = $argv[2];
} else {
  $mode = 'data-uri';
}

$files = array();
foreach( scandir($imageDir) as $file ) {
  if( substr($file, -4) !== '.png' ) continue;
  $files[] = $imageDir . $file;
}

if( empty($files) ) {
  fwrite(STDERR, 'No images found in ' . $imageDir . PHP_EOL);
  exit(1);
}

foreach( $files as $file ) {
  $name = substr(basename($file), 0, -4);
  
  if( $mode === 'data-uri' ) {
    $data = base64_encode(file_get_contents($file));
    $url = 'data:image/png;base64,' . $data;
  } else if( $mode === 'url' ) {
    $url = $file;
  } else {
    continue;
  }
  
//  $handle = imagecreatefrompng($file);
//  $width = imagesx($handle);
//  $height = imagesy($handle);
//  imagedestroy($handle);
  $css .= '.fam-flag-' . $name . ' {' . PHP_EOL;
//  $css .= '  width: ' . $width . 'px;' . PHP_EOL;
//  $css .= '  height: ' . $height . 'px;' . PHP_EOL;
  $css .= '  background-image: url(' . $url . ');' . PHP_EOL;
  $css .= '}' . PHP_EOL;
}

fwrite(STDOUT, $css);
exit(0);
