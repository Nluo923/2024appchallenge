from flask import Flask, request, jsonify
from autogen.agentchat.contrib.gpt_assistant_agent import GPTAssistantAgent
import openai, os

# Initialize Flask app
app = Flask(__name__)

# Initialize OpenAI API Key
openai.api_key = os.environ["OPENAI_API_KEY"]

# Initialize GPTAssistantAgent
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

agent = GPTAssistantAgent(
    name="magister_agent",
    llm_config=llm_config,
)


@app.route('/ask', methods=['GET'])
def ask_question():
    # Get the question from the request JSON body
    question = request.args.get("prompt", "None")
    
    try:
        # Use the GPTAssistantAgent to process the question
        response = agent.generate_reply( messages=[{"content":question, "role": "user"}])
        
        # Return the agent's response as a JSON object
        return response["content"]
    
    except Exception as e:
        print("Exception:", e)
        return 'error.  Exception on calling generate_respose()'

if __name__ == '__main__':
    app.run(debug=True)
