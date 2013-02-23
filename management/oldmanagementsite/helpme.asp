<% 
if Session("loginadminokay") = True and (session("admin")= 1 or session("admin") = 2) then %>
<div align="center">
<table bgcolor="#CCCCCC">
    <tr> 
      <td width="77%" bgcolor="#FFFFFF"><div align="center"> <font color="#FF0000"><strong><a name="top"></a>Table 
          of Contents:</strong></font> </div> 
        <div align="center">
          <a href="#basics">Basics</a><br />
          <a href="#stonetalk">Stone Talk</a><br />
          <a href="#newsletter">News Letter</a><br />
          <a href="#sendoutnewsletter">Send Out NewsLetter</a><br />
          <a href="#newitems">New Items</a><br />
          <a href="#showtimes">Show Times</a><br />
          <a href="#storeitems">Store Items</a><br />
            Gallery Manager<br />
            User Manager<br />
          Image Uploader</div>
		  <hr>
        <strong><a name="basics"></a>Basics:</strong><br />
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Using this utility will allow you to update
        sections of your website on  the fly. As soon as you post a new topic
        or update a topic that is already 
        on the site it is posted for everyone to see. Unfortunately this interface
         does not supply any form of spell checking so if you wish to have that
        
        feature first edit your posts within Microsoft Word or a like application. <br />
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;If you are at all familiar with browsing the
		web you would have at least at one point come across a web form. These
		web forms are used for submitting information that is then transmitted
		to either some
		form of data store (database) or and email (SMTP). This provides an instantaneous
		push of data from one location to another and is how this system operates.
		When you click on a management modules link you are then presented with
		a bunch of input boxes and drop down menus. In these input boxes you
		will	simply type the data that you wish to have posted to your web
		site into	these	boxes then
		click submit. You data from that point on is tossed into the Stone Goddess
			MySQL Database hosted by Apollo Hosting. When a web browser connects
		to the
		web site your data is queried and presented for the viewer. The only
		section	that does not use this form of transport is the "Send Out NewsLetter" section.
		This section allows you to input your newsletter to be mailed out to
		everyone	on your newsletter mailing list which is then forwarded through
		SMTP.<br />
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;At the top right of nearly every console you
		will see a box with two buttons below it.	These button will read "Delete" and "Edit".
		To edit an item that you have already posted click the edit button and
		the input boxes will have their data filled in for that item.
		To delete an item that you have posted click the delete button. Be careful
		with the delete function, once an item is deleted it cannot be brought
		back unless you retype and submit it
		into the database. Before you click either of these buttons you must
		first click an item in the white box above it. The columns are entitles
		Recno, Added and Name. Recno is the items
		record number within the database, this number is auto created and stays
		the same unless you delete then retype the data for a certain item. Added
		listed	the last date the item was updated.
		Name is the actual name of the item.<br />
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Now that the explanation is done here is
        a simple version of what you  will be doing. Click an item in the site
        area above the buttons. That 
        item is now highlighted. Then click the edit or delete button.<br />
		<a href="#top">Back to top of page</a>
		<hr>
        <strong><a name="stonetalk"></a>Stone Talk:</strong><br />
		In this module you will be able to edit or add
		new posts to the Stone Talk Section of StoneGoddess.com.<br /><br />
		The input boxes found here are:<br />
		Item Name = Here you will input the name of the item that you are adding.<br />
		Description = In this box will go the information for that item.<br />
		Image = This box will allow you to link and uploaded image to that item.<br />
		<a href="#top">Back to top of page</a>
		<hr>
        <strong><a name="newsletter"></a>NewsLetter:</strong><br />
		In this section you will post NewsLetters so that they are viewable on
		the	web site for people that are not on your mailing list.<br />
		<br />
		The input boxes found here are:<br />
		Letter Title = Here you will input the title of your letter.<br />
		Letter = This is where you will input the actual letter to be posted.<br />
		<a href="#top">Back to top of page</a><hr>
        <strong><a name="sendoutnewsletter"></a>Send Out NewsLetter</strong><br />
		In this section you are able to send out newsletter to everyone that
		has sign up	for your newsletter mailing list.<br />
		<br />
		The input boxes found here are:<br />
		Subject = In this box you will type the subject of the newsletter.<br />
		NewsLetter = In this box you will type the body of your newsletter.<br />
		To the right of the console you will see an option that says "Add client
		to mailing list here". In this box you will type the email address of the
		client that you wish to add then click the submit button to the right of the
		box. This will send a confirmation email to the recipient. Once they confirm
		they are added to your mailing list.<br />
		<a href="#top">Back to top of page</a><hr>
        <strong><a name="newitems"></a>New Items</strong><br />
		Here you will post new items that you want listed for your stores.<br /><br />
		The input boxes found here are:<br />
		Item Title = In this box you will put the title of this listing.<br />
		Item Listings = In this box you will list your new items.<br />
		<a href="#top">Back to top of page</a><hr>
        <strong><a name="showtimes"></a>Show Times</strong><br />
		Here you will input dates and information for upcoming shows.<br /><br />
		The input boxes found here are:<br />
		Show Date = This item is configure by a group of three drop down menus allowing you
		to assign a day, month and year for this show.<br />
		Show = In this box you will type the name of the show.<br />
		Details = In this box you will type the details for the show.<br />
		<a href="#top">Back to top of page</a><hr>
        <strong><a name="storeitems"></a>Store Items</strong><br />
		In this section you will input and edit items to be listed in the Stone Goddess
		web store.<br /><br />
		The input boxes found here are:<br />
		Item Name = In this box you will type the name of the item.<br />
		Description = In this box you will type a description of the item.<br />
		Price = In this box you will type a price for the item. (Leave out the dollar sign that
		is added by the store itself)<br />
		Quantity = In this box you will list the amount of the item you wish to sell. (This number will be 
		reduced over time as you sell an item)<br />
		Weight = In this box you will enter the items weight. (in the box to the right select the items measurement)<br />
        Select Image = If you have uploaded an image for this item through the
         image uploader utility you can select the image here for display along
        
        with the item.<br />
		Item Category = Here you will select the items category for display from
		the drop down menu.<br />
		<a href="#top">Back to top of page</a><hr>
	  </td>

    </tr>
    <tr>
      <td>&nbsp;</td>
    </tr>
  </table>
</div>
<% 
else 
%>
You either do not have privileges to this page or you have not logged in. <a href="http://stonegoddess.com/management/default.asp?logout=1">Click
here to login.</a>

<%
end if
%>