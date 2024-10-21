<?php

/** @var yii\web\View $this */

$this->title = 'My Yii Application';
?>
<div class="site-index">
<body>
    <div class="body-content">
	<div class="row">
            <div class="col-lg-9 mb-3">
			<div class="row">
				<div class="col-lg-9">
					<h5>Title</h5>
				</div>
				<div class="col-lg-1">
					<img id="mic-title" class="tiny-btn" src="img/mic.jpeg" onclick="MicClicked('text-title')">
				</div>
				<div class="col-lg-1">
					<img id="correct-title" class="tiny-btn" src="img/correct.png" >
				</div>
			</div>
			<style> input[type="text"] { width: 850px;} </style>
			<input id="text-title" type="text" cols="100" placeholder="Enter your text here">

			<div class="row">
                                <div class="col-lg-9">
					<h5>Introduction</h5>
				</div>
				<div class="col-lg-1">
                                        <img id="mic-intro" class="tiny-btn" src="img/mic.jpeg" onclick="MicClicked('text-intro')">
                                </div>
                                <div class="col-lg-1">
                                        <img id="correct-intro" class="tiny-btn" src="img/correct.png" >
                                </div>
			</div>
			<textarea id="text-intro" rows="10" cols="100" placeholder="Enter your text here..."></textarea>

			<div class="row">
                                <div class="col-lg-9">
					<h5>Body</h5>
				</div>
				<div class="col-lg-1">
                                        <img id="mic-body" class="tiny-btn" src="img/mic.jpeg" onclick="MicClicked('text-body')">
                                </div>
                                <div class="col-lg-1">
                                        <img id="correct-body" class="tiny-btn" src="img/correct.png" >
                                </div>
			</div>
			<textarea id="text-body" rows="10" cols="100" placeholder="Enter your text here..."></textarea>

			<div class="row">
                                <div class="col-lg-9">
					<h5>Conclusion</h5>
				</div>
				<div class="col-lg-1">
                                        <img id="mic-conclusion" class="tiny-btn" src="img/mic.jpeg" onclick="MicClicked('text-conclusion')">
                                </div>
                                <div class="col-lg-1">
                                        <img id="correct-conclusion" class="tiny-btn" src="img/correct.png" >
                                </div>
			</div>
			<textarea id="text-conclusion" rows="10" cols="100" placeholder="Enter your text here..."></textarea>
            </div>

            <div class="col-lg-3 mb-3">
		<div class="row">
			<div class='col-lg-10'>
                		<h5>ScoreBoard</h5>
			</div>
			<div class='col-lg-2'>
                        	<img id="refresh" class="tiny-btn" src="img/refresh.png" >
			</div>
			<textarea rows="8" cols="100" placeholder="Enter your text here..."></textarea>
		</div>
		<div class="row">
                	<h5>Conversation</h5>
			<textarea rows="18" cols="100" placeholder="Enter your text here..."></textarea>
		</div>
		<div class="row">
			<h10>Message Magister </h10>
			<textarea id="text-msg" rows="2" cols="100" placeholder="Enter your text here..."></textarea>
			
		</div>
		<div class="row">
			<div class="col-lg-7" ></div>
			<div class="col-lg-1", mb-3, style="position: relative;">
				<img id="mic-msg" class="tiny-btn" src="img/mic.jpeg" style="position: absolute; bottom: 0;" onclick="MicClicked('text-msg')">
			</div>
			<div class="col-lg-4", mb-3>
				<img id="send-msg" class="med-btn" src="img/send2.png" >
			</div>
		</div>

            </div>


	</div>		
    </div>		<!-- body-content -->

  <script>

    var active_text_area=null;

    // Check if the browser supports the Web Speech API
    if ('webkitSpeechRecognition' in window) {
      const recognition = new webkitSpeechRecognition();
      recognition.continuous = false; // Stop recognition after speaking
      recognition.interimResults = false; // Only return final results
      recognition.lang = 'en-US'; // Set the language to English

      // Start recognition when the button is clicked

      function MicClicked(text_area) {
	active_text_area = text_area;
	recognition.start();
      }

      // Capture the speech result and insert it into the text area
      recognition.onresult = (event) => {
        const speechResult = event.results[0][0].transcript;
	alert('In index file.  about to insert');
        document.getElementById(active_text_area).value = speechResult;
      };

      // Handle errors
      recognition.onerror = (event) => {
        console.error('Speech recognition error', event);
      };
    } else {
      alert('Your browser does not support speech recognition.');
    }

  </script>

</body>
</div>
