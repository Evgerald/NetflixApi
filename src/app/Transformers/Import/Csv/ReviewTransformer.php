<?php

namespace App\Transformers\Import\Csv;

/**
 * Review Transformer
 *
 * @version 1.0
 */
class ReviewTransformer extends AbstractCsvTransformer
{
    public static function transform(array $row): array
    {
        $row = array_map('trim', $row);

        // Rating
        // Probably 0 should be changed. Right now to avoid not correct data. Could be used as record without rating
        $rating = trim($row['rating'] ?? 0);
        $row['rating'] = ctype_digit($rating) ? $rating : 0;

        // Review date
        $date = $row['review_date'] ?? null;
        $row['review_date'] = self::normalizeDate($date);

        // Device type
        $allowedDeviceType = ['Mobile', 'Tablet', 'Laptop', 'Smart TV'];
        $type = trim($row['device_type'] ?? '');
        $row['device_type'] = in_array($type, $allowedDeviceType, true) ? $type : 'Mobile';

        // Is verified watch
        $row['is_verified_watch'] = filter_var(
            $row['is_verified_watch'] ?? false, FILTER_VALIDATE_BOOLEAN
        ) ? 1 : 0;

        // Helpful votes
        $row['helpful_votes'] = is_numeric($row['helpful_votes'] ?? 0) ? (float) $row['helpful_votes'] : 0;

        // Total votes
        $row['total_votes'] = is_numeric($row['total_votes'] ?? 0) ? (float) $row['total_votes'] : 0;

        // Device type
        $allowedSentiments = ['neutral', 'positive', 'negative'];
        $sentiment = trim($row['sentiment'] ?? '');
        $row['sentiment'] = in_array($sentiment, $allowedSentiments, true) ? $sentiment : 'neutral';

        // Sentiment score
        $row['sentiment_score'] = is_numeric($row['sentiment_score'] ?? null)
            ? (float)$row['sentiment_score']
            : 0;

        return $row;
    }
}
