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
					<img id="correct-title" class="tiny-btn" src="img/correct.png" onclick="CorrectClicked('text-title')" >
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
                                        <img id="correct-intro" class="tiny-btn" src="img/correct.png" onclick="CorrectClicked('text-intro')">
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
                                        <img id="correct-body" class="tiny-btn" src="img/correct.png" onclick="CorrectClicked('text-body')">
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
                                        <img id="correct-conclusion" class="tiny-btn" src="img/correct.png" onclick="CorrectClicked('text-conclusion')">
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
			<textarea id="conversation-box" rows="18" cols="100" placeholder="Enter your text here..."></textarea>
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
				<img id="send-msg" class="med-btn" src="img/send2.png" onclick="AskQuestion()">
			</div>
		</div>

            </div>


	</div>		
    </div>		<!-- body-content -->

  <script>

    const agent_api_url = "http://127.0.0.1:329/process";
    var active_text_area=null;

    //Helper function to inser substring into a string at cursor position
    function insertAtCursor(inputElement, textToInsert) {
            substr = " " + textToInsert + " ";
            // Get the current cursor position
            const cursorPos = inputElement.selectionStart;
            
            // Get the current value of the input field
            const currentValue = inputElement.value;
            
            // Insert the text at the cursor position
            const newValue = currentValue.slice(0, cursorPos) + substr + currentValue.slice(cursorPos);

            // Update the input field with the new value
            inputElement.value = newValue;

            // Move the cursor to the position after the inserted text
            inputElement.selectionStart = inputElement.selectionEnd = cursorPos + substr.length;
    }


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
        inputElement = document.getElementById(active_text_area);
	insertAtCursor(inputElement, speechResult);
      };

      // Handle errors
      recognition.onerror = (event) => {
        console.error('Speech recognition error', event);
      };
    } 
    else {
      alert('Your browser does not support speech recognition.');
    }

    //******************
    //function to call OpenAI agent API
    async function callAIAgent(message) {
            url = agent_api_url + '?prompt=' + message;
	    try {
		const response = await fetch(url);

		if (!response.ok) {
		    //throw new Error(`HTTP error! ' );
		}
		const data = await response.text();
		return data;

	    } catch (error) {
		// Handle errors here
		console.error('API call failed:', error);
	    }
    }

    // event handler
    async function CorrectClicked(text_area) {
       const content = document.getElementById(text_area).value;
       const parts = text_area.split("-");
       const section = parts.length > 1 ? parts[1] : "";   //title, intro, body, conclusion, etc
       const section_dsc = section != "" ? "Note this is the " + section + " section of the essay.":"";
       const message = "Please correct any mistake in the following writing with minimum change." + section_dsc + "Here is the content:" + content;
       //const url = agent_api_url + '?prompt=' + encodeURIComponent(message);
       const result = await callAIAgent(encodeURIComponent(message));
       DisplayInConversationBox(result);

       //read the return result loud
       speak_loud(result);
    }

    //Send button handler
    async function AskQuestion() {
       const text = document.getElementById('text-msg').value;
       if (text != '') {
		const message = text + '. Keep your answer short enough so it will not consume too much time to read.'
		const result = await callAIAgent(encodeURIComponent(message));
		DisplayInConversationBox(result);
		speak_loud(result);
	}
			
    }
    
    function DisplayInConversationBox(text) {
       document.getElementById("conversation-box").value += text;
    }

    //function to speak loud text
    function speak_loud(text) {
	const utterance = new SpeechSynthesisUtterance(text);
        speechSynthesis.speak(utterance);
    }


  </script>

</body>
</div>
