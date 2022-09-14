<?php return array(
    'root' => array(
        'pretty_version' => '1.0.0+no-version-set',
        'version' => '1.0.0.0',
        'type' => 'project',
        'install_path' => __DIR__ . '/../../',
        'aliases' => array(),
        'reference' => NULL,
        'name' => 'soap/service',
        'dev' => true,
    ),
    'versions' => array(
        'econea/nusoap' => array(
            'pretty_version' => 'v0.9.12',
            'version' => '0.9.12.0',
            'type' => 'library',
            'install_path' => __DIR__ . '/../econea/nusoap',
            'aliases' => array(),
            'reference' => 'e83219ee1add324124fea8e448b4cfddf782f8ff',
            'dev_requirement' => false,
        ),
        'soap/service' => array(
            'pretty_version' => '1.0.0+no-version-set',
            'version' => '1.0.0.0',
            'type' => 'project',
            'install_path' => __DIR__ . '/../../',
            'aliases' => array(),
            'reference' => NULL,
            'dev_requirement' => false,
        ),
    ),
);
