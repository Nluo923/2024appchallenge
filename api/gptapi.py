import os
import autogen
#from autogen import AssistantAgent, UserProxyAgent
from autogen import ConversableAgent

llm_config = {"model": "gpt-4", "api_key": os.environ["OPENAI_API_KEY"]}

father = ConversableAgent(
	"Jeff", 
	system_message = "Your name is Jeff and you are father of Nick who you are going to.",
	llm_config = llm_config, 
	code_execution_config = False,
	function_map = None,
	human_input_mode = "NEVER"
	)

son = ConversableAgent(
	"Nick",
	system_message = "Your name is Nick.  You are going to have a conversation with your father Jeff.",
	llm_config = llm_config,
	human_input_mode = "NEVER"
)

reply = father.initiate_chat(son, message="Hi Nick.  I saw you are nerverse when you are taking pictures.  Can you smile next time?", max_turns=5)
print(reply)




