# filename: stock_plot.py

import pandas as pd
import matplotlib.pyplot as plt
from pandas_datareader import data

# Define which online source to use
online_source = "yahoo"

# Define the start and end dates
start_date = pd.to_datetime('2022-01-01')
end_date = pd.to_datetime('today')

# Use pandas_datareader to get the stock price data
nvda = data.DataReader("NVDA", online_source, start_date, end_date)
tesla = data.DataReader("TSLA", online_source, start_date, end_date)

# Compute percentage change
nvda_change = nvda['Adj Close'].pct_change() * 100
tesla_change = tesla['Adj Close'].pct_change() * 100

# Create a time series plot.
plt.figure(figsize=(10, 5))

nvda_change.plot(label='NVDA')
tesla_change.plot(label='TESLA')

plt.title('NVDA and TESLA Stock Price Change YTD')
plt.xlabel('Date')
plt.ylabel('Percent Change')
plt.legend()
plt.grid(True)

# Show the plot
plt.show()