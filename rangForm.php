<html>
	<head>
		<link rel="stylesheet" href=".\bootstrap-3.3.7-dist\css\bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
		<script src=".\bootstrap-3.3.7-dist\js\jq.2.2.js"></script>
		<script src=".\bootstrap-3.3.7-dist\js\jq-ui.js"></script>
		<style>
			.starRating input { display:none; }
			
			.starRating label { 
			width: 18px; 
			height: 16px; 
			display: inline-block;
			text-indent: -9999px; /* hide the label text off screen */
			background: url("img/star.png") -155px -32px;
			}
			
			.starRating label.on { 
			background-position: -155px -76px;
			}
			div#fullForm {
			max-width: 350px;
			margin: 20% auto;
			height: 400px;
			}
			.votrRait {
			float: ;
			text-align: center;
			}
			div#allRate {
			float: ;
			text-align: center;
			margin-bottom: 10px;
			}
			input[type="submit"] {
			width: 105px;
			}
			div#rating span {
			font-size: 70px;
			}
			#shiva
			{
			width: 100px;
			height: 100px;
			background: red;
			-moz-border-radius: 50px;
			-webkit-border-radius: 50px;
			border-radius: 50px;
			float:left;
			margin:5px;
			}
			.count
			{
			line-height: 100px;
			color:#000;
			font-size:25px;
			}
			#talkbubble {
			width: 120px;
			height: 80px;
			background: red;
			position: relative;
			-moz-border-radius:    10px;
			-webkit-border-radius: 10px;
			border-radius:         10px;
			float:left;
			margin:20px;
			}
			#talkbubble:before {
			content:"";
			position: absolute;
			right: 100%;
			top: 26px;
			width: 0;
			height: 0;
			border-top: 13px solid transparent;
			border-right: 26px solid red;
			border-bottom: 13px solid transparent;
			}
			
			.linker
			{
			font-size : 20px;
			font-color: black;
			}
			.oveR {
			color: #7b7b7b;
			font-size: 20px;
			}
			.leftScrll {
			float: left;
			margin-top: -50px;
			}
			
		</style>
	</head>
	<body>
		<?php 
			
			
			$ratingsFile = '.\bootstrap-3.3.7-dist\count.php';
			
			session_start();
			
			
			function printRating($fileName) {
				$data = file_get_contents($fileName)
				or die('Could not read file!');
				$votes = explode(' ', $data);
				$sum = 0;
				$n = 0;
				for ($i = 0; $i < sizeof($votes); $i++) {
					$sum += ($i+1)*$votes[$i];
					$n += $votes[$i];
				}
				echo "<div id='allRate'><div id='rating'><div class='oveR'>Overall Rating</div>";
				if ($n > 0) {
					$rating = $sum / $n;
					$rating = round(100.0*$rating)/100.0;
					echo "<strong><span class='count'>$rating </span></strong></div>based on $n reviews<br></div></div>";
					} else {
					echo "N/A";
				}
			}
			
			
			if (!isset($_POST['submit'])) {
				$_SESSION['hasVoted'] = 0; 
			?> 
			<div id="fullForm"><div class="votrRait">
				<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST"> 
					<div class="controls rating">
						<label>
						<input type="radio" name="rating" value="1" />1</label>
						<label>
						<input type="radio" name="rating" value="2" />2</label>
						<label>
						<input type="radio" name="rating" value="3" />3</label>
						<label>
						<input type="radio" name="rating" value="4" />4</label>
						<label>
						<input type="radio" name="rating" value="5" />5</label>
					</div>
					<input type="submit" id="inputButton" name="submit" value="Vote"  disabled> 
				</form> </div>
				<?php 
					printRating($ratingsFile);
					} else {
					if (!$_SESSION['hasVoted']) {
						$rating=$_POST['rating'];
						if (is_numeric($rating)
						&& $rating >= 1 && $rating <= 5) {
						
							$data = file_get_contents($ratingsFile)
							or die('Could not read file!');
							$votes = explode(' ', $data);
						
							$votes[$rating-1] += 1;
							
							$file = fopen($ratingsFile, 'w')
							or die('Could not write file!'); 
							fwrite($file, implode(' ', $votes))
							or die('Could not write to file'); 
							fclose($file);
							} else {
							die('Non-numeric or out of range rating!');
						}
						$_SESSION['hasVoted'] = 1; 
					}
					printRating($ratingsFile);
				} 
			?>
			
			</body><script>$('.controls.rating')
			.addClass('starRating')
			.on('mouseenter', 'label', function(){
				DisplayRating($(this)); 
			}
			)
			.on('mouseleave', function() {
				
				var $this = $(this),
				$selectedRating = $this.find('input:checked');
				
				if ($selectedRating.length == 1) {
					DisplayRating($selectedRating.parent());
					} else {
					$this.children().removeClass('on');
				};
			}
			);
			
			var DisplayRating = function($el){
				$el.addClass('on').prevAll().addClass('on');
				$el.nextAll().removeClass('on');
			};
			$('.count').each(function () {
				$(this).prop('Counter',0).animate({
					Counter: $(this).text()
					}, {
					duration: 2000,
					easing: 'swing',
					step: function (num) {
						$(this).text(Math.round(num*10)/10);
					}
				});
			});
			jQuery('.votrRait').insertAfter("#allRate");
			$(window).scroll(function() {    
				var scroll = $(window).scrollTop();
				if (scroll >= 20) {
					$("#allRate").addClass("leftScrll");
				}
				else if (scroll < 20)  {
					$("#allRate").removeClass("leftScrll");
				}
			});
			$('input:radio').click(function() {
			$('#inputButton').removeAttr("disabled");
})

if (!$( "div" ).hasClass( "votrRait" )) {window.location.href = "/task/rangForm.php";}
			</script>
	</html>		