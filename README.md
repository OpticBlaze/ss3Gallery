Silverstripe 3 Photo Gallery
============================
https://github.com/OpticBlaze/ss3Gallery


SS3 Image Gallery is a basic image gallery for use with Silverstripe 3. 
It has the following functionality:

- Create multiple galleries
- Bulk uploading
- Bulk Editing
- Images can have custom image title as well as description
- Gallery displays with Pretty Photo http://www.no-margin-for-errors.com/projects/prettyphoto-jquery-lightbox-clone/
	- This includes displaying title tag and description in gallery view
	- Pretty photo has sharing buttons for facebook and twitter
- Create upload folder directly in gallery

## Requirments
- SilverStripe 3.0 (Tested up to SS3.1.4)
- Bulk editing tools - https://github.com/colymba/GridFieldBulkEditingTools
- Sortable grid field - https://github.com/UndefinedOffset/SortableGridField

## Installation
- Download and copy module in SilverStripe root directory 
- Folder should be called 'ss3Gallery'
- Run dev/build?flush=all to regenerate the manifest
- run ?flush=all in CMS to force the templates to regenerate

### How to include in you template

- Add the following code to your ss template where you want the gallery to display 
  <% include PhotoGallery %>

### Usage 
- Create page
- Click on 'Image Gallery Tab'
- Enter the folder name to which you want to upload the images
  The system will create a new folder in the root of the assets folder
- Make sure you save the page before you use the bulk upload tools. If you dont they the image will upload to a default gallery
- If the user is not an admin and you want him to be able to use the gallery then make sure to enable the edit permissions for the user's group permissions under security tab.


### Known issues
- Any folder created will be in the root of the assets folder. At this momement the gallery does not support nested folders
- The description field is set to a max of 280 charachters. Prettyphoto tends to crash if there are more charachters
- If you find that the photos show on the front end but the jquery gallery does not work it usually means that there is a jquery conflict
