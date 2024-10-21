from flask import Flask, request, jsonify
from flask_cors import CORS
import os
from autogen import config_list_from_json
from autogen.agentchat.contrib.gpt_assistant_agent import GPTAssistantAgent
from autogen import ConversableAgent

app = Flask(__name__)
CORS(app)

# Create OpenAI agent instance
config_list = [
    {
        "model": "gpt-4",
        "api_key":os.environ["OPENAI_API_KEY"]
    },
    {
        "model": "gpt-3.5-turbo",
        "api_key":os.environ["OPENAI_API_KEY"]
    }
]

llm_config = {
    "config_list": config_list,
}

assistant_id = os.environ.get("ASSISTANT_ID", None)
assistant_config = {
    # define the openai assistant behavior as you need
}

role_descr = "You are a specialist who teach English writing for middle school students with dyslexia.  Your goal is to give them help when they have difficulties during writing.  Your advice and choice of words should be suitable for their age and with consideration of their learning disability. Keep your answer brief since long answer make it harder for the students to read. Talk in a way that make student feell fun to work with you."

#oai_agent = GPTAssistantAgent(
oai_agent = ConversableAgent(
    name="magister_agent",
    llm_config=llm_config,
    #instructions=role_descr,
    system_message=role_descr,
    #assistant_config=assistant_config,
)

print('Magister LLM Agent service is running now.\n  Listen on Port 329...')


# Define a simple route that responds to HTTP GET requests
@app.route('/')
def home():
    return "Welcome to Magister LLM Agent Service!"

# Define a route that handles a POST request with JSON data
@app.route('/process', methods=['GET'])
def process_data():
        # Parse the incoming JSON data
        prompt = request.args.get("prompt", "None")
        if 'prompt' != "None": 
                message = [{"content":prompt, "role": "user"}]
                print("Message to be sent: ", message)
                try:
                        #reply = oai_agent.generate_reply(messages=message)["content"]
                        reply = oai_agent.generate_reply(messages=message)
                        print("Response received: ", reply)
                except Exception as e:
                        print("exception encountered.", e)
                        return 'error.  Exception on calling generate_respose().  See server log for details.'

        else:
                reply = "No prompt received from our request."

        return reply


# Create agent instance and Start the Flask app on port 5000
if __name__ == '__main__':
        # Start service
        app.run(host='0.0.0.0', port=329)
