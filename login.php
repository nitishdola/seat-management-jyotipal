<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<style>

.label{
    font-family:Verdana, Arial, Helvetica, sans-serif;
    font-size:11px;
    color:#0066FF;
}
.tableBorder{
    border:solid 1px #0066FF;
    margin-top:100px;
}
.message{
    font-family:Verdana, Arial, Helvetica, sans-serif;
    font-size:14px;
    font-weight:bold;
    color:#0066FF;
}

</style>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Login to Website</title>

<script>


	
function login(){
	var user = document.logn.username;
	var pass = document.logn.password;
	if(user.value=="" || pass.value== "" ){
	alert('Please Enter All field!');
	return false;
	}else{
	return true;
	}
}

</script>
</head>
<body>
<form method="post" action="dashboard.php" name="logn" id="logn" onsubmit="return login();" >
<table cellpadding="2px" cellspacing="1px" bgcolor="#F4F5F7" width="400px" class="tableBorder" align="center">
    <tr>
        <td colspan="2" bgcolor="#0066FF">&nbsp; </td>
    </tr>
    <tr>
        <td colspan="2" class="label">&nbsp;</td>
    </tr>
   
    <tr>
        <td align="center" colspan="2">
            <img src="../images/lock.png" border="0" width="56" align="absbottom"/>&nbsp;
            <span class="message">Login to the Admin Panel</span>
            
        </td>
    </tr>                  
    <tr>
        <td colspan="2" class="label">&nbsp;</td>
    </tr>
	<tr>
        <td class="label" align="right" width="40%">Type:</td>
        <td align="left" width="60%"><select name="type" >
		<option value="admin">Admin</option>
		<option value="faculty">Faculty</option>
		<option value="student">Student</option>
		</select>
        </td>
    </tr>
    <tr>
        <td class="label" align="right" width="40%">Username:</td>
        <td align="left" width="60%"><input type="text" name="username" id="username" maxlength="20"/>
        </td>
    </tr>
    <tr>
        <td class="label" align="right">Password:</td>
        <td align="left"><input type="password" name="password" id="password" maxlength="20" /></td>
    </tr>
    <tr>
        <td class="label" align="right">&nbsp;</td>
        <td align="left"><input type="submit" value="Login" /></td>
    </tr>                  
    <tr>
        <td colspan="2" class="label">&nbsp;</td>
    </tr>                  
</table>
</form>
</body>
</html>


