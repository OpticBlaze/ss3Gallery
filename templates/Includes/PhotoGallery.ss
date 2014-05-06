<% if getGalleryImages %>
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
<% end_if %>