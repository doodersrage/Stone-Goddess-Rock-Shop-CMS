<%@ Language="VBSCRIPT" %>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<script runat="server">
Public Sub Addfile(ByVal sender As Object, ByVal e As EventArgs)
UploadFile(1, "test", 123, "c:\myfile.jpg")
End Sub

Public Shared Sub UploadFile(ByVal file_id As Integer, ByVal file_name As String, ByVal file_size As Integer, ByVal file_path As String)

Dim Conn As Data.Odbc.OdbcConnection = New Data.Odbc.OdbcConnection("dsn=stonegoddess_com")
Conn.Open()

Dim command As Data.Odbc.OdbcCommand = New Data.Odbc.OdbcCommand("INSERT INTO `files` set file_name=?, file_size=?, file=?")

Dim file() As Byte = GetFile(file_path)

command.Parameters.Add("?", Data.Odbc.OdbcType.VarChar).Value = file_name
command.Parameters.Add("?", Data.Odbc.OdbcType.Int).Value = file_size 
command.Parameters.Add("?", Data.Odbc.OdbcType.Binary).Value = file
command.Connection = Conn
command.ExecuteNonQuery()

Conn.Close() 
End Sub

Public Shared Function GetFile(ByVal file_Path As String) As Byte()
Dim stream As System.IO.FileStream = New System.IO.FileStream(file_Path, IO.FileMode.Open, IO.FileAccess.Read)
Dim reader As System.IO.BinaryReader = New System.IO.BinaryReader(stream)
Dim file() As Byte = reader.ReadBytes(stream.Length)
reader.Close()
stream.Close()
Return file
End Function

</script>
<html xmlns="http://www.w3.org/1999/xhtml" >
<head runat="server">
<title>Untitled Page</title>
</head>
<body>
<form id="form1" runat="server">
<div>
<asp:Button ID="Button1" runat="server" Text="Button" onclick="addfile"/>
</div>
</form>
</body>
</html>