
Instantiate
$form= new Form( $formDataModel );

**viewTypeMap()** , predefined views
Example:
[
	'editText' 		=> __NAMESPACE__.'\\field\\EditText',
	'editTextBig' 	=> __NAMESPACE__.'\\field\\EditTextBig',
	'token' 		=> __NAMESPACE__.'\\field\\Token',
	'button' 		=> '\_m\\webpage\\view\\element\\Button',
]

Override view map
**useViewTypeMap()**
Example:
[
	'editText' => 'name\\space\\FieldViewClass',
]

**addField( key, fieldViewObject )**
for directly adding fieldeditText
this method will initilialize fieldViewObject

use customViewMap() in Form to define fields


**addButton( $buttonContent = 'save' )**
to add button
buttonds can also be defined in **viewMap()**

Form field AUTO GENERATION
form field are auto generated if **view_type** is defined in **_form_fields**
