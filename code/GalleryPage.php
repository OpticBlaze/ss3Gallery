<?php

class GalleryPage extends Page {
	

	public static $db = array(
	'GalFolder' => 'Varchar(100)'
	);
	
	// Used to automatically include photos in a specific folder
	static $has_one = array(
	);
	
	// One gallery page has many gallery images
	public static $has_many = array(
    'GalleryImages' => 'GalleryImage'
  	);
	
	// Add CMS description	
	static $description = "Add a Photo Gallery to the site";
	static $singular_name = 'Photo Gallery';
	
	
	// Set Permissions
	function canEdit($Member = null){if(permission::check('EDIT_GALLERY')){return true;}else{return false;}}
	function canCreate($Member = null){if(permission::check('EDIT_GALLERY')){return true;}else{return false;}}

   	
	public function getCMSFields() {
	   
   		$fields = parent::getCMSFields();
		
			$gridFieldConfig = GridFieldConfig_RecordEditor::create(); 
			$gridFieldConfig->addComponent(new GridFieldBulkImageUpload());
			$gridFieldConfig->addComponent(new GridFieldBulkManager());
			
		
			// Creates field where you can type in the folder name --- IT WILL CREATE IN ROOT OF ASSET DIRECTORY!!!
			$fields->addFieldToTab("Root.ImageGallery", new TextField('GalFolder','Folder name')
			);
				
			// Used to determine upload folder
			if($this->GalFolder!='' || $this->GalFolder!=NULL) {
			// Specify the upload folder 
			$uploadfoldername = $this->GalFolder;
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
			
		
			// Creates sortable grid field
			$gridfield = new GridField("GalleryImages", "Image Gallery", $this->GalleryImages()->sort("SortOrder"), $gridFieldConfig);
			$fields->addFieldToTab('Root.ImageGallery', $gridfield);
						
		return $fields;
		
	}
		// Check that folder name conforms to assets class standards. remove spaces and special charachters if used
		function onBeforeWrite() {
			$this->GalFolder = str_replace(array(' ','-'),'-', preg_replace('/\.[^.]+$/', '-', $this->GalFolder));
	
		parent::onBeforeWrite();
		}
		

}


class GalleryPage_Controller extends Page_Controller implements PermissionProvider  {
		
		
		public function init() {
        parent::init();
		//Load requirements
		Requirements::css("ss3Gallery/css/prettyPhoto.css");
		Requirements::css("ss3Gallery/css/prettyPhotoCustom.css");
		Requirements::javascript("ss3Gallery/js/jquery-1.7.1.min.js");
		Requirements::javascript("ss3Gallery/js/jquery.prettyPhoto.js");
		
		// Call the pretty photo jquery
		Requirements::customScript("
		
		$(document).ready(function(){
		$(\"a[rel^='prettyPhoto']\").hover(function() {
      	$(this).stop().animate({opacity: \"0.3\"}, 'fast');
    	},
    	function() {
      	$(this).stop().animate({opacity: \"1\"}, \"slow\");
    	});
		$(\"a[rel^='prettyPhoto']\").prettyPhoto({animation_speed:'normal',theme:'light_square',slideshow:4000, autoplay_slideshow: false, show_title: true, allow_resize: true, deeplinking: true});
		});"				
		);
		}
		
		 
		//Add permission check boxes to CMS
		public function providePermissions() {
		return array(
		  "VIEW_GALLERY" => "View Gallery Pages",
		  "EDIT_GALLERY" => "Edit Gallery Pages",
		);
		}
		
		// Set sort order for images
		public function GetGalleryImages() {
		return $this->GalleryImages()->sort("SortOrder");
		}
}