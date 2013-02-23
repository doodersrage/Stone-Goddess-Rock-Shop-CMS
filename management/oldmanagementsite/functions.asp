<%@LANGUAGE="VBSCRIPT" CODEPAGE="1252"%>
<%
'management console variables
dim newslettertxt, newslettertltxt,emailmsgstr
Dim Marque, Num1
Dim SomeDB, condel
Dim recTmp,recTmp2,recTmp3, recTmp9, recTmp10
dim sql, sql2, sql3, sql4
dim itemname,descri,thumbimg,image, file1str
dim recno, recno1
dim stoneitem,stonedescri,stonerecno,thumbimg1,image1
dim password,username,admin
Dim month22, day2, year3, day1, year1, year2
dim fname,mi,lname,address1,address2,city,state12,zip
dim email1,email2,newsletter,password1,password2,born

'other variables
dim strPage, strstone, strnewitems
dim strMail, strNotes, strSubject, strHeader
dim strDEMail, strDENotes, strDETo, strDEFrom, strDESubject, strDEBody, strDESQL
dim strDECoFName, strDECoLName, strDEFName, strDELName
dim strDEAddress, strDEClientID, strDEEMail1, strDEEMail2, strDEAgency, strDEName
dim strDECC, strDESign, strDECoName, strCategory, strLtrName
dim arrCC, strtype,strlinksel, rsAddtopic, SQLtype, linkval, typeval
dim straddtopic, stradddesc, straddurl, rsaddlinks

Dim strSQL, adocon
Dim strName, strcomments, stremail, strlocation, strwebsite, rslinks, strfldtype, strwebname

Set SomeDB = Server.CreateObject ("ADODB.Connection")
SomeDB.Open ("DRIVER={MySQL};SERVER=65.108.89.110;UID=dbadmin;PWD=hxznfw12;DATABASE=stonegoddess_com; OPTION=3;")

%>