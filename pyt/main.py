import math
import sys
import naivesent as nbc
import unittest

def f_score(data, predict):
    actual = [line.split('|')[0].strip() for line in data]

    tp = fp = tn = fn = 0
    for i in range(len(actual)):
        if predict[i] == '5' and actual[i] == '5':
            tp += 1
        elif predict[i] == '5' and actual[i] == '1':
            fp += 1
        elif predict[i] == '1' and actual[i] == '1':
            tn += 1
        elif predict[i] == '1' and actual[i] == '5':
            fn += 1

    precision_pos = float(tp) / (tp + fp) if tp + fp > 0 else 0
    recall_pos = float(tp) / (tp + fn) if tp + fn > 0 else 0
    f_score_pos = (2 * precision_pos * recall_pos) / (precision_pos + recall_pos) if precision_pos + recall_pos > 0 else 0

    precision_neg = float(tn) / (tn + fn) if tn + fn > 0 else 0
    recall_neg = float(tn) / (fp + tn) if fp + tn > 0 else 0
    f_score_neg = (2 * precision_neg * recall_neg) / (precision_neg + recall_neg) if precision_neg + recall_neg > 0 else 0

    return f_score_pos, f_score_neg

data = []

def load_data():
    global data
    try:
        with open('alldata.txt', "r") as f:
            data = f.readlines()
    except FileNotFoundError:
        print("Error: 'alldata.txt' not found.")
        sys.exit(1)

class NaiveBayesTest(unittest.TestCase):

    def test1(self):
        classifier = nbc.Bayes_Classifier()
        classifier.train(data[:12478])
        predictions = classifier.classify(data[12478:])
        fp, fn = f_score(data[12478:], predictions)
        print(f"Positive F1 Score: {fp}, Negative F1 Score: {fn}")
        self.assertGreater(fp, 0.90, "Positive F1 score too low.")
        self.assertGreater(fn, 0.60, "Negative F1 score too low.")

    def test2(self):
        classifier = nbc.Bayes_Classifier()
        classifier.train(data[:12478])
        datacopy = ["5" + d[1:] for d in data]  # Change all sentiments to '5'
        predictions = classifier.classify(datacopy[12478:])
        fp, fn = f_score(data[12478:], predictions)
        print(f"Positive F1 Score on modified data: {fp}, Negative F1 Score on modified data: {fn}")

if __name__ == "__main__":
    load_data()
    unittest.main()
