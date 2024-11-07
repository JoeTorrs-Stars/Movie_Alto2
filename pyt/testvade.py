import sys
from vaderSentiment.vaderSentiment import SentimentIntensityAnalyzer

def analyze_sentiment(review_text):
    analyzer = SentimentIntensityAnalyzer()
    sentiment_scores = analyzer.polarity_scores(review_text)
    compound_score = sentiment_scores['compound']
    
    # Adjust thresholds
    if compound_score >= 0.5:  
        sentiment_label = 'positive'
    elif compound_score <= -0.5:  
        sentiment_label = 'negative'
    else:
        sentiment_label = 'neutral'
    
    return sentiment_label, sentiment_scores

if __name__ == "__main__":
    if len(sys.argv) > 1:
        review_text = sys.argv[1] 
        sentiment_label, sentiment_scores = analyze_sentiment(review_text)

        # Output results
        print(f"Review: {review_text}\nSentiment Label: {sentiment_label}, Compound Score: {sentiment_scores['compound']}")
    else:
        print("No review text provided")
