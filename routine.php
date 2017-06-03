<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" href="voting.css"/>
<style>

.label{
    font-family:Verdana, Arial, Helvetica, sans-serif;
    font-size:11px;
    color:#213F99;
}
.tableBorder{
    border:solid 1px #213F99;
    margin-top:100px;
}
.message{
    font-family:Verdana, Arial, Helvetica, sans-serif;
    font-size:14px;
    font-weight:bold;
    color:#213F99;
} 
.error{ 
	font-family:Verdana, Arial, Helvetica, sans-serif;
    font-size:15px;
	color:#FFF;
	}

</style>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>check your routine</title>


</head>
<body>

<form method="post" action="welcome.php" name="logn" id="logn" onsubmit="return login();" >
<table cellpadding="2px" cellspacing="1px" bgcolor="#F4F5F7" width="400px" class="tableBorder" align="center">
    <tr>
        <td colspan="2" bgcolor="#213F99">&nbsp;
			<span class="error">
				<?php if(!empty($_GET['msg'])) echo $_GET['msg']; ?>
			</span>
		</td>
    </tr>
    <tr>
        <td colspan="2" class="label">&nbsp;</td>
    </tr>
   
    <tr>
        <td align="center" colspan="2"> 
            <span class="message">select your semester</span>
            
        </td>
    </tr>                  
    <tr>
        <td colspan="2" class="label">&nbsp;</td>
    </tr>
	<tr>
        <td class="label" align="right" width="40%">Type:</td>
        <td align="left" width="60%"><select name="type" >
		<option value="admin">2</option>
		<option value="faculty">4</option>
		<option value="student">6</option>
		<option value="student">8</option>
		</select>
        </td>
    </tr>
    <tr>
       
        <td class="label" align="right">&nbsp;</td>
        <td align="left"><input type="submit" name="submit" value="submit" /></td>
    </tr>                  
    <tr>
        <td colspan="2" class="label">&nbsp;</td>
    </tr>                  
</table>
</form>
</body>
</html>


