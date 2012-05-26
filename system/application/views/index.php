<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://www.facebook.com/2008/fbml"> 

    <?= $this->load->view('header');?>
   
    <body>
		
		<br />
		
		<center>
	    	<div id='main' > 
			</div>
		</center>
		
		<script type="text/javascript" src="http://static.ak.connect.facebook.com/js/api_lib/v0.4/FeatureLoader.js.php"></script> 
		
		<script type="text/javascript"> 
			FB.init("dd56f03346797a5c198f18fdda305b98","xd_receiver.htm"); 
		</script> 
		
		<!-- OPTIONAL: include this if you want history support -->
    	<iframe src="javascript:''" id="__gwt_historyFrame" tabIndex='-1' style="position:absolute;width:0;height:0;border:0"></iframe>
    	<br /><br />
		
        <?= $this->load->view('footer');?>
		
    </body>
</html>