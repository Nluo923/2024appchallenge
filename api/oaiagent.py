import os
from autogen import config_list_from_json
from autogen.agentchat.contrib.gpt_assistant_agent import GPTAssistantAgent

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

instructions = "You are a specialist who teach English writing for middle school students with dyslexia.  Your goal is to give them help when they have difficulties during writing.  Your advice and choice of words should be suitable for their age and with consideration of their learning disability."

oai_agent = GPTAssistantAgent(
    name="magister_agent",
    llm_config=llm_config,
    instructions=instructions,
    assistant_config=assistant_config,
)

reply = oai_agent.generate_reply(messages=[{"content": "I am going to write about my cat.  What do you propose on the details to write about?", "role": "user"}])
print (reply)

