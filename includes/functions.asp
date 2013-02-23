<%@LANGUAGE="VBSCRIPT" CODEPAGE="1252"%>
<%
dim recTmp10
dim strreccnt
dim strPage, strstone, strnewitems
dim strMail, strNotes, strSubject, strHeader
dim strDEMail, strDENotes, strDETo, strDEFrom, strDESubject, strDEBody, strDESQL
dim strDECoFName, strDECoLName, strDEFName, strDELName
dim strDEAddress, strDEClientID, strDEEMail1, strDEEMail2, strDEAgency, strDEName
dim strDECC, strDESign, strDECoName, strCategory, strLtrName
dim arrCC, strtype,strlinksel, rsAddtopic, SQLtype, linkval, typeval
dim straddtopic, stradddesc, straddurl, rsaddlinks, emailaddr

Dim strSQL, adocon
Dim strName, strcomments, stremail, strlocation, strwebsite, rslinks, strfldtype, strwebname
dim vwamt, sql12
Dim SomeDB, constring

constring = "DRIVER={MySQL};SERVER=65.108.89.110;UID=dbadmin;" & _
 "PWD=hxznfw12;DATABASE=stonegoddess_com; OPTION=3;"

sub connectdb()
Set SomeDB = Server.CreateObject ("ADODB.Connection")
SomeDB.Open (constring)
end sub

sub enddbcon()
SomeDB.Close
Set SomeDB = Nothing
end sub

sub joinmaillist(emailaddr)
Set mailmsg = Server.CreateObject("CDONTS.NewMail")
mailmsg.From = emailaddr
mailmsg.To = "NewsLetter-request@stonegoddess.com"
mailmsg.Subject = "subscribe"
mailmsg.Body = "subscribe"
mailmsg.Send
Set mailmsg = Nothing
end sub
%>