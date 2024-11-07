from vaderSentiment.vaderSentiment import SentimentIntensityAnalyzer

# Initialize the VADER sentiment analyzer
analyzer = SentimentIntensityAnalyzer()

# Sample reviews for testing
sample_reviews = [
    "This movie is fantastic! I really hope there’s a sequel. The story is so unique and engaging.",
    "Great movie!",
    "The movie was okay, not the best but watchable.",
    "I didn't like this movie at all.",
    "This is cool, a awesome movie , hope to see another sequel in the future!"
]

# Analyze each review and print the sentiment label
for review in sample_reviews:
    sentiment_scores = analyzer.polarity_scores(review)
    compound_score = sentiment_scores['compound']
    
    # Determine sentiment label based on compound score and custom thresholds
    if compound_score >= 0.05:
        sentiment_label = 'positive'
    elif compound_score <= -0.05:
        sentiment_label = 'negative'
    else:
        sentiment_label = 'neutral'
    
    # Print the review and its sentiment label
    print(f"Review: {review}\nSentiment Label: {sentiment_label}\n")
