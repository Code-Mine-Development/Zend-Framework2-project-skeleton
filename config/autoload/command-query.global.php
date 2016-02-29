<?php

return array (
  'service_manager' => 
  array (
    'factories' => 
    array (
      'Application\\Command\\Quote\\AddWordToTranslateCommandHandler' => 'Application\\Command\\Quote\\AddWordToTranslateCommandHandlerFactory',
    ),
  ),
  'tactician' => 
  array (
    'handler-map' => 
    array (
      'Application\\Command\\Quote\\AddWordToTranslateCommand' => 'Application\\Command\\Quote\\AddWordToTranslateCommandHandler',
    ),
    'middleware' => 
    array (
    ),
  ),
);