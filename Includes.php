<?php

// Always include
require($_NPath . 'NOLOHConfig.php');
require($_NPath . 'Interfaces/Groupable.php');
require($_NPath . 'Interfaces/MultiGroupable.php');
require($_NPath . 'Interfaces/Singleton.php');
require($_NPath . 'System/Object.php');
require($_NPath . 'System/Application.php');
require($_NPath . 'System/Component.php');
require($_NPath . 'System/Error.php');
require($_NPath . 'System/GeneralFunctions.php');
require($_NPath . 'System/NolohInternal.php');
require($_NPath . 'System/Pointer.php');
require($_NPath . 'System/WebPage.php');
require($_NPath . 'Collections/ArrayList.php');
require($_NPath . 'Controls/Core/Control.php');
require($_NPath . 'Events/Event.php');
require($_NPath . 'Events/ClientEvent.php');
require($_NPath . 'Events/ServerEvent.php');
require($_NPath . 'Statics/Priority.php');
require($_NPath . 'Statics/System.php');
require($_NPath . 'Statics/URL.php');
require($_NPath . 'Statics/UserAgent.php');

function _NAutoLoad($class)
{
	global $_NAutoLoad, $_NPath;
	if(!isset($_NAutoLoad))
		$_NAutoLoad = array(
			
			// System
			'Multiple' => 			'System/Multiple.php',
			
			// Collections
			'Container' => 			'Collections/Container.php',
			'ControlPair' => 		'Collections/ControlPair.php',
			'Group' => 				'Collections/Group.php',
			'ImplicitArrayList' => 	'Collections/ImplicitArrayList.php',
			'Item' => 				'Collections/Item.php',
			
			// Data
			'Data' => 				'Data/Data.php',
			'DataConnection' => 	'Data/DataConnection.php',
			'DataCommand' => 		'Data/DataCommand.php',
			'DataConstraint' => 	'Data/DataConstraint.php',
			'DataReader' => 		'Data/DataReader.php',
			'File' => 				'Data/File.php',
			
			// Core Controls
			'Button' => 			'Controls/Core/Button.php',
			'Panel' => 				'Controls/Core/Panel.php',
			'Calendar' => 			'Controls/Core/Calendar.php',
			'CheckControl' => 		'Controls/Core/CheckControl.php',
			'CheckBox' => 			'Controls/Core/CheckBox.php',
			'ListControl' => 		'Controls/Core/ListControl.php',
			'CheckListBox' => 		'Controls/Core/CheckListBox.php',
			'ComboBox' => 			'Controls/Core/ComboBox.php',
			'FileUpload' => 		'Controls/Core/FileUpload.php',
			'Form' => 				'Controls/Core/Form.php',
			'IFrame' => 			'Controls/Core/IFrame.php',
			'Image' => 				'Controls/Core/Image.php',
			'Label' => 				'Controls/Core/Label.php',
			'Link' => 				'Controls/Core/Link.php',
			'ListBox' => 			'Controls/Core/ListBox.php',
			'MarkupRegion' => 		'Controls/Core/MarkupRegion.php',
			'Multimedia' => 		'Controls/Core/Multimedia.php',
			'RadioButton' => 		'Controls/Core/RadioButton.php',
			'Table' => 				'Controls/Core/Table.php',
			'TextArea' => 			'Controls/Core/TextArea.php',
			'TextBox' => 			'Controls/Core/TextBox.php',
			'Timer' => 				'Controls/Core/Timer.php',
			
			// Extended Controls
			'Accordion' => 			'Controls/Extended/Accordion.php',
			'ListView' => 			'Controls/Extended/ListView.php',
			'CheckListView' => 		'Controls/Extended/CheckListView.php',
			'CollapsePanel' => 		'Controls/Extended/CollapsePanel.php',
			'Menu' => 				'Controls/Extended/Menu.php',
			'ContextMenu' => 		'Controls/Extended/ContextMenu.php',
			'DatePicker' => 		'Controls/Extended/DatePicker.php',
			'RichMarkupRegion' => 	'Controls/Extended/RichMarkupRegion.php',
			'RolloverImage' => 		'Controls/Extended/RolloverImage.php',
			'RolloverLabel' => 		'Controls/Extended/RolloverLabel.php',
			'RolloverTab' => 		'Controls/Extended/RolloverTab.php',
			'TabPanel' => 			'Controls/Extended/TabPanel.php',
			'TransferPanel' => 		'Controls/Extended/TransferPanel.php',
			'TreeList' => 			'Controls/Extended/TreeList.php',
			'WindowPanel' => 		'Controls/Extended/WindowPanel.php',
			
			// Auxiliary
			'AccordionPart' => 		'Controls/Auxilary/AccordionPart.php',
			'ColumnHeader' => 		'Controls/Auxilary/ColumnHeader.php',
			'MarkupItem' => 		'Controls/Auxilary/MarkupItem.php',
			'Eventee' => 			'Controls/Auxilary/Eventee.php',
			'Larva' => 				'Controls/Auxilary/Larva.php',
			'ListViewItem' => 		'Controls/Auxilary/ListViewItem.php',
			'MenuItem' => 			'Controls/Auxilary/MenuItem.php',
			'Tab' => 				'Controls/Auxilary/Tab.php',
			'TableColumn' => 		'Controls/Auxilary/TableColumn.php',
			'TableRow' => 			'Controls/Auxilary/TableRow.php',
			'TabPage' => 			'Controls/Auxilary/TabPage.php',
			'TreeNode' => 			'Controls/Auxilary/TreeNode.php',
			
			// Statics
			'Animate' => 			'Statics/Animate.php',
			'ClientScript' => 		'Statics/ClientScript.php',
			'Cursor' => 			'Statics/Cursor.php',
			'Layout' => 			'Statics/Layout.php',
			'Shift' => 				'Statics/Shift.php'
		);
	
	if(isset($_NAutoLoad[$class]))
		require($_NPath . $_NAutoLoad[$class]);
	elseif(is_dir($dir = ($_NPath . 'Nodules/' . $class)))
		require($dir . '/' . $class . '.php');
	elseif(function_exists('__autoload'))
		__autoload($class);
	else 
		BloodyMurder('The class ' . $class . ' is not defined.');
}

spl_autoload_register('_NAutoLoad');

?>