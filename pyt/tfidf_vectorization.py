import sklearn

from sklearn.feature_extraction.text import TfidfVectorizer
from text_preprocessing import preprocess_text

# Sample dataset: list of reviews
reviews = ["This movie is great", "I hated the film", "It was an average movie"]

# Convert text data into feature vectors
vectorizer = TfidfVectorizer(preprocessor=preprocess_text)
X = vectorizer.fit_transform(reviews)

# To see the feature names and the resulting matrix
feature_names = vectorizer.get_feature_names_out()
print(feature_names)
print(X.toarray())
print(sklearn.__version__)
