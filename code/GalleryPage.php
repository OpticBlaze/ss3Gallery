<?php

class GalleryPage extends Page {
	

	public static $db = array(
	);
	
	// Used to automatically include photos in a specific folder
	static $has_one = array(
		"AutoFolder" => "Folder"
	);
	
	// One gallery page has many gallery images
	public static $has_many = array(
    'GalleryImages' => 'GalleryImage'
  	);
	
	static $description = "Add a Photo Gallery to the site";
	static $singular_name = 'Photo Gallery';

   public function getCMSFields() {
	   
   		$fields = parent::getCMSFields();
		
			$gridFieldConfig = GridFieldConfig_RecordEditor::create(); 
			$gridFieldConfig->addComponent(new GridFieldBulkEditingTools());
			$gridFieldConfig->addComponent(new GridFieldBulkImageUpload());
			$gridFieldConfig->addComponent(new GridFieldBulkManager());
			
			// Used to determine upload folder
			if($this->AutoFolderID) {
			// Specify the upload folder -- this uses the drop down field that is created below to get folder name
			$uploadfolder = DataObject::get_by_id("Folder", $this->AutoFolderID);
			$uploadfoldername = $uploadfolder->Name;
			$gridFieldConfig->getComponentByType('GridFieldBulkImageUpload')->setConfig('folderName', $uploadfoldername);
			}
			else {
			$gridFieldConfig->getComponentByType('GridFieldBulkImageUpload')->setConfig('folderName', 'Gallery-Images');	
			}
			
			// Customise gridfield
			$gridFieldConfig->removeComponentsByType('GridFieldPaginator'); // Remove default paginator
			$gridFieldConfig->addComponent(new GridFieldPaginator(20)); // Add custom paginator
			$gridFieldConfig->addComponent(new GridFieldSortableRows('SortOrder')); 
			$gridFieldConfig->removeComponentsByType('GridFieldAddNewButton'); // We only use bulk upload button
			
						
			// Creates drop down menu so that you can select the folder that you want included
			$fields->addFieldToTab("Root.ImageGallery", new TreeDropdownField("AutoFolderID","Existing folder where you want images uploaded","Folder"));
			

			// Creates sortable grid field
			$gridfield = new GridField("GalleryImages", "Image Gallery", $this->GalleryImages()->sort("SortOrder"), $gridFieldConfig);
			$fields->addFieldToTab('Root.ImageGallery', $gridfield);
						
		return $fields;
		
	}
		

}


class GalleryPage_Controller extends Page_Controller {
	
	public static $allowed_actions = array (
	);
	
	public function GetGalleryImages() {
		return $this->GalleryImages()->sort("SortOrder");
	}
	

	public function init() {
		parent::init();		
		Requirements::css('ss3Gallery/css/prettyPhoto.css');
		// I recommend you comment prettyPhotoCustom out and put this file in your themes folder to customise look and feel
		// Dont forget to include it in your page.ss file in your themes folder
		// Requirements::css('ss3Gallery/css/prettyPhotoCustom.css'); 
		Requirements::javascript('ss3Gallery/js/jquery-1.7.1.min.js');
		Requirements::javascript('ss3Gallery/js/jquery.prettyPhoto.js');	
		Requirements::customScript('						   
		$(document).ready(function(){
		$("a[rel^=\'prettyPhoto\']").prettyPhoto();
		});
		');
	}

}