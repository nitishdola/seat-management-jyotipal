<?php set_time_limit(0); 
//$link = mysql_connect(localhost, username, password) or die("Could not connect to host.");//put in your db connection details here
//mysql_select_db(photos) or die("Could not find database."); // put your db name in here where the xxxx are 
include("config/db.php"); 
//define a maxim size for the uploaded images
define ("MAX_SIZE","500"); 
// define the width and height for the thumbnail
// note that theese dimmensions are considered the maximum dimmension and are not fixed, 
// because we have to keep the image ratio intact or it will be deformed
define ("WIDTH","150"); //set here the width you want your thumbnail to be
define ("HEIGHT","150"); //set here the height you want your thumbnail to be.
define ("WIDTH2","299"); //set here the width you want your thumbnail to be
define ("HEIGHT2","299"); //set here the height you want your thumbnail to be.
// this is the function that will create the thumbnail image from the uploaded image
// the resize will be done considering the width and height defined, but without deforming the image
function make_thumb($img_name,$filename,$new_w,$new_h){
//get image extension.
$ext=getExtension($img_name);
//creates the new image using the appropriate function from gd library
if(!strcmp("jpg",$ext) || !strcmp("jpeg",$ext))
$src_img=imagecreatefromjpeg($img_name);
if(!strcmp("png",$ext))
$src_img=imagecreatefrompng($img_name);
if(!strcmp("gif",$ext))
$src_img=imagecreatefromgif($img_name);
//gets the dimmensions of the image
$old_x=imageSX($src_img);
$old_y=imageSY($src_img);
// next we will calculate the new dimmensions for the thumbnail image
// the next steps will be taken: 
// 1. calculate the ratio by dividing the old dimmensions with the new ones
// 2. if the ratio for the width is higher, the width will remain the one define in WIDTH variable
// and the height will be calculated so the image ratio will not change
// 3. otherwise we will use the height ratio for the image
// as a result, only one of the dimmensions will be from the fixed ones
$ratio1=$old_x/$new_w;
$ratio2=$old_y/$new_h;
if($ratio1>$ratio2) {
$thumb_w=$new_w;
$thumb_h=$old_y/$ratio1;
}else{
$thumb_h=$new_h;
$thumb_w=$old_x/$ratio2;
}
// we create a new image with the new dimmensions
$dst_img=ImageCreateTrueColor($thumb_w,$thumb_h);
// resize the big image to the new created one
imagecopyresampled($dst_img,$src_img,0,0,0,0,$thumb_w,$thumb_h,$old_x,$old_y); 
// output the created image to the file. Now we will have the thumbnail into the file named by $filename
if(!strcmp("png",$ext))
imagepng($dst_img,$filename); 
else
imagejpeg($dst_img,$filename);
if (!strcmp("gif",$ext))
imagegif($dst_img,$filename); 
//destroys source and destination images. 
imagedestroy($dst_img); 
imagedestroy($src_img); 
}
// This function reads the extension of the file. 
// It is used to determine if the file is an image by checking the extension. 
function getExtension($str) {
$i = strrpos($str,".");
if (!$i) { return ""; }
$l = strlen($str) - $i;
$ext = substr($str,$i+1,$l);
return $ext;
}
// This variable is used as a flag. The value is initialized with 0 (meaning no error found) 
//and it will be changed to 1 if an error occures. If the error occures the file will not be uploaded.
$errors=0;
// checks if the form has been submitted
if(isset($_POST['Submit'])){
//reads the name of the file the user submitted for uploading
$image=$_FILES['cons_image']['name'];
// if it is not empty
if ($image) 
{
// get the original name of the file from the clients machine
$filename = stripslashes($_FILES['cons_image']['name']);
// get the extension of the file in a lower case format
$extension = getExtension($filename);
$extension = strtolower($extension);
// if it is not a known extension, we will suppose it is an error, print an error message 
//and will not upload the file, otherwise we continue
if (($extension != "jpg") && ($extension != "jpeg") && ($extension != "png") && ($extension != "gif")) {
echo 'Unknown extension! Please use .gif, .jpg or .png files only.';
$errors=1;
}else{
// get the size of the image in bytes
// $_FILES[\'image\'][\'tmp_name\'] is the temporary filename of the file in which 
//the uploaded file was stored on the server
$size=getimagesize($_FILES['cons_image']['tmp_name']);
$sizekb=filesize($_FILES['cons_image']['tmp_name']);
//compare the size with the maxim size we defined and print error if bigger
if ($sizekb > MAX_SIZE*1024)
{
echo 'You have exceeded the 1MB size limit!';
$errors=1;
}
$rand= rand(0, 1000);
//we will give an unique name, for example a random number
$image_name=$rand.'.'.$extension;
//the new name will be containing the full path where will be stored (images folder)
$consname="image/".$image_name; //change the image/ section to where you would like the original image to be stored
$consname2="image/thumb/".$image_name; 
//change the image/thumb to where you would like to store the new created thumb nail of the image
$copied = copy($_FILES['cons_image']['tmp_name'], $consname);
$copied = copy($_FILES['cons_image']['tmp_name'], $consname2);
$sql="INSERT INTO photos (image, image2) VALUES ('$consname', '$consname2')" or die(mysql_error());
$query = mysql_query($sql)or die(mysql_error());
//$sql="UPDATE users SET photo_1= '$consname' WHERE id= '1'" or die(mysql_error()); //$query = mysql_query($sql)or die(mysql_error());
//$sql="UPDATE users SET photo_2= '$consname2' WHERE id= '1'" or die(mysql_error());
//$query = mysql_query($sql)or die(mysql_error());
//we verify if the image has been uploaded, and print error instead
if (!$copied) {
echo 'Copy unsuccessfull!';
$errors=1;
}else{
// the new thumbnail image will be placed in images/thumbs/ folder
$thumb_name=$consname2 ;
// call the function that will create the thumbnail. The function will get as parameters 
//the image name, the thumbnail name and the width and height desired for the thumbnail
$thumb=make_thumb($consname,$thumb_name,WIDTH,HEIGHT);
$thumb=make_thumb($consname,$consname,WIDTH2,HEIGHT2);
}
}
}
}
//If no errors registred, print the success message and how the thumbnail image created
if(isset($_POST['Submit']) && !$errors) {
echo "Thumbnail created Successfully!";
echo '< img src="'.$thumb_name.'">';
//echo $lastid;
}
?>
<html>
<body>
<form name="newad" method="post" enctype="multipart/form-data" action="">
<input type="file" name="cons_image" >
<input name="Submit" type="submit" id="image1" value="Upload image" />
</form>
</body>
</html>