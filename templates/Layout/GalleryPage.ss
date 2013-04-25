<div class="typography">

<% if Menu(2) %>
    <% include SideBar %>
    <div id="Content" class="grid_9 omega">        
    <% end_if %>
        
    <h2>$Title</h2>
    $Content
    $Form
         
<div id="ImageGalleryEntries">
	<p> $AlbumDescription </p>

    <ul>
        <% loop getGalleryImages %>
            <li class="$EvenOdd $FirstLast IGE{$Pos} galentries">
            <a href="$Image.URL" rel="prettyPhoto[gallery1]" title="$Description">
            
            <% loop Image.SetWidth(280) %>
            <img src="$Link"  
            <% end_loop %>
            alt="$Title" />
            
            </a></li>
        <% end_loop %>
    </ul>
    
</div>
	<% if Menu(2) %>
		</div>
		<div class="clear"> </div>
	<% end_if %>
</div>
   