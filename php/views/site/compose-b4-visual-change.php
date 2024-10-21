<?php

/** @var yii\web\View $this */

$this->title = 'My Yii Application';
?>
<div class="site-index">
<body>
    <div class="body-content">
	<div class="row">
	   
            <div class="col-lg-9 mb-3" style="width:900px">
			<div class="row">
				<div class="col-lg-10">
					<h5>Title</h5>
				</div>
				<div class="col-lg-1">
					<img id="mic-title" class="tiny-btn" src="img/mic.jpeg" style="float:right" onclick="MicClicked('text-title')">
				</div>
				<div class="col-lg-1">
					<img id="correct-title" class="tiny-btn" src="img/correct.png" onclick="CorrectClicked('text-title')" >
				</div>
			</div>
			<style> input[type="text"] { width: 873px;} </style>
			<input id="text-title" type="text" cols="100" placeholder="Enter your text here" style="border-radius: 8px">

			<div class="row">
                                <div class="col-lg-10">
					<h5>Introduction</h5>
				</div>
				<div class="col-lg-1">
                                        <img id="mic-intro" class="tiny-btn" src="img/mic.jpeg" style="float:right" onclick="MicClicked('text-intro')">
                                </div>
                                <div class="col-lg-1">
                                        <img id="correct-intro" class="tiny-btn" src="img/correct.png" onclick="CorrectClicked('text-intro')">
                                </div>
			</div>
			<textarea id="text-intro" rows="10" cols="100" placeholder="Enter your text here..." style="border-radius: 8px"></textarea>

			<div class="row">
                                <div class="col-lg-10">
					<h5>Body</h5>
				</div>
				<div class="col-lg-1">
                                        <img id="mic-body" class="tiny-btn" src="img/mic.jpeg" style="float:right" onclick="MicClicked('text-body')">
                                </div>
                                <div class="col-lg-1">
                                        <img id="correct-body" class="tiny-btn" src="img/correct.png" onclick="CorrectClicked('text-body')">
                                </div>
			</div>
			<textarea id="text-body" rows="10" cols="100" placeholder="Enter your text here..." style="border-radius: 8px"></textarea>

			<div class="row">
                                <div class="col-lg-10">
					<h5>Conclusion</h5>
				</div>
				<div class="col-lg-1">
                                        <img id="mic-conclusion" class="tiny-btn" src="img/mic.jpeg" style="float:right" onclick="MicClicked('text-conclusion')">
                                </div>
                                <div class="col-lg-1">
                                        <img id="correct-conclusion" class="tiny-btn" src="img/correct.png" onclick="CorrectClicked('text-conclusion')">
                                </div>
			</div>
			<textarea id="text-conclusion" rows="10" cols="100" placeholder="Enter your text here..." style="border-radius: 8px"></textarea>
            </div>

            <div class="col-lg-3 mb-3" style="width:400px">
		<div class="row">
			<div class='col-lg-10'>
                		<h5>ScoreBoard</h5>
			</div>
			<div class='col-lg-2'>
                        	<img id="refresh" class="tiny-btn" src="img/refresh.png" onclick="RefreshScore()">
			</div>
			<textarea id="text-score" rows="8" cols="100" placeholder="Enter your text here..." style="border-radius: 16px"></textarea>
		</div>

		<!-- ###### Begin conversation display area.  ######### -->
		<div class="row">
                	<h5 style="padding-top: 10px;">Conversation</h5>
			<div class="container" id="chatContainer", style="height:450px; border:1px solid #ccc;border-radius: 16px;overflow-y: auto;box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
				<!-- <textarea id="conversation-box" rows="18" cols="100" placeholder="Conversation will be displayed here..."></textarea>  -->
			</div>
		</div>
		<!-- ##### End conversation display area #### -->

		<div class="row">
			<h10 style="padding-top: 10px;">Ask Magister </h10>
			<textarea id="text-msg" rows="2" cols="100" placeholder="Enter your question here..." style="border-radius: 8px"></textarea>
			
		</div>
		<div class="row">
			<div class="col-lg-7" ></div>
			<div class="col-lg-1", mb-3, style="position: relative;">
				<img id="mic-msg" class="tiny-btn" src="img/mic.jpeg" style="position: absolute; bottom: 0; left: 0px" onclick="MicClicked('text-msg')">
			</div>
			<div class="col-lg-4", mb-3, style="padding-left:0px">
				<img id="send-msg" class="med-btn" src="img/send2.png" style="float:right" onclick="AskQuestion()">
			</div>
		</div>

            </div>


	</div>		
    </div>		<!-- body-content -->


    <!-- For pop-up  -->
    <div class="overlay" id="overlay"></div>

    <!-- Pop-up Window -->
    <div class="popup" id="popup" style="width:550px;height:350px;text-align:center; ">
	    <h4 style="padding-top:70px">Tell us what you are about to write today</h4>
	    <p id='start-hint'>Click the microphone button and start speaking.</p>
	    <div id="progressBar" style="height:20px;display:none">
    		<div id="progress" style="width:508px; height:20px"></div>
	    </div>
	    <img id="start-btn" src="img/mic.jpeg" style="margin:20px; width:70px">
	    <img id="cancel-btn" src="img/cancel.png" style="margin:20px; width:70px">
    </div>


  <script>

    const agent_api_url = "http://127.0.0.1:329/process";
    var active_text_area=null;

    //add Enter key listener for send message box
    document.getElementById('text-msg').addEventListener('keydown', function(event) {
        // Check if the Enter key was pressed
        if (event.key === 'Enter') {
            event.preventDefault(); // Prevent the default action (submitting form or adding newline)
            AskQuestion(); // Call the function to send the message
        }
    })

    //listeners for buttons on popoup
    document.getElementById('start-btn').addEventListener('click', function() {
	document.getElementById('start-hint').style.display = 'none';
	document.getElementById('progressBar').style.display = 'block';
	startProgress();
        MicClicked('what-to-write');
    });

    document.getElementById('cancel-btn').addEventListener('click', function() {
        document.getElementById('popup').style.display = 'none';
        document.getElementById('overlay').style.display = 'none';
    });


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
        let speechResult = event.results[0][0].transcript;
	if (active_text_area == 'what-to-write') {
		document.getElementById('text-msg').value = 'I am going to write this today:' + speechResult + '. Please help me within this context';
		AskQuestion();
        	document.getElementById('popup').style.display = 'none';
        	document.getElementById('overlay').style.display = 'none';
	} 
	else {
		inputElement = document.getElementById(active_text_area);
		if (active_text_area == 'text-msg') {
			speechResult = formatString(speechResult);
		} 
		insertAtCursor(inputElement, speechResult);
	
	}
      }

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
       const message = "Please correct any mistake in the following writing with minimum change. Depending on which section the content is for, point out imperfections(e.g., lack of details, etc.) and give examples on how to improve." + section_dsc + "Here is the content:" + content;
       //const url = agent_api_url + '?prompt=' + encodeURIComponent(message);
       const result = await callAIAgent(encodeURIComponent(message));
       DisplayInConversationBox('answer', result);

       //read the return result loud
       speak_loud(result);
    }

    //Send button handler
    async function AskQuestion() {
       const text = document.getElementById('text-msg').value;
       if (text != '') {
		DisplayInConversationBox('question', text);
		const message = text + '. Keep your answer short enough so it will not consume too much time to read.'
		const result = await callAIAgent(encodeURIComponent(message));
		DisplayInConversationBox('answer', result);
		speak_loud(result);
		document.getElementById('text-msg').value = "";
	}
			
    }

    async function RefreshScore() {
	//1. Get complete content
	var content = "The title is: '" + document.getElementById('text-title') + "'."
	content = content + "Here is the overall essay: \n '"; 
	content = content + document.getElementById('text-intro').value + "\n";
	content = content + document.getElementById('text-body').value + "\n";
	content = content + document.getElementById('text-conclusion').value + "\n";
	content = content + "'";

	//2. Construct prompt
	let message = "Score my writing in A, B, C, D with regard to the following aspects: grammar and sentence structure, spelling and word of usage, content and idea, organization, Fluency and Cohesion, Clarity and Conciseness, and overall score.  Organize the results in such a way as 'Grammar and sentence Structure: A', with one line each."
	message = message + content;
	console.log(message);

	//3. Call agent to get scores
	const result = await callAIAgent(encodeURIComponent(message));

	//4. Display scores and read loud
	document.getElementById('text-score').value = result;
	speak_loud(result);
    }
    
    function DisplayInConversationBox(type, content) {
       <!-- document.getElementById("conversation-box").value += text;  -->
	const chatContainer = document.getElementById('chatContainer');
	const displayDiv = document.createElement('div');
        if (type == 'question') {
		displayDiv.className = 'message question';
		displayDiv.style = 'margin-right: 0px';
	} else {
		displayDiv.className = 'message answer';
		displayDiv.style = 'padding-left: 0px';
	}
        displayDiv.textContent = content; 
	//console.log(content)
        chatContainer.appendChild(displayDiv);
	chatContainer.scrollTop = chatContainer.scrollHeight;
    }

    //function to speak loud text
    function speak_loud(text) {
	const utterance = new SpeechSynthesisUtterance(text);
        speechSynthesis.speak(utterance);
    }

    //Normalize a sentence
    function formatString(input) {
	    // Trim whitespace from the start and end of the string
	    let trimmedString = input.trim();

	    // Capitalize the first letter
	    let formattedString = trimmedString.charAt(0).toUpperCase() + trimmedString.slice(1);

	    // Add a period at the end if there isn't one already
	    if (formattedString.charAt(formattedString.length - 1) !== '?') {
		formattedString += '?';
	    }
    return formattedString;
    }

    //Rolling a progress bar
    function startProgress() {
        const progressBar = document.getElementById('progressBar');
	progressBar.style.display = 'block';
    }

  </script>

</body>
</div>
