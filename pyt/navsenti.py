import nltk
import mysql.connector
from nltk.tokenize import word_tokenize
from nltk.corpus import stopwords

# Ensure stopwords are downloaded
nltk.download('punkt')
nltk.download('stopwords')

# Database configuration
db_config = {
    'user': 'root',
    'password': '',
    'host': 'localhost',
    'database': 'moviealtofinal',
    'raise_on_warnings': True
}

# Initialize stop words
stop_words = set(stopwords.words('english'))

def connect_db():
    return mysql.connector.connect(**db_config)

def fetch_reviews(conn):
    cursor = conn.cursor()
    cursor.execute("SELECT reviews FROM review_rate")
    return cursor.fetchall()

def remove_stopwords(tokens):
    return [word for word in tokens if word.lower() not in stop_words]

def calculate_sentiment(review):
    # Tokenize and remove stop words
    tokens = word_tokenize(review)
    tokens = remove_stopwords(tokens)
    
    # Placeholder sentiment analysis logic
    sentiment_score = 1 if 'good' in tokens else -1 if 'bad' in tokens else 0
    sentiment_label = 'pos' if sentiment_score > 0 else 'neg' if sentiment_score < 0 else 'neutral'
    
    return sentiment_score, sentiment_label

def submit_review(conn, review_text):
    sentiment_score, sentiment_label = calculate_sentiment(review_text)
    
    cursor = conn.cursor()
    # Adjusted SQL syntax for MySQL
    cursor.execute("INSERT INTO review_rate (reviews, sentiment_score, sentiment_label) VALUES (%s, %s, %s)",
                   (review_text, sentiment_score, sentiment_label))
    conn.commit()

def main():
    conn = connect_db()
    
    # Fetch and print reviews
    reviews = fetch_reviews(conn)
    for review in reviews:
        print(review[0])
    
    # Submit a new review
    new_review = "The hotel was good and the service was great."
    submit_review(conn, new_review)
    
    conn.close()

if __name__ == '__main__':
    main()
