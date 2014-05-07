<?php

 
class GalleryImage extends DataObject {
 
    public static $db = array(	
	  'SortOrder' => 'Int',
	  'Title' => 'Varchar',
	  'Description' => 'Varchar(400)'
  );
 
  // One-to-one relationship with gallery page
  	public static $has_one = array(
    'Image' => 'Image',
    'GalleryPage' => 'GalleryPage',
  );
  
	//Permissions
	function canEdit($Member = null){if(permission::check('EDIT_GALLERY')){return true;}else{return false;}}
	function canCreate($Member = null){if(permission::check('EDIT_GALLERY')){return true;}else{return false;}} 
 
 // Add fields to dataobject
  public function getCMSFields() { 
  		$fields = parent::getCMSFields();
		$fields->removeFieldFromTab("Root.Main","GalleryPageID");
		$fields->removeFieldFromTab("Root.Main","SortOrder");
		
		$fields = new FieldList(
		new TextField('Title','Image Title'),
		new TextAreaField('Description','Photo Description (Max 280 Charachters)'),
		new UploadField('Image','Photo')
  		);
		return $fields;
}

 
  // Add validation
   public function validate() {
        $result = parent::validate();
		$charcount = strlen($this->Description);
		$description = 'You should have less than 280 charchters in the description. You have';
		if($charcount > 280) {
            $result->error($description.' '.$charcount);
        }
        return $result;
    }

   
 
  // Tell the datagrid what fields to show in the table
   public static $summary_fields = array( 
	   'Title' => 'Title',
/*	   'Description'=>'Description',*/
	   'Thumbnail' => 'Thumbnail'     
   );
  
  // this function creates the thumnail for the summary fields to use
   public function getThumbnail() { 
     return $this->Image()->CMSThumbnail();
  }
  
}

