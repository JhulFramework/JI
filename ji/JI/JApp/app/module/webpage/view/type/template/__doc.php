<?php

Templateing does allow nesting or only to one depth
cannot be compile on construct becuase subviews are added later


after adding child views they get serialized immeditaly thus cannot be modified( like in view element)


/*
| IMPORTANT view name is required and must be unique, to manage children view
*/


/*
| Instantiating a layout
*/
$layout = new Layout( $layout_name );

/*
| Setting Fragments To Layout
*/
$layout->setFragment( 'form', $form );
