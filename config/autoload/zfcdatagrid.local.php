<?php
return array(
    'ZfcDatagrid' => array(
        
        'settings' => array(
            
            'default' => array(
                'renderer' => array(
                    //http => jqGrid,
                    'http' => 'bootstrapTable',
                    'console' => 'zendTable'
                )
            ),
            
            'export' => array(
                'enabled' => true,
                
                //currently only A formats are supported...
                'papersize' => 'A4',
                
                // landscape / portrait (we preferr landscape, because datagrids are often wide)
                'orientation' => 'landscape',
                
                'formats' => array(
                    //renderer -> display Name (can also be HTML)
                    'PHPExcel' => 'Excel',
                    'tcpdf' => 'PDF'
                ),
                
                // The output+save directory
                'path' => '/tmp',
                
                'mode' => 'direct'
            )
        ),
        
        'cache' => array(
        
            'adapter' => array(
                'name' => 'Filesystem',
                'options' => array(
                    'ttl' => 720000, // cache with 200 hours,
                    'cache_dir' => 'data/ZfcDatagrid'
                )
            ),
            'plugins' => array(
                'exception_handler' => array(
                    'throw_exceptions' => false
                ),
        
                'Serializer'
            )
        ),
        
        'renderer' => array(
            'bootstrapTable' => array(
                'templates' => array(
                    'toolbar' => 'layout/dg-toolbar'
                )
            ),
            'jqGrid' => array(
                'templates' => array(
                    'layout' => 'zfc-datagrid/renderer/jqGrid/layout'
                )
            ),
            'TCPDF' => array(
                
                'papersize' => 'A4',
                
                // landscape / portrait (we preferr landscape, because datagrids are often wide)
                'orientation' => 'landscape',
                
                'margins' => array(
                    'header' => 5,
                    'footer' => 10,
                    
                    'top' => 20,
                    'bottom' => 11,
                    'left' => 10,
                    'right' => 10
                ),
                
                'icon' => array(
                    // milimeter...
                    'size' => 16
                ),
                
                'header' => array(
                    // define your logo here, please be aware of the relative path...
                    'logo' => '../../../../../public/images/logo.png',
                    'logoWidth' => 20
                ),
                'style' => array(
                    'header' => array(
                        'font' => 'aefurat',
                        'size' => 11,
                    ),
                    
                    'data' => array(
                        'font' => 'aefurat',
                        'size' => 11,
                    )
                )
            )
        ),
        
        
    )
);