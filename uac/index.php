<?php
//debugging 
error_reporting(E_ALL);
ini_set('display_errors', '1');
include('./slides.php');
?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Leftose</title>
        <link rel="stylesheet" href="css/style.css" />
		<script src="//code.jquery.com/jquery-latest.min.js"></script>
		<script src="js/unslider.min.js"></script>
		<script type="text/javascript" src="js/jquery.easing.1.3.js"></script>
		<script src="js/js.js"></script>
		<script type="text/javascript" src="js/jquery.stellar.min.js"></script>
		<script src="js/waypoints.min.js"></script>
		<script language="javascript" type="text/javascript">
		function playSound(soundfile,n) {
		  document.getElementById("dummy"+n).innerHTML=
			"<embed src=\""+soundfile+"\" hidden=\"true\" autostart=\"true\" loop=\"false\" />";
		}
		</script>
		<?php $slide1 = new Slide("LandingSlide");
			$bg_left=$slide1->getMedia("background_left");
			$bg_right=$slide1->getMedia("background_right");
			$how = new Slide("How_Leftose_Works");
			$bg_how=$how->getMedia("background_how");
			$tips = new Slide("Helpful_Tips");
			$bg_tips = $tips->getMedia("background_tips");
		?>
		<style>
		#section1a{
background:url('<?php echo $bg_left ?>') no-repeat;
background-size:100% 800px;
}
#section1b{
background:url('<?php echo $bg_right ?>') no-repeat;
background-size:100% 800px;
}
#section2,#section5{
background:url('<?php echo $bg_how ?>') no-repeat;
background-size:100% 800px;
width:100%
}
#section3{
background: -webkit-linear-gradient(white, #efba32); /* For Safari 5.1 to 6.0 */
background: -o-linear-gradient(white, #efba32); /* For Opera 11.1 to 12.0 */
background: -moz-linear-gradient(white, #efba32); /* For Firefox 3.6 to 15 */
background: linear-gradient(white, #efba32); /* Standard syntax */
}
#section4{
	background:url('<?php echo $bg_tips ?>') no-repeat;
	background-size:100% 800px;
}
</style>
    </head>
    <body>
		<div id="header">
			<div class="wrapper">
			
			<div id="logo">
				<a href="index.php">
					<?php $general = new Slide("General");
					$logo = $general->getMedia("logo");
					$footer_logo = $general->getMedia("footer_logo");
					echo "<img src='$logo'/>";
					?>
				</a>
			</div>
			<div id="navbar">
				<ul class="navigation">
				<?php $nav = new Slide("Navigation"); ?>
				 <li data-slide="<?php  echo $nav->getContent("Nav 1 Link"); ?>"><?php  echo $nav->getContent("Nav 1 Name"); ?></li>
				 <li data-slide="<?php  echo $nav->getContent("Nav 2 Link"); ?>"><?php  echo $nav->getContent("Nav 2 Name"); ?></li>
				 <li data-slide="<?php  echo $nav->getContent("Nav 3 Link"); ?>"><?php  echo $nav->getContent("Nav 3 Name"); ?></li>
				</ul>
			</div>	
			</div>
		</div>
		
        <div class="slide" id="slide1"  data-slide="1">
			<div id="section1a"></div>
			<div id="section1b"></div>
			<div class="section_wrapper">
				<div class="section_content_left">
				<img id="st1" src="images/sorethroat.png">
				<?php 
					$blurb = $slide1->getMedia("blurb");
					$audio_cough = $slide1->getMedia("audio_cough");
					$audio_throat = $slide1->getMedia("audio_throat");
					?>
				<div class="main">
					<div class="outer-mask">
						<div class="inner-mask">
							<div class="content" onclick="playSound('<?php echo $audio_throat ?>',1);">
								<img src="images/audio1.png">
								<p><?php  echo $slide1->getContent("left_audio_text"); ?></p>
								<span id="dummy1"></span>
							</div>
						</div>
					</div>
					<div class="outer-mask-bot">
						<div class="inner-mask-bot">
							<div class="content-bot" id="show_slide1"><?php  echo $slide1->getContent("left_bottom_text"); ?></div>
						</div>
					</div>
				</div>
				</div>
				<div id="blurb"><?php echo "<img src='$blurb'/>"; ?></div>
				<div class="section_content_right">
					<img src="images/cough.png">
				
				<div class="main">
					<div class="outer-mask">
						<div class="inner-mask">
							<div class="content" onclick="playSound('<?php echo $audio_cough ?>',2);">
								<img src="images/audio2.png">
								<p><?php  echo $slide1->getContent("right_audio_text"); ?></p>
								<span id="dummy2"></span>
							</div>
						</div>
					</div>
					<div class="outer-mask-bot">
						<div class="inner-mask-bot">
							<div class="content-bot" id="show_slide2"><?php  echo $slide1->getContent("right_bottom_text"); ?></div>
						</div>
					</div>
				</div>
				</div>
			</div>
		</div>
		<?php 
			$Cough_pg1_img = $how->getMedia("Cough_pg1_img");
			$Cough_pg2_img = $how->getMedia("Cough_pg2_img");
			$Cough_pg3_img = $how->getMedia("Cough_pg3_img");
			$Throat_pg1_img = $how->getMedia("Throat_pg1_img");
			$Throat_pg2_img = $how->getMedia("Throat_pg2_img");
			$Throat_pg3_img = $how->getMedia("Throat_pg3_img");
			
			?>
		<div class="slide hide" id="slide4" data-slide="4">
			<div id="section2">
				<div class="section_wrapper">
					<div class="closebutton"><span>&#8963;</span></div>
					<h1><?php  echo $how->getContent("Title"); ?></h1>
					<h2><?php  echo $how->getContent("Subtitle_Throat"); ?></h2>
					<div class="banner">
					<ul>
						<li>
							<?php echo "<img src='$Throat_pg1_img'/>"; ?>
							<p><?php echo $how->getContent("Throat_pg1_text"); ?></p>
						</li>
						<li>
							<?php echo "<img src='$Throat_pg2_img'/>"; ?>
							<p><?php echo $how->getContent("Throat_pg2_text"); ?></p>
						</li>
						<li>
							<?php echo "<img src='$Throat_pg3_img'/>"; ?>
							<p><?php echo $how->getContent("Throat_pg3_text"); ?></p>
						</li>
					</ul>
					</div>
				</div>
			</div>
		</div>
		
		<div class="slide hide" id="slide5" data-slide="5">
			<div id="section5">
				<div class="section_wrapper">
				<div class="closebutton"><span>&#8963;</span></div>
					<h1><?php  echo $how->getContent("Title"); ?></h1>
					<h2><?php  echo $how->getContent("Subtitle_Cough"); ?></h2>
					<div class="banner3">
						<ul>
							<li>
								<?php echo "<img src='$Cough_pg1_img'/>"; ?>
								<p><?php  echo $how->getContent("Cough_pg1_text"); ?></p>
							</li>
							<li>
								<?php echo "<img src='$Cough_pg2_img'/>"; ?>
								<p><?php  echo $how->getContent("Cough_pg2_text"); ?></p>
							</li>
							<li>
								<?php echo "<img src='$Cough_pg3_img'/>"; ?>
								<p><?php  echo $how->getContent("Cough_pg3_text"); ?></p>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		
		<div class="slide" id="slide2" data-slide="2">
			<div id="section3">
			<div class="section_wrapper">
			<?php $slide3 = new Slide("About");
					$product = $slide3->getMedia("product");
					?>
			<h1><?php  echo $slide3->getContent("Title"); ?></h1>
			<h2><?php  echo $slide3->getContent("Subtitle"); ?></h2>
			<?php echo "<img src='$product'/>"; ?>
			<ul class="features">
			<li><?php  echo $slide3->getContent("Feature1"); ?></li>
			<li><?php  echo $slide3->getContent("Feature2"); ?></li>
			<li><?php  echo $slide3->getContent("Feature3"); ?></li>
			<li><?php  echo $slide3->getContent("Feature4"); ?></li>
			<ul>
			
			</div>
			</div>
		</div>
		<div class="available"><?php  echo $slide3->getContent("Available_notice"); ?></div>
		
		<div class="slide" id="slide3" data-slide="3">
			<div id="section4">
			<div class="section_wrapper">
				<?php 
					$tip_pg1_img = $tips->getMedia("tip_pg1_img");
					$tip_pg2_img = $tips->getMedia("tip_pg2_img");
					$tip_pg3_img = $tips->getMedia("tip_pg3_img");
					$tip_pg4_img = $tips->getMedia("tip_pg4_img");
					$facts = new Slide("Fun_Facts");
					$fact_pg1_img = $facts->getMedia("fact_pg1_img");
					$fact_pg2_img = $facts->getMedia("fact_pg2_img");
					
					?>
					<h1><?php  echo $tips->getContent("tip_title"); ?></h1>
				<div class="banner2">
				<ul>
					<li><?php echo "<img src='$tip_pg1_img'/>"; ?>
					<p><?php  echo $tips->getContent("tip_pg1_text"); ?><p>
					</li>
					<li><?php echo "<img src='$tip_pg2_img'/>"; ?>
					<p><?php  echo $tips->getContent("tip_pg2_text"); ?><p>
					</li>
					<li><?php echo "<img src='$tip_pg3_img'/>"; ?>
					<p><?php  echo $tips->getContent("tip_pg3_text"); ?><p>
					</li>
					<li><?php echo "<img src='$tip_pg4_img'/>"; ?>
					<p><?php  echo $tips->getContent("tip_pg4_text"); ?><p>
					</li>
					<li><?php echo "<img src='$fact_pg1_img'/>"; ?>
					<p><?php  echo $facts->getContent("fact_pg1_text"); ?><p>
					</li>
					<li><?php echo "<img src='$fact_pg2_img'/>"; ?>
					<p><?php  echo $facts->getContent("fact_pg2_text"); ?><p>
					</li>
				</ul>
				</div>
					<span id="footer_logo"><a href="http://wellchem.com.sg"><?php echo "<img src='$footer_logo'/>"; ?></a></span>
					<div id="footer">
						<ul>
							<li><?php echo $general->getContent("Address"); ?></li> 
							<li><?php echo $general->getContent("Telephone"); ?></li> 
							<li><a href="mailto:<?php echo $general->getContent("email"); ?>"><?php echo $general->getContent("email"); ?></a></li>
						</ul>
				</div>
			</div>
			</div>
		</div>
		
		
		<script>
		$(function() {
			$('.banner').unslider({
				dots: true,               //  Display dot navigation
			});
			$('.banner2').unslider({
				dots: true,               //  Display dot navigation
			});
			$('.banner3').unslider({
				dots: true,               //  Display dot navigation
			});
		});
		
		</script>
        <br>
    </body>
</html> 
