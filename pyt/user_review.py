from vaderSentiment.vaderSentiment import SentimentIntensityAnalyzer
import sys


with open("debug_log.txt", "a") as log_file:
    log_file.write(f"Review text received: {sys.argv[1]}\n")
    
# Initialize VADER sentiment analyzer
analyzer = SentimentIntensityAnalyzer()

# Capture the review passed from PHP
review_text = sys.argv[1]

# Calculate sentiment score
sentiment_scores = analyzer.polarity_scores(review_text)
compound_score = sentiment_scores['compound']

# Adjust the threshold to classify sentiment
if compound_score >= 0.05:  # Adjust this to make it more sensitive
    sentiment_label = 'positive'
elif compound_score <= -0.05:  # Adjust this for negative sensitivity
    sentiment_label = 'negative'
else:
    sentiment_label = 'neutral'

# Output the sentiment label so PHP can capture it
print(f"{sentiment_label}")